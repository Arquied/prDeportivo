<?php
	//OBTENER ERRORES
	$errores=$modelo->getErrores();
	
	echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	echo CHTML::scriptFichero("../../script/scriptCrudUsuarios.js");
	echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modificar usuario", true);                
                echo CHTML::dibujaEtiquetaCierre("div");
				//CONTENEDOR ERRORES
				echo CHTML::dibujaEtiqueta("div");
					foreach ($errores as $error) {
						echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
					}
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
												 	array("class"=>"form-control", "maxlength"=>80, "size"=>"50"));
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
						
					echo CHTML::dibujaEtiqueta("div");
						//Campo direccion
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["direccion"])){
								echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["direccion"], true);
							}
							echo CHTML::modeloLabel($modelo, "direccion");
							echo CHTML::modeloText($modelo, 
													"direccion",										 	 
												 	array("class"=>"form-control", "maxlength"=>50, "size"=>50));
						echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo localidad
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["localidad"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["localidad"], true);
							}
							echo CHTML::modeloLabel($modelo, "localidad");
							echo CHTML::modeloText($modelo,
													"localidad",
												 	array("class"=>"form-control", "maxlength"=>50, "size"=>50));
						echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo provincia
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["provincia"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["provincia"], true);
							}
							echo CHTML::modeloLabel($modelo, "provincia");
							echo CHTML::modeloText($modelo,
													"provincia",
												 	array("class"=>"form-control", "maxlength"=>50, "size"=>50));
						echo CHTML::dibujaEtiquetaCierre("div");										
					echo CHTML::dibujaEtiquetaCierre("div");
					
					echo CHTML::dibujaEtiqueta("div");
						// Campo web o local
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
						echo CHTML::campoLabel("tipo", "tipo");
						echo CHTML::dibujaEtiqueta("br");
						$lista = array("web","Local");
						echo CHTML::campoListaRadioButton("tipo", "",$lista );
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
						
						//Campo contraseña
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["contrasenia"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["contrasenia"], true);
							}
							if(isset($errorCont)){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errorCont, true);
							}
							echo CHTML::modeloLabel($modelo, "contrasenia");
							echo CHTML::modeloPassword($modelo,
													"contrasenia",
												 	array("class"=>"form-control", "maxlength"=>30, "value"=>"", "size"=>30));
						echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo repite contraseña
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							echo CHTML::campoLabel("Repita contraseña", "con1");
							echo CHTML::campoPassword("con1",
												 	"", 
												 	array("class"=>"form-control", "maxlength"=>30, "size"=>30));
						echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiquetaCierre("div");
					
					echo CHTML::dibujaEtiqueta("div");
						//Boton insertar
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));					
						echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiquetaCierre("div");
					
				echo CHTML::finalizarForm();
				
	echo CHTML::dibujaEtiquetaCierre("div");
