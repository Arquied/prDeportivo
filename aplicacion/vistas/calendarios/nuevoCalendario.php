<?php
    //obtener temporadas
    $listaDia=array();
	$listaInstalacion=array();
	$listaActividad=array();
	
    //OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Nuevo calendario", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE NUEVO CALENDARIO
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                              
                        //Campo actividad                       
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_actividad"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_actividad"], true);
                            }
                            echo CHTML::campoLabel("Actividades", "actividad");                            
                            echo CHTML::campoListaDropDown("actividad", "", Actividades::listaActividades(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo dia                       
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_dia"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_dia"], true);
                            }
                            echo CHTML::campoLabel("Dias", "dias");                            
                            echo CHTML::campoListaDropDown("dia", "", Dias::listaDias(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");                     
                         
                         //Campo hora_inicio
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["hora_inicio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["hora_inicio"], true);
                            }
                        echo CHTML::modeloLabel($modelo, "hora_inicio");
                            echo CHTML::modeloText($modelo, "hora_inicio", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
                        //Campo hora_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["hora_fin"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["hora_fin"], true);
                            }
                        echo CHTML::modeloLabel($modelo, "hora_fin");
                            echo CHTML::modeloText($modelo, "hora_fin", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
                        //Campo fecha_inicio
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_inicio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_inicio"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_inicio");
                            echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                        
                        //Campo fecha_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_fin"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_fin"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_fin");
                            echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                    
                    echo CHTML::dibujaEtiqueta("div");
					
					// Campo instalacion
					echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
						$array = array("aire libre");
						echo CHTML::campoListaRadioButton("instalacion", "", $array);
						echo CHTML::campoListaRadioButton("instalacion", "", Instalaciones::listaInstalacion());
					
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Añadir calendario", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
