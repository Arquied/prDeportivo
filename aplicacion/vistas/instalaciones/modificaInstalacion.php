<?php

$errores = $modelo->getErrores();

echo CHTML::cssFichero("/estilos/estiloFormularios.css");

echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modifica Instalacion", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::iniciarForm("#","POST",array("role"=>"form"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"col-sm-offset-3 col-sm-6"));
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre",array("class"=>"form-control","maxlength"=>50,"size"=>51));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "descripcion");
echo CHTML::modeloTextArea($modelo, "descripcion",array("class"=>"form-control",));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "imagen");
echo CHTML::modeloFile($modelo, "imagen");
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::modeloLabel($modelo, "capacidad");
echo CHTML::modeloNumber($modelo, "capacidad",array("class"=>"form-control",));
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div");
echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));
echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
