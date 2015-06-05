<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudActividades.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloActividades.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
        //Titulo
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
            echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE ACTIVIDADES", TRUE);
        echo CHTML::dibujaEtiquetaCierre("div");
    
    	//Bloque nueva actividad
    	echo CHTML::dibujaEtiqueta("div", array());
    		echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("actividades", "nuevaActividad")), "class"=>"btn btn-default"), "Nueva actividad", true);
    	echo CHTML::dibujaEtiquetaCierre("div");
    
        echo CHTML::dibujaEtiqueta("div", array("id"=>"contListaActividades"));
            echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tActividades"));
                //DIBUJAR CABECERA DE LA TABLA
                echo CHTML::dibujaEtiqueta("thead");
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("th", array(), "CÓDIGO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "NOMBRE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "TEMPORADA", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "DISPONIBLE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "TARIFAS", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                    echo CHTML::dibujaEtiquetaCierre("tr");
                echo CHTML::dibujaEtiquetaCierre("thead");
                
                //DIBUJAR CUERPO DE LA TABLA
                echo CHTML::dibujaEtiqueta("tbody");
                    foreach ($filas as $fila) {
                    	$tipoCuota=new TiposCuota();
						$listaTarifas=$tipoCuota->buscarTodos(array("select"=>" t.tipo, tar.precio ",
														"from"=>" join tarifas tar using(cod_tipo_cuota)",
														"where"=>" tar.cod_actividad=".$fila["cod_actividad"]));
						
                        echo CHTML::dibujaEtiqueta("tr");
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["cod_actividad"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["nombre"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["temporada"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_inicio"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_fin"]), true);
    						//Si esta disponible o no
    						if($fila["disponible"]){
    							echo CHTML::dibujaEtiqueta("td", array(), "Disponible", true);
    						}
    						else{
    							echo CHTML::dibujaEtiqueta("td", array(), "No disponible", true);
    						}
    						//Lista tarifas
    						echo CHTML::dibujaEtiqueta("td");
    						foreach ($listaTarifas as $tarifa) {
								echo $tarifa["precio"]."€/".$tarifa["tipo"]."\n<br>";		
							}
							echo CHTML::dibujaEtiquetaCierre("td");
							
							//Opciones
                            echo CHTML::dibujaEtiqueta("td");
    							echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("tarifas", "nuevaTarifa"), array("cod_actividad"=>$fila["cod_actividad"])), "title"=>"Añadir tarifa"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_money.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");
                                echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("actividades", "modificaActividad"), array("cod_actividad"=>$fila["cod_actividad"])), "title"=>"Modificar actividad"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_edit.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");
                                echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnBorrar", "title"=>"Borrar actividad"));
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
    	echo CHTML::dibujaEtiqueta("div", array("id"=>"modalBorrado", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
    			echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
    			echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar borrado", true);
    		echo CHTML::dibujaEtiquetaCierre("div");
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
    			echo CHTML::dibujaEtiqueta("p", array(), "¿Desea borrar actividad?", true);
    		echo CHTML::dibujaEtiquetaCierre("div");
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
    			echo CHTML::boton("Borrar", array("id"=>"seguroBorrar", "class"=>"btn"));
    			echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
    		echo CHTML::dibujaEtiquetaCierre("div");
    	echo CHTML::dibujaEtiquetaCierre("div");	
	
    echo CHTML::dibujaEtiquetaCierre("div");

    
