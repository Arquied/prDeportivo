<?php
// OBTENER ERRORES
$errores = $modelo->getErrores();
echo CHTML::cssFichero("/estilos/estiloFormularios.css");
echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
        echo CHTML::dibujaEtiqueta("h2", array(), "Modifica Instalación", true);                
    echo CHTML::dibujaEtiquetaCierre("div");
    // FORMULARIO DE MODIFICA INSTALACION
    echo CHTML::iniciarForm("#","POST",array("role"=>"form", "enctype"=>"multipart/form-data"));
        echo CHTML::dibujaEtiqueta("div");
            // Campo nombre
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
            if (isset($errores["nombre"])){
            	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nombre"], true);
            }
                echo CHTML::modeloLabel($modelo, "nombre");
                echo CHTML::modeloText($modelo, "nombre",array("class"=>"form-control","maxlength"=>50,"size"=>51));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div");
            // Campo descripcion
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
            if (isset($errores["descripcion"])){
            	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["descripcion"], true);
            }
                echo CHTML::modeloLabel($modelo, "descripcion");
                echo CHTML::modeloTextArea($modelo, "descripcion",array("class"=>"form-control", "cols"=>50, "rows"=>10));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div");
            // Campo imagen
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
            if (isset($errores["imagen"])){
            	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["imagen"], true);
            }
                echo CHTML::modeloLabel($modelo, "imagen");
                echo CHTML::modeloFile($modelo, "imagen", array("class"=>"form-control"));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div");
            // Campo capacidad
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
            if (isset($errores["capacidad"])){
            	echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["capacidad"], true);
            }
                echo CHTML::modeloLabel($modelo, "capacidad");
                echo CHTML::modeloNumber($modelo, "capacidad",array("class"=>"form-control",));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div");        
            // Boton insertar
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
