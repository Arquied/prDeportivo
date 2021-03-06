<?php
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    
    // OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modifica configuración", true);                
                echo CHTML::dibujaEtiquetaCierre("div");
				//CONTENEDOR ERRORES
				echo CHTML::dibujaEtiqueta("div");
					foreach ($errores as $error) {
						echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
					}
				echo CHTML::dibujaEtiquetaCierre("div");
               // FORMULARIO DE MODIFICA CONFIGURACION
               echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
               
                echo CHTML::dibujaEtiqueta("div");
                
                        //Campo nombre        
                        echo CHTML::dibujaEtiqueta("div");          
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "nombre_empresa");
                            echo CHTML::modeloText($modelo, 
                                                    "nombre_empresa",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo cif                 
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cif");
                            echo CHTML::modeloText($modelo, 
                                                    "cif",                   
                                                    array("class"=>"form-control", "maxlength"=>9, "size"=>"9"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
						//Campo n_instalacion               
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "n_instalacion");
                            echo CHTML::modeloText($modelo, 
                                                    "n_instalacion",                   
                                                    array("class"=>"form-control", "maxlength"=>20, "size"=>"20"));
                        echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo direccion              
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "direccion");
                            echo CHTML::modeloText($modelo, 
                                                    "direccion",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo localidad          
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "localidad");
                            echo CHTML::modeloText($modelo, 
                                                    "localidad",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo provincia            
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "provincia");
                            echo CHTML::modeloText($modelo, 
                                                    "provincia",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo imagen
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "logo");
                            echo CHTML::modeloFile($modelo, "logo", array("class"=>"form-control"));
                    echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo url_facebook                 
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "url_facebook");
                            echo CHTML::modeloText($modelo, 
                                                    "url_facebook",                   
                                                    array("class"=>"form-control", "maxlength"=>100, "size"=>"100"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::dibujaEtiquetaCierre("div");
                
                        //Campo url_twitter                 
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "url_twitter");
                            echo CHTML::modeloText($modelo, 
                                                    "url_twitter",                   
                                                    array("class"=>"form-control", "maxlength"=>100, "size"=>"100"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo correo
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "correo");
                            echo CHTML::modeloText($modelo, 
                                                    "correo",                   
                                                    array("class"=>"form-control", "maxlength"=>30, "size"=>"30"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo telefono     
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "telefono");
                            echo CHTML::modeloText($modelo, 
                                                    "telefono",                   
                                                    array("class"=>"form-control", "maxlength"=>9, "size"=>"9"));
                        echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo movil  
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "movil");
                            echo CHTML::modeloText($modelo, 
                                                    "movil",                   
                                                    array("class"=>"form-control", "maxlength"=>9, "size"=>"9"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo descripcion
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "descripcion");
                            echo CHTML::modeloTextArea($modelo, 
                                                    "descripcion",                   
                                                    array("class"=>"form-control", "cols"=>50, "rows"=>5));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::dibujaEtiquetaCierre("div"); 
                        
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Modificar configuración", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
                        
