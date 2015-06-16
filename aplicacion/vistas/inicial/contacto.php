<?php

echo CHTML::cssFichero("/estilos/estiloFormularios.css");

echo CHTML::dibujaEtiqueta("div",array("class"=>"container"));
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
        echo CHTML::dibujaEtiqueta("h2", array(), "Contacta con nosotros", true);                
   	echo CHTML::dibujaEtiquetaCierre("div");
	echo CHTML::dibujaEtiqueta("div");
		echo CHTML::dibujaEtiqueta("p",array(),"Llámenos a: ".$configuracion->telefono." / ".$configuracion->movil,true);
		echo CHTML::dibujaEtiqueta("p",array(),"Envianos un email a la dirección: ".$configuracion->correo,true);
		echo CHTML::dibujaEtiqueta("p", array(),"Visita nuestra pagina de facebook: <a>".$configuracion->url_facebook."</a>",true);
		echo CHTML::dibujaEtiqueta("p", array(), "Visita nuestra página de twitter: <a>".$configuracion->url_twitter."</a>",true);
	echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
