<?php

// OBTENER ERRORES
$errores = $modelo->getErrores();

echo CHTML::cssFichero("/estilos/estiloFormularios.css");

echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
echo CHTML::dibujaEtiqueta("h2", array(), "Modificar Temporada", true);                
 echo CHTML::dibujaEtiquetaCierre("div");

//FORMULARIO DE NUEVA TEMPORADA
echo CHTML:: iniciarForm("#","POST",array("role"=>"form"));

// cAMPO nombre
echo CHTML::dibujaEtiqueta("div", array("class"=>"col-sm-offset-3 col-sm-6"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre", array("maxlength"=>50, "size"=>51));
echo CHTML::dibujaEtiquetaCierre("div");

// Campo fecha_inicio
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "fecha_inicio");
echo CHTML::modeloDate($modelo, "fecha_inicio");
echo CHTML::dibujaEtiquetaCierre("div");

// Campo fecha_fin
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "fecha_fin");
echo CHTML::modeloDate($modelo, "fecha_fin");
echo CHTML::dibujaEtiquetaCierre("div");

// Boton insertar
echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
