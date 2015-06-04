<?php
  //CARROUSEL
    echo CHTML::cssFichero("/estilos/estiloActividades.css");
    echo CHTML::dibujaEtiqueta("div", array("id"=>"slider1_container"), "", false);
        echo CHTML::dibujaEtiqueta("div", array("u"=>"slides", "id"=>"contSlides"), "", false);
            for ($cont=0;$cont<count($filas);$cont++){
                if($filas[$cont]["imagen"]!=""){
                echo CHTML::dibujaEtiqueta("div", array(), "", false);
                    echo CHTML::imagen("../../../imagenes/actividades/".$filas[$cont]["imagen"], "500x500", array("u"=>"image", "class"=>"first-slide"));         
                echo CHTML::dibujaEtiquetaCierre("div");  
                }                     
            }
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div", array("u"=>"navigator", "class"=>"jssorb05"), "", false);
            echo CHTML::dibujaEtiqueta("div", array("u"=>"prototype"), "", true);
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("span", array("u"=>"arrowleft", "class"=>"jssora11l"), "", true);       
        echo CHTML::dibujaEtiqueta("span", array("u"=>"arrowright", "class"=>"jssora11r"), "", true);                  
    echo CHTML::dibujaEtiquetaCierre("div");
 //ACTIVIDADES
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container marketing"), "", false);
            if($filas && count($filas)!==0){
                foreach ($filas as $clave => $valor) {
                    $this->dibujaVistaParcial("listaNovedadesParcial", array("fila"=>$valor, "clave"=>$clave));
                }    
            }
    echo CHTML::dibujaEtiquetaCierre("div"); 
    
    echo CHTML::scriptFichero("script/ie10-viewport-bug-workaround.js");
    echo CHTML::scriptFichero("script/jssor.slider.mini.js");
    echo CHTML::scriptFichero("script/scriptCargaCarrousel.js");
?>
