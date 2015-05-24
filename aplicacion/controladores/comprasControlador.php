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
								"<h2>Factura compra</h2>".
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
		
	}
			
