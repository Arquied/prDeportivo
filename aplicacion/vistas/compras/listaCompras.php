<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
    echo CHTML::scriptFichero("../../script/scriptCrudCompras.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloActividades.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
        //Titulo
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
            echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE COMPRAS", TRUE);
        echo CHTML::dibujaEtiquetaCierre("div");
        
		//FILTRADO
	    echo CHTML::dibujaEtiqueta("div", array("class"=>"contFiltrado"));
            echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                echo CHTML::dibujaEtiqueta("h4", array(), "Campos de filtrado", true);                
            echo CHTML::dibujaEtiquetaCierre("div");

            //FORMULARIO DE FILTRADO
            echo CHTML::iniciarForm("index.php?co=compras&ac=listaCompras", "post", array("role"=>"form"));
                //Campo usuario           
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                    echo CHTML::campoLabel("Usuarios", "cod_usuario");                            
                    echo CHTML::campoListaDropDown("cod_usuario", $usuario, Usuarios::listaUsuarios(), array("class"=>"form-control"));
                echo CHTML::dibujaEtiquetaCierre("div");
                //Campo temporada          
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                    echo CHTML::campoLabel("Temporada", "cod_temporada");                            
                    echo CHTML::campoListaDropDown("cod_temporada", $temporada, Temporadas::listaTemporadas(), array("class"=>"form-control", "id"=>"comboTemporadas"));
                echo CHTML::dibujaEtiquetaCierre("div");
                //Campo actividades           
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                    echo CHTML::campoLabel("Actividades (seleccione temporada)", "cod_actividad");                            
                    echo CHTML::campoListaDropDown("cod_actividad", $actividad, array(), array("class"=>"form-control", "id"=>"comboActividades"));
                echo CHTML::dibujaEtiquetaCierre("div");
				
					                    
                //Boton submit
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                    echo CHTML::campoBotonSubmit("Filtrar", array("class"=>"btn btn-default"));                 
                echo CHTML::dibujaEtiquetaCierre("div");
            
            echo CHTML::finalizarForm();
	    echo CHTML::dibujaEtiquetaCierre("div");
	
		//Bloque actualiza compras
    	echo CHTML::dibujaEtiqueta("div");
    		echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("compras", "actualizarCompras")), "class"=>"btn btn-default"), "Actualizar compras", true);
    	echo CHTML::dibujaEtiquetaCierre("div");
	
        echo CHTML::dibujaEtiqueta("div", array("id"=>"contActividades"));
            echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tActividades"));
                //DIBUJAR CABECERA DE LA TABLA
                echo CHTML::dibujaEtiqueta("thead");
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("th", array(), "COD", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "USUARIO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "IMPORTE PAGADO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "PENDIENTE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "F. COMPRA", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "F. INICIO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "F. FIN", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "IMPORTE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "ANULADO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                    echo CHTML::dibujaEtiquetaCierre("tr");
                echo CHTML::dibujaEtiquetaCierre("thead");
                
                //DIBUJAR CUERPO DE LA TABLA
                echo CHTML::dibujaEtiqueta("tbody");
                    foreach ($filas as $fila) {
                        echo CHTML::dibujaEtiqueta("tr");
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["cod_compra"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["usuario"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["actividad"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["importe_pagado"], true);
                            if ($fila["pendiente"]){
                                echo CHTML::dibujaEtiqueta("td", array(), "NO PAGADO", true);
                            }
                            else {
                                echo CHTML::dibujaEtiqueta("td", array(), "PAGADO", true);
                            }
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_compra"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_inicio"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_fin"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["importe"], true);
                            if($fila["anulado"]){
                                echo CHTML::dibujaEtiqueta("td", array(), "ANULADO", true);
                            }
                            else{
                                echo CHTML::dibujaEtiqueta("td", array(), "ACTIVO", true);
                            }
                            echo CHTML::dibujaEtiqueta("td");
                                if ($fila["pendiente"]){
                                    echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("pagos"), array("cod_compra"=>$fila["cod_compra"])), "title"=>"Realizar pago"));                         
                                        echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_pagar.png"));
                                    echo CHTML::dibujaEtiquetaCierre("a");
                                }
                                echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnAnular", "title"=>"Anular Compra"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");
                            echo CHTML::dibujaEtiquetaCierre("td");
                        echo CHTML::dibujaEtiquetaCierre("tr");
                    }            
                echo CHTML::dibujaEtiquetaCierre("tbody");
            echo CHTML::dibujaEtiquetaCierre("table");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::script("$('#tActividades').dynatable();");
        
        //VENTANA MODAL MENSAJE BORRADO
        echo CHTML::dibujaEtiqueta("div", array("id"=>"modalAnular", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
                echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
                echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar Anulación", true);
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
                echo CHTML::dibujaEtiqueta("p", array(), "¿Desea anular la compra?", true);
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
                echo CHTML::boton("Anular", array("id"=>"seguroAnular", "class"=>"btn"));
                echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
    
    echo CHTML::dibujaEtiquetaCierre("div"); 
