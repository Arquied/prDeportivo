<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudActividades.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloCalendario.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);

    //Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
        echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE CALENDARIOS", TRUE);
    echo CHTML::dibujaEtiquetaCierre("div");
	
	echo CHTML::dibujaEtiqueta("div");
	echo CHTML::dibujaEtiqueta("a",array("href"=>Sistema::app()->generaURL(array("calendarios", "nuevoCalendario")), "class" => "btn btn-default"),"Nuevo calendario");
	echo CHTML::dibujaEtiquetaCierre("div");
	
    echo CHTML::dibujaEtiqueta("div", array("id"=>"contCalendario"));
        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tCalendario"));
            //DIBUJAR CABECERA DE LA TABLA
            echo CHTML::dibujaEtiqueta("thead");
                echo CHTML::dibujaEtiqueta("tr");
                    echo CHTML::dibujaEtiqueta("th", array(), "CÓDIGO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "DIA", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "HORA INICIO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "HORA FIN", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "INSTALACION", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "DISPONIBLE", TRUE);

                    echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                echo CHTML::dibujaEtiquetaCierre("tr");
            echo CHTML::dibujaEtiquetaCierre("thead");
			
    echo CHTML::dibujaEtiquetaCierre("div");

            //DIBUJAR CUERPO DE LA TABLA
            echo CHTML::dibujaEtiqueta("tbody");
			
                for ($cont=0;$cont<count($filas);$cont++) {
             		echo CHTML::dibujaEtiqueta("tr");
                	    echo CHTML::dibujaEtiqueta("td", array(), $filas[$cont]["cod_calendario"], true);
                   	    echo CHTML::dibujaEtiqueta("td", array(), $filas[$cont]["actividad"], true);
					    echo CHTML::dibujaEtiqueta("td", array(), $filas[$cont]["dia"], true);
				 	    echo CHTML::dibujaEtiqueta("td", array(), $filas[$cont]["hora_inicio"], true);
				        echo CHTML::dibujaEtiqueta("td", array(), $filas[$cont]["hora_fin"], true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($filas[$cont]["fecha_inicio"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($filas[$cont]["fecha_fin"]), true);
                        echo CHTML::dibujaEtiqueta("td", array(), Instalaciones::listaInstalacion($filas[$cont]["cod_calendario"]),true);
						if($filas[$cont]["disponible"]){
							echo CHTML::dibujaEtiqueta("td", array(), "Disponible", true);
						}
						else{
							echo CHTML::dibujaEtiqueta("td", array(), "No disponible", true);
						}
                        echo CHTML::dibujaEtiqueta("td");
                            echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("calendarios", "modificaCalendario"), array("cod_calendario"=>$filas[$cont]["cod_calendario"]))));
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

    echo CHTML::script("$('#tCalendario').dynatable();");
    
	
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
