<?php
	//OBTENER ERRORES
	$errores=$modelo->getErrores();
	
	echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	
	echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));

				//FORMULARIO DE REGISTRO
				echo CHTML::iniciarForm("", "post", array("role"=>"form"));
				
					echo CHTML::dibujaEtiqueta("div");
						//Campo nombre_apellidos					
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["nombre_apellidos"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["nombre_apellidos"], true);
							}
							echo CHTML::modeloLabel($modelo, "nombre_apellidos");
							echo CHTML::modeloText($modelo, 
													"nombre_apellidos",					
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
						//Campo email
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["email"])){
								echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["email"], true);
							}
							echo CHTML::modeloLabel($modelo, "email");
							echo CHTML::modeloEmail($modelo, 
													"email",										 	 
												 	array("class"=>"form-control", "maxlength"=>30, "size"=>30));
						echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo tlf
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["tlf"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["tlf"], true);
							}
							echo CHTML::modeloLabel($modelo, "tlf");
							echo CHTML::modeloText($modelo,
													"tlf",
												 	array("class"=>"form-control", "maxlength"=>9, "size"=>12));
						echo CHTML::dibujaEtiquetaCierre("div");
						
						//Campo fecha_nac
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							if(isset($errores["fecha_nac"])){
							echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_nac"], true);
							}
							echo CHTML::modeloLabel($modelo, "fecha_nac");
							echo CHTML::modeloDate($modelo,
													"fecha_nac",
												 	array("class"=>"form-control", "maxlength"=>10, "size"=>12));
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
							echo CHTML::campoBotonSubmit("Registrarme", array("class"=>"btn btn-default"));					
						echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiquetaCierre("div");
					
				echo CHTML::finalizarForm();
				
	echo CHTML::dibujaEtiquetaCierre("div");

	
	
