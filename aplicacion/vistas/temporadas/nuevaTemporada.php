<?php
// OBTENER ERRORES
$errores = $modelo -> getErrores();
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    echo CHTML::cssFichero("../../estilos/jquery.datetimepicker.css");
    echo CHTML::scriptFichero("../../script/jquery.js");
    echo CHTML::scriptFichero("../../script/jquery.datetimepicker.js");
    echo CHTML::scriptFichero("../../script/scriptFecha.js");
echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
echo CHTML::dibujaEtiqueta("h2", array(), "Temporada Nueva", true);                
 echo CHTML::dibujaEtiquetaCierre("div");
 //CONTENEDOR ERRORES
echo CHTML::dibujaEtiqueta("div");
	foreach ($errores as $error) {
		echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
	}
echo CHTML::dibujaEtiquetaCierre("div");
// FORMULARIO DE NUEVA TEMPORADA
echo CHTML:: iniciarForm("#","POST",array("role"=>"form"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"col-sm-offset-3 col-sm-6"));
// Campo nombre
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre", array("maxlength"=>50, "size"=>51, "class"=>"form-control"));
echo CHTML::dibujaEtiquetaCierre("div");
// Campo fecha_inicio
echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "fecha_inicio");
echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control", "id"=>"fecha_inicio", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy")); 
echo CHTML::dibujaEtiquetaCierre("div");
// Campo fecha_fin
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "fecha_fin");
echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control", "id"=>"fecha_fin", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy")); 
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
// Boton insertar
echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::campoBotonSubmit("Nueva", array("class"=>"btn btn-default"));
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
