<?php
    //OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modificar perfil", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE REGISTRO
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
                        
                        //Campo dni
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["dni"])){
                            echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["dni"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "dni");
                            echo CHTML::modeloText($modelo, 
                                                    "dni",  
                                                    array("class"=>"form-control", "maxlength"=>9, "size"=>12));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo correo
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["correo"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["correo"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "correo");
                            echo CHTML::modeloEmail($modelo, 
                                                    "correo",                                             
                                                    array("class"=>"form-control", "maxlength"=>30, "size"=>30));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo telefono
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["telefono"])){
                            echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["telefono"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "telefono");
                            echo CHTML::modeloText($modelo,
                                                    "telefono",
                                                    array("class"=>"form-control", "maxlength"=>9, "size"=>12));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo fecha_nac
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["fecha_nac"])){
                            echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_nac"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "fecha_nac");
                            echo CHTML::modeloText($modelo, "fecha_nac", array("class"=>"form-control fecha", "maxlength"=>10, "size"=>12));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
					
					echo CHTML::dibujaEtiqueta("div");
						//Campo foto
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["foto"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["foto"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "foto");
                            echo CHTML::modeloFile($modelo, "foto", array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");	
                        //Campo nick                    
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["nick"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nick"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "nick");
                            echo CHTML::modeloText($modelo, 
                                                    "nick",
                                                    array("class"=>"form-control", "maxlength"=>30, "size"=>30));
                        echo CHTML::dibujaEtiquetaCierre("div");                    
                    echo CHTML::dibujaEtiqueta("div");
                    
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Guardar mis datos", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");

    
    echo CHTML::script(
		"//CARGA DATETIMEPICKER
		$('.fecha').datetimepicker({
				  format:'d/m/Y',
				  lang:'es',
				  timepicker:false,
				  dayOfWeekStart: 1,
				  scrollInput: false,
				  scrollMonth: false,
				  scrollTime: false
				});"
	);

