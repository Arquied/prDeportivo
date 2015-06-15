<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudCompras.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloCompras.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
	
	    //Titulo
	    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
	        echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE COMPRAS", TRUE);
	    echo CHTML::dibujaEtiquetaCierre("div");
		
	    echo CHTML::dibujaEtiqueta("div", array("id"=>"contCompras"));
	        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tCompras"));
	            //DIBUJAR CABECERA DE LA TABLA
	            echo CHTML::dibujaEtiqueta("thead");
	                echo CHTML::dibujaEtiqueta("tr");
	                    echo CHTML::dibujaEtiqueta("th", array(), "CÓDIGO", TRUE);
	                    echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
	                    echo CHTML::dibujaEtiqueta("th", array(), "IMPORTE_PAGADO", TRUE);
						echo CHTML::dibujaEtiqueta("th", array(), "PENDIENTE", TRUE);
	                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA COMPRA", TRUE);
	                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
	                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
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
	                        echo CHTML::dibujaEtiqueta("td", array(), Actividades::listaActividades($fila["cod_actividad"]), true);
							echo CHTML::dibujaEtiqueta("td", array(), $fila["importe_pagado"], true);
							if ($fila["pendiente"]){
								echo CHTML::dibujaEtiqueta("td", array(), "NO PAGADO", true);
							}
							else {
								echo CHTML::dibujaEtiqueta("td", array(), "PAGADO", true);
							}
							echo CHTML::dibujaEtiqueta("td", array(), $fila["fecha_compra"], true);
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
								if ($fila["pendiente"])
	                          	    echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("pagos"), array("cod_compra"=>$fila["cod_compra"]))));
								else 
									echo CHTML::dibujaEtiqueta("a", array("disabled"));
	                                echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_pagar.png"));
	                            echo CHTML::dibujaEtiquetaCierre("a");
	                            echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnAnular"));
	                                echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
	                            echo CHTML::dibujaEtiquetaCierre("a");
	                        echo CHTML::dibujaEtiquetaCierre("td");
	                    echo CHTML::dibujaEtiquetaCierre("tr");
	                }            
	            echo CHTML::dibujaEtiquetaCierre("tbody");
	        echo CHTML::dibujaEtiquetaCierre("table");
	    echo CHTML::dibujaEtiquetaCierre("div");
	
	    echo CHTML::script("$('#tCompras').dynatable();");
		
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
