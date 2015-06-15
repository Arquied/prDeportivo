<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudHorarios.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloHorarios.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
	
    //Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
        echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE HORARIOS", TRUE);
    echo CHTML::dibujaEtiquetaCierre("div");
	
	echo CHTML::dibujaEtiqueta("div");
	echo CHTML::dibujaEtiqueta("a",array("href"=>Sistema::app()->generaURL(array("horarios", "nuevoHorario")), "class" => "btn btn-default"),"Nuevo");
	echo CHTML::dibujaEtiquetaCierre("div");
	
    echo CHTML::dibujaEtiqueta("div", array("id"=>".contHorario"));
        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tHorario"));
            //DIBUJAR CABECERA DE LA TABLA
            echo CHTML::dibujaEtiqueta("thead");
                echo CHTML::dibujaEtiqueta("tr");
                    echo CHTML::dibujaEtiqueta("th", array(), "CÓDIGO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "TEMPORADA", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "DIA", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "HORA INICIO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "HORA FIN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "DISPONIBLE", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                echo CHTML::dibujaEtiquetaCierre("tr");
            echo CHTML::dibujaEtiquetaCierre("thead");
            
            //DIBUJAR CUERPO DE LA TABLA
            echo CHTML::dibujaEtiqueta("tbody");
                foreach ($filas as $fila) {
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["cod_horario_general"], true);
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["temporada"], true);
						echo CHTML::dibujaEtiqueta("td", array(), $fila["dia"], true);
						echo CHTML::dibujaEtiqueta("td", array(), $fila["hora_inicio"], true);
						echo CHTML::dibujaEtiqueta("td", array(), $fila["hora_fin"], true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_inicio"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_fin"]), true);
						if($fila["disponible"]){
							echo CHTML::dibujaEtiqueta("td", array(), "Disponible", true);
						}
						else{
							echo CHTML::dibujaEtiqueta("td", array(), "No disponible", true);
						}
                        echo CHTML::dibujaEtiqueta("td");
                            echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("horarios", "modificaHorario"), array("cod_horario_general"=>$fila["cod_horario_general"]))));
                                echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_edit.png"));
                            echo CHTML::dibujaEtiquetaCierre("a");
                            echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnBorrar"));
                                echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
                            echo CHTML::dibujaEtiquetaCierre("a");
                        echo CHTML::dibujaEtiquetaCierre("td");
                    echo CHTML::dibujaEtiquetaCierre("tr");
                }            
            echo CHTML::dibujaEtiquetaCierre("tbody");
        echo CHTML::dibujaEtiquetaCierre("table");
    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::script("$('#tHorario').dynatable();");
    
	
	//VENTANA MODAL MENSAJE BORRADO
	echo CHTML::dibujaEtiqueta("div", array("id"=>"modalBorrado", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
			echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
			echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar borrado", true);
		echo CHTML::dibujaEtiquetaCierre("div");
		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
			echo CHTML::dibujaEtiqueta("p", array(), "¿Desea borrar horario?", true);
		echo CHTML::dibujaEtiquetaCierre("div");
		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
			echo CHTML::boton("Borrar", array("id"=>"seguroBorrar", "class"=>"btn"));
			echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
		echo CHTML::dibujaEtiquetaCierre("div");
		
	echo CHTML::dibujaEtiquetaCierre("div");		
		
	echo CHTML::dibujaEtiquetaCierre("div");	
