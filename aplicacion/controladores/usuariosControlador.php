<?php
	 
	class usuariosControlador extends CControlador{
		
		
		public function accionRegistro(){
			$usuario = new Usuarios();
			$nombre = $usuario -> getNombre();
			if (isset($_POST[$nombre])) {
				$usuario -> setValores($_POST[$nombre]);
				$usuario -> cod_role = 2;
				if ($usuario -> validar()) {
					if($usuario->contrasenia==$_POST["con1"]){
						if (!$usuario -> guardar()) { //guarda el usuario
							$this -> dibujaVista("registro", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
							exit ;	
						} else{
							Sistema::app() -> irAPagina(array("inicial", "index"));
							exit ;
						}
					} else {
						$errorCont="Las contraseñas no coinciden";
						$this -> dibujaVista("registro", array("modelo" => $usuario, "errorCont"=>$errorCont), "Nuevo usuario");
						exit ;	
					}
				} else
					$this -> dibujaVista("registro", array("modelo" => $usuario), "Nuevo usuario");	
			}
			else
					$this -> dibujaVista("registro", array("modelo" => $usuario), "Nuevo usuario");	
		}
	
}
