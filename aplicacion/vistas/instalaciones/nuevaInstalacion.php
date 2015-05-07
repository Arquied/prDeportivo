<?php
$errores = $modelo->getErrores();

echo CHTML::cssFichero("/estilos/estiloFormularios.css");

echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
echo CHTML::dibujaEtiqueta("h2", array(), "Instalacion Nueva", true);                
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::iniciarForm("#","POST",array("role"=>"form"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"col-sm-offset-3 col-sm-6"));

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["nombre"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nombre"],true);
}
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre",array("class"=>"form-control","maxlength"=>50,"size"=>51));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["descripcion"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["descripcion"],true);
}
echo CHTML::modeloLabel($modelo, "descripcion");
echo CHTML::modeloTextArea($modelo, "descripcion",array("class"=>"form-control",));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["imagen"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["imagen"],true);
}
echo CHTML::modeloLabel($modelo, "imagen");
echo CHTML::modeloFile($modelo, "imagen");
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
if (isset($errores["capacidad"])){
	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["capacidad"],true);
}
echo CHTML::modeloLabel($modelo, "capacidad");
echo CHTML::modeloNumber($modelo, "capacidad",array("class"=>"form-control",));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::campoBotonSubmit("Nueva", array("class"=>"btn btn-default"));
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
