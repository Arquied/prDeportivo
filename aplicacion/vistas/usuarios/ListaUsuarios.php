<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloUsuarios.css");
	
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
	    //Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
    	echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "USUARIOS REGISTRADOS EN ".$actividad->nombre, TRUE);
    echo CHTML::dibujaEtiquetaCierre("div");
	
    echo CHTML::dibujaEtiqueta("div", array("id"=>"contUsuarios"));
        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tUsuarios"));
            //DIBUJAR CABECERA DE LA TABLA
            echo CHTML::dibujaEtiqueta("thead");
                echo CHTML::dibujaEtiqueta("tr");
                    echo CHTML::dibujaEtiqueta("th", array(), "NOMBRE", TRUE);
                    echo CHTML::dibujaEtiqueta("th", array(), "USUARIO", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "TELEFONO", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "CORREO", TRUE);
					echo CHTML::dibujaEtiqueta("th", array(), "FOTO", TRUE);
                echo CHTML::dibujaEtiquetaCierre("tr");
            echo CHTML::dibujaEtiquetaCierre("thead");
            
            //DIBUJAR CUERPO DE LA TABLA
            echo CHTML::dibujaEtiqueta("tbody");
                foreach ($filas as $fila) {
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["nombre"], true);
                        echo CHTML::dibujaEtiqueta("td", array(), $fila["nick"], true);
						echo CHTML::dibujaEtiqueta("td", array(), $fila["telefono"], true);
						echo CHTML::dibujaEtiqueta("td", array(), $fila["correo"], true);
						echo CHTML::dibujaEtiqueta("td", array());
						if($fila["foto"]!=""){
    						echo CHTML::imagen("../../imagenes/usuarios/".$fila["foto"]);	
    					} 
						echo CHTML::dibujaEtiquetaCierre("td");
                    echo CHTML::dibujaEtiquetaCierre("tr");
                }            
            echo CHTML::dibujaEtiquetaCierre("tbody");
        echo CHTML::dibujaEtiquetaCierre("table");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::script("$('#tUsuarios').dynatable();");
	
	echo CHTML::dibujaEtiquetaCierre("div");
	
