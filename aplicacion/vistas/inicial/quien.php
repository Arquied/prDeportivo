<?php


echo CHTML::dibujaEtiqueta("div",array("class"=>"container"));

    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
    	echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
    	echo CHTML::dibujaEtiqueta("h2", array(), "Quien Somos", true);                
   echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div");

echo CHTML::dibujaEtiqueta("p",array(),$configuracion[0]["descripcion"],true);
echo CHTML::dibujaEtiqueta("p",array(),"Dirección: ".$configuracion[0]["direccion"],true);
echo CHTML::dibujaEtiqueta("p",array(),"Telefono: ".$configuracion[0]["telefono"],true);
echo CHTML::dibujaEtiqueta("p",array(),"Correo electronico: ".$configuracion[0]["correo"],true);
echo CHTML::dibujaEtiqueta("p", array(),"Url facebook: ".$configuracion[0]["url_facebook"],true);
echo CHTML::dibujaEtiqueta("p", array(), "Url twitter: ".$configuracion[0]["url_twitter"],true);

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");
