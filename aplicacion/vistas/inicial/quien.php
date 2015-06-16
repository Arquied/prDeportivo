<?php
echo CHTML::dibujaEtiqueta("div",array("class"=>"container"));
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
        echo CHTML::dibujaEtiqueta("h2", array(), "Quien Somos", true);                
   echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("p",array(),$configuracion->descripcion,true);
echo CHTML::dibujaEtiqueta("p",array(),"Dirección: ".$configuracion->direccion.", ".$configuracion->localidad.", ".$configuracion->provincia,true);
echo CHTML::dibujaEtiqueta("p",array(),"Telefono/Movil: ".$configuracion->telefono." / ".$configuracion->movil,true);
echo CHTML::dibujaEtiqueta("p",array(),"Correo electronico: ".$configuracion->correo,true);
echo CHTML::dibujaEtiqueta("p", array(),"Url facebook: ".$configuracion->url_facebook,true);
echo CHTML::dibujaEtiqueta("p", array(), "Url twitter: ".$configuracion->url_twitter,true);
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
