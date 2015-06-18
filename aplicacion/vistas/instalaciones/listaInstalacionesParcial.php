<?php

echo CHTML::dibujaEtiqueta("div", array("class"=>"contInstalacion"));
    //Nombre de la actividad
    echo CHTML::dibujaEtiqueta("h1", array(), $fila["nombre"], true);

    echo CHTML::dibujaEtiqueta("div", array("class"=>"row featurette"));
        //Informacion de la actividad
        if($clave%2==0)
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-7"));
        else 
           echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-7 col-md-push-5")); 
            echo CHTML::dibujaEtiqueta("div", array("class"=>"contBtn"));
                echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array('calendarios', 'mostrarCalendario'), array("cod_instalacion"=>$fila["cod_instalacion"])),
                                                    "class"=>"btn btn-default btn-lg"), "Ver");
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiqueta("div", array("class"=>"lead"), $fila["descripcion"], true);
        echo CHTML::dibujaEtiquetaCierre("div");
        
        //Imagen actividad
        if($clave%2==0)
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-5 imagen"));
        else 
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-5 col-md-pull-7 imagen")); 
		
			//si existe imagen si no se inserta una por defecto
    		if($fila["imagen"]!=""){
    			echo CHTML::imagen("../../imagenes/instalaciones/".$fila["imagen"], "500x500", array("class"=>"featurette-image img-responsive center-block"));	
    		}    
			else{
				echo CHTML::imagen("../../imagenes/Imagen_no_disponible.svg.png", "500x500", array("class"=>"featurette-image img-responsive center-block"));
			}
            
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("hr", array("class"=>"featurette-divider"));
