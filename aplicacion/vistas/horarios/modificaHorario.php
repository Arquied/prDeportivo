<?php

// OBTENER ERRORES
$errores=$modelo->getErrores();

	echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	echo CHTML::cssFichero("../../estilos/jquery.datetimepicker.css");
	echo CHTML::scriptFichero("../../script/jquery.js");
	echo CHTML::scriptFichero("../../script/jquery.datetimepicker.js");
	echo CHTML::scriptFichero("../../script/scriptFecha.js");

    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modificar horario", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

				// FORMULARIO DE MODIFICAR HORARIO
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                              
                        //Campo temporada
                        echo CHTML::dibujaEtiqueta("div");   
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_temporada"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_temporada"], true);
                            }
                            echo CHTML::campoLabel("Temporadas", "temporada");                            
                            echo CHTML::campoListaDropDown("temporada", "", Temporadas::listaTemporadas(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");                  
                        
                        // Campo dia
                         echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_dia"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_dia"], true);
                            }
                            echo CHTML::campoLabel("Dias", "dias");                            
                            echo CHTML::campoListaDropDown("dia", "", Dias::listaDias(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo hora_inicio
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["hora_inicio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["hora_inicio"], true);
                            }
                        echo CHTML::modeloLabel($modelo, "hora_inicio");
                            echo CHTML::modeloText($modelo, "hora_inicio", array("class"=>"form-control", "id"=>"hora_inicio", "maxlength"=>10, "size"=>10,  "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
                        //Campo hora_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["hora_fin"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["hora_fin"], true);
                            }
                        echo CHTML::modeloLabel($modelo, "hora_fin");
                            echo CHTML::modeloText($modelo, "hora_fin", array("class"=>"form-control", "id"=>"hora_fin", "maxlength"=>10, "size"=>10, "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo fecha_inicio
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_inicio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_inicio"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_inicio");
                            echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control", "id"=>"fecha_inicio", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                        
                        //Campo fecha_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_fin"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_fin"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_fin");
                            echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control", "id"=>"fecha_fin", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						echo CHTML::dibujaEtiquetaCierre("div");

                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();

                
