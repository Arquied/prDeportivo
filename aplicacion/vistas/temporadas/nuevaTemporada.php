<?php

// OBTENER ERRORES
$errores = $modelo -> getErrores();

echo CHTML::cssFichero("/estilos/estiloFormularios.css");

echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
echo CHTML::dibujaEtiqueta("h2", array(), "Temporada Nueva", true);                
 echo CHTML::dibujaEtiquetaCierre("div");

// FORMULARIO DE NUEVA TEMPORADA
echo CHTML:: iniciarForm("#","POST",array("role"=>"form"));

echo CHTML::dibujaEtiqueta("div", array("class"=>"col-sm-offset-3 col-sm-6"));

// Campo nombre
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["nombre"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nombre"], true);
}
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre", array("maxlength"=>50, "size"=>51));
echo CHTML::dibujaEtiquetaCierre("div");

// Campo fecha_inicio
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["fecha_inicio"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_inicio"], true);
}
echo CHTML::modeloLabel($modelo, "fecha_inicio");
echo CHTML::modeloDate($modelo, "fecha_inicio");
echo CHTML::dibujaEtiquetaCierre("div");

// Campo fecha_fin
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["fecha_fin"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_fin"], true);
}
echo CHTML::modeloLabel($modelo, "fecha_fin");
echo CHTML::modeloDate($modelo, "fecha_fin");
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
