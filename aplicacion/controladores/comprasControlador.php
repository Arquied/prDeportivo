<?php
     
    class comprasControlador extends CControlador{
        
        public function accionFacturaPDF(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("compras", "facturaPDF"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array($_REQUEST["cod_compra"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if(isset($_REQUEST["cod_compra"])){
                $compra=new Compras();
                $sentSelect=" t.*, a.nombre as actividad, u.nombre as nombreUsuario, u.dni, u.telefono ";
                $sentFrom=" join reservas r using(cod_reserva) ".
                            " join actividades a using(cod_actividad) ".
                            " join usuarios u using(cod_usuario) ";
                $sentWhere=" cod_compra=".intval($_REQUEST["cod_compra"]);
                
                $factura=$compra->buscarTodos(array("select"=>$sentSelect, "from"=>$sentFrom, "where"=>$sentWhere));
                
                if($factura){
                    //var_dump($factura[0]['nombreUsuario']);
                    $configuracion=new Configuracion();
                    $configuracion->buscarPorId(1);
                    
                    $contenido=
                        "<style>
                            *{
                                margin: 0;
                                padding: 0;
                                font-family: Arial;
                            }
                            .datosFactura{
                                width: 50%;
                            }
                            table{
                                width: 100%;
                                margin: 20px 0;
                            }                           
                            .tFactura td{
                               text-align:center; 
                               font-size: 14pt;
                            }
                            .tFactura th{
                                padding: 10px 20px;
                                border-bottom: 1px solid white;
                                background:  rgb(140, 3, 21);
                                color: white;
                                text-align:center;
                            }                           
                            .tFactura tbody td{
                                padding: 10px 0;
                                font-size: 14pt;
                                border-bottom: 1px solid rgb(140, 3, 21);
                            }
                            .tFactura tfoot td{
                                text-align: right;
                            }
                            .datosFactura h3{
                                color: rgb(140,3,21);
                                font-size: 15pt;
                            }                                               
                        </style>".
                        
                        "<page>".                           
                            "<div>".
                                "<table>".
                                    "<tr>".
                                        "<td><h2>Factura compra</h2><td>";
                                    if($configuracion->logo!=""){
                                        $contenido.="<td><img src='imagenes/".$configuracion->logo."' width='200px' height='100px' /></td>";
                                    }
                                    else{
                                        $contenido="<td></td>";   
                                    }    
                                    $contenido="</tr>".
                                "</table>".
                            "</div>".
                            "<table>".
                                 "<tr>".
                                    "<td class='datosFactura'>".
                                        "<h3>$configuracion->nombre_empresa</h3>".
                                        "<p>".
                                            "<p>CIF: $configuracion->cif</p>".
                                            "<p>Dirección: C/ El Euro 23</p>".
                                            "<p>Localidad: Antequera</p>".
                                            "<p>Provincia: Málaga</p>".             
                                        "</p>".
                                    "</td>".
                                    "<td class='datosFactura'>".
                                        "<h3>{$factura[0]['nombreUsuario']}</h3>".
                                        "<p>".
                                            "<p>NIF: {$factura[0]['dni']}</p>".             
                                            "<p>Dirección: C/ El Euro 23</p>".
                                            "<p>Localidad: Antequera</p>".
                                            "<p>Provincia: Málaga</p>".             
                                        "</p>".
                                    "</td>".
                                  "</tr>".
                            "</table>".
                            "<div>".
                                "Fecha compra: {$factura[0]['fecha_compra']}".
                            "</div>".
                            "<table class='tfactura'>".
                                "<thead>".
                                    "<tr>".
                                        "<th style='width:33%'>ACTIVIDAD</th>".
                                        "<th style='width:33%'>FECHA DE INICIO</th>".
                                        "<th style='width:33%'>FECHA DE FIN</th>".
                                    "</tr>".
                                "</thead>".
                                "<tbody>".
                                    "<tr class='datos'>".
                                        "<td style='width:33%'>{$factura[0]['actividad']}</td>".
                                        "<td style='width:33%'>".CGeneral::fechaMysqlANormal($factura[0]['fecha_inicio'])."</td>".
                                        "<td style='width:33%'>".CGeneral::fechaMysqlANormal($factura[0]['fecha_fin'])."</td>".
                                    "</tr>".
                                "</tbody>".
                                "<tfoot>".
                                    "<tr>".
                                        "<td colspan=2>Importe Total</td>".
                                        "<td>{$factura[0]['importe']}</td>".                    
                                    "</tr>".
                                    "<tr>".
                                        "<td colspan=2>Pagado</td>".
                                        "<td>{$factura[0]['importe_pagado']}</td>".
                                    "</tr>".                                        
                                "</tfoot>".
                            "</table>".                             
                        "</page>";
                        
                        // convert to PDF
                       
                            $html2pdf = new HTML2PDF('P', 'A4', 'es');
                            $html2pdf->pdf->SetDisplayMode('fullpage');
                            $html2pdf->writeHTML($contenido);
                            $html2pdf->Output('f.pdf');
                        
                }
                else{
                    Sistema::app()->paginaError(400, "La factura no se encuentra");
                }
            }
        }
        public function accionListaCompras(){
                
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                  Sistema::app() -> sesion() -> set("pagPrevia", array("compras","listaCompras"));
                  Sistema::app() -> sesion() -> set("parametrosAnt", array());
                  Sistema::app() -> irAPagina(array("inicial", "login"));
                  exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                  Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                  exit ;
            } 
            else {
                
                $reservas = new Reservas();
                $filas = $reservas -> buscarTodos(array("select c.*","from"=>"inner join compras as c on c.cod_reserva=t.cod_reserva", "where"=>"t.cod_usuario=$_GET[cod_usuario]"));                                   
                $this->dibujaVista("listaCompras",array("filas"=>$filas), "Lista de Compras");
                
            }
        }
        
        public function accionPagarCompra(){
            
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar         
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("compras", "CompraPagado"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                  Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                  exit ;
            } 
            else{
                
                $reserva = new Reservas();
                $compra = new Compras();
                
                if($compra->buscarPorId($_REQUEST["id"])){
                    $compra -> pendiente = 0;
                    $compra -> importe_pagado = $compra -> importe;
                    $reserva -> buscarPorId($compra -> cod_reserva);
                    
                    if ($compra->validar()) {
                        if(!$compra->guardar()){
                            $this->dibujaVista("anularCompra", array("modelo"=>$compra),"Anular Compra");
                            exit;
                        }
                        Sistema::app()->irAPagina(array("compras", "listaCompras"), array("cod_usuario"=>$reserva->cod_usuario));
                        exit;
                    }
                    else {
                        $this -> dibujaVista("anularCompra", array("modelo"=>$compra),"Anular Compra");
                        exit;
                    }
                }
                 Sistema::app()->paginaError(400,"La Compra no se encuentra");
            }
        }
        public function accionAnularCompra(){            
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("compras", "AnularCompra"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            else if(!Sistema::app()->acceso()->puedeConfigurar()){
                Sistema::app()->paginaError(400, "No tiene permiso para acceder");  
                exit;
            }
            else{
                $compra = new Compras();
                $reserva = new Reservas();
                if ($compra->buscarPorId($_REQUEST["id"])){
                    $compra -> anulado=1;
                    $reserva -> buscarPorId($compra -> cod_reserva);
                    if ($compra->validar()) {
                        if(!$compra->guardar()){
                            Sistema::app()->paginaError(400, "Error al borrar anular compra");
                            exit ;
                        }
                        Sistema::app()->irAPagina(array("compras", "listaCompras"), array("cod_usuario"=>$reserva->cod_usuario));
                        exit;
                    }
                    else {
                        Sistema::app()->paginaError(400, "Error al anular compra");
                        exit ;
                    }
                }
                Sistema::app()->paginaError(400,"La Compra no se encuentra");
            } 
            
        }    
        
        public function accionActualizarCompras(){            
            $reserva=new Reservas();  
            $hoy=new DateTime();
            
            //Si la fecha actual es primero de mes            
            $primerDiaMes=new DateTime(); $primerDiaMes->modify('first day of this month');
            $dia16=new DateTime(); $dia16->modify('first day of this month'); $dia16->add(new DateInterval("P15D"));
            $diaSemana=date("N");
            //Busca reservas fecha_fin>hoy y tarifa sea mensual o quincenal o diaria
            if($hoy->format("d/m/Y")==$primerDiaMes->format("d/m/Y")){                
                $sentFrom=" join tarifas tar using(cod_tarifa) ".
                            " join tipos_cuotas tc using(cod_tipo_cuota) ";
                $sentWhere=" t.anulado=0 and (tc.mensual=1 or tc.quincenal=1 or tc.diario=1) and t.fecha_fin>='".$hoy->format("Y-m-d")."'";
                $listaReservas=$reserva->buscarTodos(array("from"=>$sentFrom, "where"=>$sentWhere));
                foreach ($listaReservas as $datosReserva) {
                    $compra=new Compras();
                    //Calcular fecha fin, sea mensual, quincenal, diario
                    $fecha_fin=new DateTime(); 
                    if($datosReserva["quincenal"]){ 
                        $fecha_fin->add(new DateInterval("P14D"));
                    }
                    else if($datosReserva["mensual"]){
                       $fecha_fin->modify('last day of this month');    
                    }
                    $compra->setValores(array("cod_reserva"=>$datosReserva["cod_reserva"],
                                                "fecha_compra"=>$hoy->format("d/m/Y"),
                                                "fecha_inicio"=>$hoy->format("d/m/Y"),
                                                "fecha_fin"=>$fecha_fin->format("d/m/Y"),
                                                "importe"=>$datosReserva["precio"]));
                    if($compra->validar()){
                        $compra->guardar();
                    }
                }    
            }
            //Si la fecha actual es dia 16, compras tarifa quincenal o diario, y la f_fin sea mayor a hoy
            else if($hoy->format("d/m/Y")==$dia16->format("d/m/Y")){
                $sentFrom=" join tarifas tar using(cod_tarifa) ".
                            " join tipos_cuotas tc using(cod_tipo_cuota) ";
                $sentWhere=" t.anulado=0 and (tc.quincenal=1 or tc.diario=1) and t.fecha_fin>='".$hoy->format("Y-m-d")."'";
                $listaReservas=$reserva->buscarTodos(array("from"=>$sentFrom, "where"=>$sentWhere));  
                foreach ($listaReservas as $datosReserva) {
                    $compra=new Compras();
                    $fecha_fin=new DateTime();
                    if($datosReserva["quincenal"]){
                        $fecha_fin->modify('last day of this month');
                    }
                    $compra->setValores(array("cod_reserva"=>$datosReserva["cod_reserva"],
                                                "fecha_compra"=>$hoy->format("d/m/Y"),
                                                "fecha_inicio"=>$hoy->format("d/m/Y"),
                                                "fecha_fin"=>$fecha_fin->format("d/m/Y"),
                                                "importe"=>$datosReserva["precio"]));
                    if($compra->validar()){
                        $compra->guardar();
                    }
                }  
            }
            //Si la fecha actual es lunes, reservas tarifa semanal o diario, y la f_fin sea mayor a hoy
            else if(date("N")=="1"){
                $sentFrom=" join tarifas tar using(cod_tarifa) ".
                            " join tipos_cuotas tc using(cod_tipo_cuota) ";
                $sentWhere=" t.anulado=0 and (tc.semanal=1 or tc.diario=1) and t.fecha_fin>='".$hoy->format("Y-m-d")."'";
                $listaReservas=$reserva->buscarTodos(array("from"=>$sentFrom, "where"=>$sentWhere));  
                foreach ($listaReservas as $datosReserva) {
                    $compra=new Compras();
                    $fecha_fin=new DateTime();
                    if($datosReserva["semanal"]){
                        $fecha_fin->modify('next sunday');
                    }
                    $compra->setValores(array("cod_reserva"=>$datosReserva["cod_reserva"],
                                                "fecha_compra"=>$hoy->format("d/m/Y"),
                                                "fecha_inicio"=>$hoy->format("d/m/Y"),
                                                "fecha_fin"=>$fecha_fin->format("d/m/Y"),
                                                "importe"=>$datosReserva["precio"]));
                    if($compra->validar()){
                        $compra->guardar();
                    }
                }   
            }
            //Si no es ninguna de las anteriores obtener las reservas en las que la tarifa es diaria
            else{
                $sentFrom=" join tarifas tar using(cod_tarifa) ".
                            " join tipos_cuotas tc using(cod_tipo_cuota) ";
                $sentWhere=" t.anulado=0 and (tc.diario=1) and t.fecha_fin>='".$hoy->format("Y-m-d")."'";
                $listaReservas=$reserva->buscarTodos(array("from"=>$sentFrom, "where"=>$sentWhere));  
                foreach ($listaReservas as $datosReserva) {
                    $compra=new Compras();                    
                    $compra->setValores(array("cod_reserva"=>$datosReserva["cod_reserva"],
                                                "fecha_compra"=>$hoy->format("d/m/Y"),
                                                "fecha_inicio"=>$hoy->format("d/m/Y"),
                                                "fecha_fin"=>$hoy->format("d/m/Y"),
                                                "importe"=>$datosReserva["precio"]));
                    if($compra->validar()){
                        $compra->guardar();
                    }
                }     
            }              
        }   
    }
    
