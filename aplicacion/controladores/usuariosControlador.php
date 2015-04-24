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
        
        public function accionMiPerfil(){
            $usuario=new Usuarios();
            if(Sistema::app()->Acceso()->hayUsuario()){                
                $nickUsuario=Sistema::app()->Acceso()->getNick(); 
                
                $usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
                if($usuario->nick!==""){
                    $this ->dibujaVista("miPerfil", array("modelo" => $usuario), "Mi perfil");
                }
                else{
                   Sistema::app()->paginaError(400, "No existe usuario"); 
                } 
            }
            else{
                $this -> dibujaVista("registro", array("modelo" => $usuario), "Nuevo usuario");
            }
            
        }
        
        
        public function accionModificar(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar         
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "modificar"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            else{
                $usuario=new Usuarios();      
                if($usuario->buscarPorId($_GET["cod_usuario"])){
                    if(isset($_POST[$usuario->getNombre()])){
                        $usuario -> setValores($_POST[$usuario->getNombre()]);                                               
                                            
                        if ($usuario -> validar()) {
                            if($usuario->contrasenia==$_POST["con1"]){                                       
                                if (!$usuario -> guardar()) {
                                    $this -> dibujaVista("modificar", array("modelo" => $usuario), "Modificar usuario");
                                    exit ;
                                }
                                //Reiniciar sesion con el nombre de usuario nuevo
                                Sistema::app()->acceso()->quitarRegistroUsuario();
                                $puedeAcceder=false;
                                $puedeAdministrar=false;
                                $nombre="";
                                if (Sistema::app()->ACL()->getPermisos($usuario->nick, $puedeAcceder, $puedeAdministrar)){
                                     $nombre=Sistema::app()->ACL()->getNombre($usuario->nick);
                                     if (Sistema::app()->Acceso()-> registrarUsuario($usuario->nick, $nombre, $puedeAcceder, $puedeAdministrar)){          
                                        Sistema::app()->irAPagina(array("usuarios", "miPerfil"));
                                        exit ;
                                     }
                                     Sistema::app()->irAPagina(array("inicial", "login"));
                                     exit;
                                }
                                Sistema::app()->irAPagina(array("inicial", "login"));
                                exit;
                            }
                            else{
                                $errorCont="Las contraseñas no coinciden";
                                $this -> dibujaVista("registro", array("modelo" => $usuario, "errorCont"=>$errorCont), "Nuevo usuario");
                                exit ;
                            }
                        }                         
                        else {
                            $this -> dibujaVista("modificar", array("modelo" => $usuario), "Modificar usuario");
                            exit ;
                        }       
                    }               
                    $this->dibujaVista("modificar", array("modelo"=>$usuario), "Modificar el usuario");
                    exit;
                }   
                Sistema::app()->paginaError(400, "El usuario no se encuentra");
            }
        }
	
}
