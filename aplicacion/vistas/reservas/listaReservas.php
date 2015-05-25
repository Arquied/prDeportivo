<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
    echo CHTML::scriptFichero("../../script/scriptReservasUsuario.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloPerfil.css");
    
    //Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
        echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "MIS RESERVAS", TRUE);
    echo CHTML::dibujaEtiquetaCierre("div");


    echo CHTML::dibujaEtiqueta("div", array("id"=>"contListaReservas"));
        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tReservas"));
            //DIBUJAR CABECERA DE LA TABLA
            echo CHTML::dibujaEtiqueta("thead");
                echo CHTML::dibujaEtiqueta("tr");
                    echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA DE RESERVA", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "TARIFA", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "ANULACIÓN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA DE ANULACIÓN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                echo CHTML::dibujaEtiquetaCierre("tr");
            echo CHTML::dibujaEtiquetaCierre("thead");
            
            //DIBUJAR CUERPO DE LA TABLA
            echo CHTML::dibujaEtiqueta("tbody");
                foreach ($filas as $fila) {
                    echo CHTML::dibujaEtiqueta("tr", array("id"=>$fila["cod_reserva"]));
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["nombre"], true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_reserva"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_inicio"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_fin"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["tarifa"], true);
                        if($fila["anulado"]){
                            echo CHTML::dibujaEtiqueta("td", array(), "Anulado", true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_anulacion"]), true);
                        }
                        else{
                            echo CHTML::dibujaEtiqueta("td", array(), "Activo", true);
                            echo CHTML::dibujaEtiqueta("td", array(), "", true);
                        }
                        echo CHTML::dibujaEtiqueta("td");
                            $fecha=new DateTime("now");
                            $fecha_inicio=new DateTime($fila["fecha_inicio"]); 							
							
                            if($fecha->diff($fecha_inicio)->format("%a")>1) $disable=true;
                            else $disable=false;
                            if($disable){
                                echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnAnular", "title"=>"Anular reserva"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");  
                            }     
                        echo CHTML::dibujaEtiquetaCierre("td");
                    echo CHTML::dibujaEtiquetaCierre("tr");
                }            
            echo CHTML::dibujaEtiquetaCierre("tbody");
        echo CHTML::dibujaEtiquetaCierre("table");
    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::script("$('#tActividades').dynatable();");
    
    
    //VENTANA MODAL MENSAJE ANULADO
    echo CHTML::dibujaEtiqueta("div", array("id"=>"modalAnulado", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
            echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
            echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar anulación", true);
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
            echo CHTML::dibujaEtiqueta("p", array(), "¿Desea anular reserva?", true);
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
            echo CHTML::boton("Anular", array("id"=>"seguroAnular", "class"=>"btn"));
            echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");    
    

