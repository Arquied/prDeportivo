<?php
    //obtener temporadas
    $listaTemporadas=array();

    //OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	echo CHTML::scriptFichero("../../script/scriptCrudActividades.js");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Nueva actividad", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE NUEVA ACTIVIDAD
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo nombre                  
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["nombre"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nombre"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "nombre");
                            echo CHTML::modeloText($modelo, 
                                                    "nombre",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                              
                        //Campo categoria                        
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_categoria"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_categoria"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "cod_categoria");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_categoria", Categorias::listaCategorias(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo temporada
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_temporada"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_temporada"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "cod_temporada");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_temporada", Temporadas::listaTemporadas(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");                        
                        
                        //Campo novedad
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["novedad"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["novedad"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "novedad");
                            echo CHTML::modeloCheckBox($modelo, "novedad");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo seleccionable horas
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["seleccionable_horas"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["seleccionable_horas"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "seleccionable_horas");
                            echo CHTML::modeloCheckBox($modelo, "seleccionable_horas");
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");    
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo fecha_inicio
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_inicio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_inicio"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_inicio");
                            echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control fecha", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                        
                        //Campo fecha_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_fin"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_fin"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_fin");
                            echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control fecha", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
                                                     
                        //Campo capacidad
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["capacidad"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["capacidad"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "capacidad");
                            echo CHTML::modeloNumber($modelo, "capacidad", array("class"=>"form-control", "placeholder"=>"Capacidad"));
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
						//Campo periodo_anulacion
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["periodo_anulacion"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["periodo_anulacion"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "periodo_anulacion");
							echo CHTML::modeloNumber($modelo, "periodo_anulacion", array("class"=>"form-control", "placeholder"=>"Período de anulación"));
                        echo CHTML::dibujaEtiquetaCierre("div");                             
                                                     
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo imagen
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["imagen"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["imagen"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "imagen");
                            echo CHTML::modeloFile($modelo, "imagen", array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo mini_descripcion
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["mini_descripcion"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["mini_descripcion"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "mini_descripcion");
                            echo CHTML::modeloTextArea($modelo, "mini_descripcion",                                           
                                                    array("class"=>"form-control", "maxlength"=>50, "cols"=>"20", "rows"=>"3"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");     
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo descripcion                       
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["descripcion"])){
                            echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["descripcion"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "descripcion");
                            echo CHTML::modeloTextArea($modelo, "descripcion",                                           
                                                    array("class"=>"form-control", "cols"=>50, "rows"=>5));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Añadir actividad", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
