<?php
	 
	class usuariosControlador extends CControlador{
		
		public function accionIndex(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
	         if (!Sistema::app() -> acceso() -> hayUsuario()) {
	              Sistema::app() -> sesion() -> set("pagPrevia", array("usuarios", "index"));
	              Sistema::app() -> sesion() -> set("parametrosAnt", array());
	              Sistema::app() -> irAPagina(array("inicial", "login"));
	              exit ;
	        } 
	        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
	             Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
	             exit ;
	       	} 
			else {
				$usuario=new Usuarios();				
				$filas=$usuario->buscarTodos(array("select"=>"t.*, r.nombre as role ",
													"from"=>" join roles r using(cod_role)"));		
				$this->dibujaVista("indexUsuario",array("filas"=>$filas));			
			}
			
		}
		
		public function accionRegistro(){	           
			$usuario = new Usuarios();
			$nombre = $usuario -> getNombre();
			if (isset($_POST[$nombre])) {
				$usuario -> setValores($_POST[$nombre]);
				$usuario -> cod_role = 2;
				$usuario -> disponible = 1;
				$usuario -> web = 1;
				if ($usuario -> contrasenia == ""){
					$errorCont = "La contraseña no puede estar vacio";
					$this -> dibujaVista("registro", array("modelo" => $usuario, "errorCont"=>$errorCont), "Nuevo usuario");
					exit ;	
				}
				if ($usuario -> validar()) {
					if($usuario->contrasenia==$_POST["con1"]){
						if (!$usuario -> guardar()) { //guarda el usuario
							$this -> dibujaVista("registro", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
							exit ;	
						} else{
			 				//Cargar imagen
	                    	if (isset($_FILES["usuario"]) && $_FILES["usuario"]["error"]["foto"] != 4) {
	                    	$usuario -> foto = "usu" . substr("0000000000" . $usuario -> cod_usuario, -10);
	                        $imagen = "";
	                        //segun sea la imagen
	                        switch ($_FILES["usuario"]["type"]["foto"]) {
	                            case 'image/jpeg' :
	                                $imagen = imagecreatefromjpeg($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".jpg";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagejpeg($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/gif' :
	                                $imagen = imagecreatefromgif($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".gif";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagegif($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/png' :
	                                $imagen = imagecreatefrompng($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".png";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagepng($imagen, $ruta);
	                                }
	                                break;
	                        }
	                    }
	                    if (!$usuario -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
	                        $this -> dibujaVista("registro", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
							exit ;
	                    }
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
			$compra=new Compras();
            if(Sistema::app()->Acceso()->hayUsuario()){                
                $nickUsuario=Sistema::app()->Acceso()->getNick(); 
                
                $usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
			    if(isset($_POST["temporada_actual"])){
			         //Obtener lista de compras realizadas
                     $compras=$compra->buscarTodos(array("select"=>" t.*, a.nombre as actividad ",
                                            "from"=>" join reservas r using(cod_reserva) ".
                                                    " join actividades a using(cod_actividad) ".
                                                    " join temporadas tem using(cod_temporada)",
                                            "where"=>" r.cod_usuario=".$usuario->cod_usuario." and tem.nombre REGEXP '[[:alnum:]]*".date("Y")."[[:alnum:]]*'"
                                            )
                                    );   
			    }
			    else{
    			     //Obtener lista de compras realizadas
                    $compras=$compra->buscarTodos(array("select"=>" t.*, a.nombre as actividad ",
                                                "from"=>" join reservas r using(cod_reserva) ".
                                                        " join actividades a using(cod_actividad) ",
                                                "where"=>" r.cod_usuario=".$usuario->cod_usuario
                                                )
                                        );    
			    }
				
				
                if($usuario->nick!==""){
                    $this ->dibujaVista("miPerfil", array("modelo" => $usuario, "comprasRealizadas"=>$compras, "tem"=>(isset($_POST["temporada_actual"])?$_POST["temporada_actual"]:0)), "Mi perfil");
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
                            if (!$usuario -> guardar()) {
                                $this -> dibujaVista("modificar", array("modelo" => $usuario), "Modificar usuario");
                                exit ;
                            }
							//Cargar imagen
	                    	if (isset($_FILES["usuario"]) && $_FILES["usuario"]["error"]["foto"] != 4) {
	                    	$usuario -> foto = "usu" . substr("0000000000" . $usuario -> cod_usuario, -10);
	                        $imagen = "";
	                        //segun sea la imagen
	                        switch ($_FILES["usuario"]["type"]["foto"]) {
	                            case 'image/jpeg' :
	                                $imagen = imagecreatefromjpeg($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".jpg";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagejpeg($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/gif' :
	                                $imagen = imagecreatefromgif($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".gif";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagegif($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/png' :
	                                $imagen = imagecreatefrompng($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".png";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagepng($imagen, $ruta);
	                                }
	                                break;
	                        	}
	                    	}
		                    if (!$usuario -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
		                        $this -> dibujaVista("modificar", array("modelo" => $usuario), htmlentities("Modificar usuario"));
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
        public function accionCambiarContrasena(){
             //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar         
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "cambiarContrasena"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            else{
                if(isset($_POST["contrasenaActual"])){
                    //Validar si la contraseña actual es correcta
                    if(Sistema::app()->ACL()->esValido(Sistema::app()->Acceso()->getNick(), $_POST["contrasenaActual"])){
                        //Comprobar si las dos contraseña nuevas son iguales
                        if($_POST["nuevaContrasena"]==$_POST["nuevaContrasenaRep"]){
                            $nick=Sistema::app()->Acceso()->getNick();
                            $sentencia=" update usuarios set ".
                                        " contrasenia=md5('".CGeneral::addSlashes($_POST['nuevaContrasena'])."') ".
                                        " where nick='$nick'";
                            $resultado=Sistema::app()->BD()->crearConsulta($sentencia);
                            if($resultado){
                                Sistema::app()->irAPagina(array("usuarios", "miPerfil"));
                                exit;
                            }
                        }
                        else{
                            $this->dibujaVista("cambiarContrasena", array("error"=>"Las contraseñas no coinciden"), "Cambiar Contraseña");
                            exit ; 
                        }      
                    }
                    else{
                        $this->dibujaVista("cambiarContrasena", array("error"=>"La contraseña no es correcta"), "Cambiar Contraseña");
                        exit ; 
                    }                        
                }
                else{
                    $this->dibujaVista("cambiarContrasena", array(), "Cambiar Contraseña");
                    exit ;    
                }         
            }
        }
		public function accionBorraUsuario(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de borrar		
			if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "borraUsuario"));
				Sistema::app()->sesion()->set("parametrosAnt", array());
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$usuario=new Usuarios();		
				if($usuario->buscarPorId($_REQUEST["id"])){					
					$usuario -> disponible=0;											
					if(!$usuario->guardar()){
						Sistema::app()->paginaError(400, "Error al eliminar usuario");
						exit ;
					}
					Sistema::app()->irAPagina(array("usuarios", "index"));
					exit ;							
				}
				Sistema::app()->paginaError(400, "El usuario no se encuentra");
			}
		}
		public function accionCambiarRole(){
			 //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar         
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "indexUsuarios"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            else{
                if(isset($_POST["role"]) && isset($_POST["id_usuario"])){
                	//Comprobar si existe usuario
                	$usuario=new Usuarios();
                	if($usuario->buscarPorId(intval($_POST["id_usuario"]))){
                		$sentencia=" update usuarios set ".
                                        " cod_role=".intval($_POST["role"]).
                                        " where cod_usuario=".intval($_GET["id_usuario"]);
                       	$resultado=Sistema::app()->BD()->crearConsulta($sentencia);
						if($resultado){
                            Sistema::app()->irAPagina(array("usuarios", "index"));
                            exit;
                       	}
						else{
							Sistema::app()->paginaError(400, "Error al modificar role al usuario");
							exit;
						}
                	}
					else{
						Sistema::app()->irAPagina(array("usuarios", "index"));
                        exit;
					}			
				  } 
				}
			}       
                           
        	public function accionListaUsuarios(){
	        	if (!Sistema::app() -> acceso() -> hayUsuario()) {
	            	Sistema::app() -> sesion() -> set("pagPrevia", array("usuarios", "ListaUsuarios"));
	              	Sistema::app() -> sesion() -> set("parametrosAnt", array());
	              	Sistema::app() -> irAPagina(array("inicial", "login"));
			        exit ;
		        } 
       			else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
             		Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
             		exit ;
       			} 
				else {
					$usuarios = new Usuarios();
					$actividad = new Actividades();
					if ($actividad->buscarPorId($_GET["cod_actividad"])){
						$filas=$usuarios->buscarTodos(array("select"=>"t.*","from"=>"join reservas r using (cod_usuario)", "where"=>"r.cod_actividad = {$_GET['cod_actividad']} and r.anulado = 0"));
						$this->dibujaVista("ListaUsuarios",array("filas"=>$filas, "actividad"=>$actividad));
						
					}	
				}
        	}
			
		public function accionRegistrarUsuario(){
						if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "borraUsuario"));
				Sistema::app()->sesion()->set("parametrosAnt", array());
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$usuario = new Usuarios();
				$nombre = $usuario -> getNombre();
	
				if (isset($_POST[$nombre])) {
					$usuario -> setValores($_POST[$nombre]);
					$usuario -> disponible = 1;
					$usuario -> cod_role = $_POST["role"];
					if ($_POST["tipo"]){
						$usuario -> local = 1;
					}
					else {
						$usuario -> web = 1;
					}
					echo $usuario->web;
					if ($usuario -> validar()) {
						if ($usuario -> web == 1){
							if ($usuario -> contrasenia == ""){
							$errorCont = "La contraseña no puede estar vacio";
							$this -> dibujaVista("registroAdministrador", array("modelo" => $usuario, "errorCont"=>$errorCont), "Nuevo usuario");
							exit ;	
							}
							if($usuario->contrasenia==$_POST["con1"]){
								if (!$usuario -> guardar()) { //guarda el usuario
									$this -> dibujaVista("registroAministrador", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
									exit ;	
								} else{
									Sistema::app() -> irAPagina(array("inicial", "index"));
									exit ;
								}
							} 
							else {
								$errorCont="Las contraseñas no coinciden";
								$this -> dibujaVista("registroAdministrador", array("modelo" => $usuario, "errorCont"=>$errorCont), "Nuevo usuario");
								exit ;	
							}						
						}
	
						else{
						
							if (!$usuario -> guardar()) { //guarda el usuario
								$this -> dibujaVista("registroAdministrador", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
								exit ;	
							} else{
								//Cargar imagen
		                    	if (isset($_FILES["usuario"]) && $_FILES["usuario"]["error"]["foto"] != 4) {
		                    	$usuario -> foto = "usu" . substr("0000000000" . $usuario -> cod_usuario, -10);
		                        $imagen = "";
		                        //segun sea la imagen
		                        switch ($_FILES["usuario"]["type"]["foto"]) {
		                            case 'image/jpeg' :
		                                $imagen = imagecreatefromjpeg($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".jpg";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagejpeg($imagen, $ruta);
		                                }
		                                break;
		
		                            case 'image/gif' :
		                                $imagen = imagecreatefromgif($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".gif";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagegif($imagen, $ruta);
		                                }
		                                break;
		
		                            case 'image/png' :
		                                $imagen = imagecreatefrompng($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".png";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagepng($imagen, $ruta);
		                                }
		                                break;
		                        }
		                    }
		                    if (!$usuario -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
		                        $this -> dibujaVista("registroAdministrador", array("modelo" => $usuario), htmlentities("Nuevo usuario"));
								exit ;
		                    }
							Sistema::app() -> irAPagina(array("usuarios", "index"));
							exit ;
							}	
						}
	
					} else
						$this -> dibujaVista("registroAdministrador", array("modelo" => $usuario), "Nuevo usuario");
				}
				else
						$this -> dibujaVista("registroAdministrador", array("modelo" => $usuario), "Nuevo usuario");
			}
		}
	
        public function accionModificarUsuario(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar         
            if(!Sistema::app()->acceso()->hayUsuario()){
                Sistema::app()->sesion()->set("pagPrevia", array("usuarios", "modificarUsuario"));
                Sistema::app()->sesion()->set("parametrosAnt", array());
                Sistema::app()->irAPagina(array("inicial", "login"));
                exit;
            }
            else{
                $usuario=new Usuarios();      
                if($usuario->buscarPorId($_GET["cod_usuario"])){
                    if(isset($_POST[$usuario->getNombre()])){
                        $usuario -> setValores($_POST[$usuario->getNombre()]);
						if ($_POST["tipo"]){
							$usuario -> local = 1;
							$usuario -> web =0;
						}
						else {
							$usuario -> web = 1;
							$usuario -> local = 0;
						}                                                                                   
				if ($usuario -> validar()) {
					if ($usuario -> web == 1){ //Si el usuario es web
						if ($usuario -> contrasenia == ""){
						$errorCont = "La contraseña no puede estar vacio";
						$this -> dibujaVista("modificarUsuario", array("modelo" => $usuario, "errorCont"=>$errorCont), "Modificar usuario");
						exit ;	
						}
						if($usuario->contrasenia==$_POST["con1"]){
							if (!$usuario -> guardar()) { //guarda el usuario
								$this -> dibujaVista("modificarUsuario", array("modelo" => $usuario), htmlentities("Modificar usuario"));
								exit ;	
							} else{
								//Cargar imagen
		                    	if (isset($_FILES["usuario"]) && $_FILES["usuario"]["error"]["foto"] != 4) {
		                    	$usuario -> foto = "usu" . substr("0000000000" . $usuario -> cod_usuario, -10);
		                        $imagen = "";
		                        //segun sea la imagen
		                        switch ($_FILES["usuario"]["type"]["foto"]) {
		                            case 'image/jpeg' :
		                                $imagen = imagecreatefromjpeg($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".jpg";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagejpeg($imagen, $ruta);
		                                }
		                                break;
		
		                            case 'image/gif' :
		                                $imagen = imagecreatefromgif($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".gif";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagegif($imagen, $ruta);
		                                }
		                                break;
		
		                            case 'image/png' :
		                                $imagen = imagecreatefrompng($_FILES["usuario"]["tmp_name"]["foto"]);
		                                $usuario -> foto .= ".png";
		                                if (is_resource($imagen)) {
		                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
		                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
		                                    imagepng($imagen, $ruta);
		                                }
		                                break;
		                        }
		                    }
		                    if (!$usuario -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
		                        $this -> dibujaVista("modificarUsuario", array("modelo" => $usuario), htmlentities("Modificar usuario"));
								exit ;
		                    }
							Sistema::app() -> irAPagina(array("usuarios", "index"));
							exit ;
							}
						} 
						else {
							$errorCont="Las contraseñas no coinciden";
							$this -> dibujaVista("modificarUsuario", array("modelo" => $usuario, "errorCont"=>$errorCont), "Modificar usuario");
							exit ;	
						}						
					}
					else{ //Si el usuario es local					
						if (!$usuario -> guardar()) { //guarda el usuario
							$this -> dibujaVista("modificarUsuario", array("modelo" => $usuario), htmlentities("Modificar usuario"));
							exit ;	
						} else{
							//Cargar imagen
	                    	if (isset($_FILES["usuario"]) && $_FILES["usuario"]["error"]["foto"] != 4) {
	                    	$usuario -> foto = "usu" . substr("0000000000" . $usuario -> cod_usuario, -10);
	                        $imagen = "";
	                        //segun sea la imagen
	                        switch ($_FILES["usuario"]["type"]["foto"]) {
	                            case 'image/jpeg' :
	                                $imagen = imagecreatefromjpeg($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".jpg";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagejpeg($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/gif' :
	                                $imagen = imagecreatefromgif($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".gif";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuario -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagegif($imagen, $ruta);
	                                }
	                                break;
	
	                            case 'image/png' :
	                                $imagen = imagecreatefrompng($_FILES["usuario"]["tmp_name"]["foto"]);
	                                $usuario -> foto .= ".png";
	                                if (is_resource($imagen)) {
	                                    $ruta = "/imagenes/usuarios/" . $usuarios -> foto;
	                                    $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                    imagepng($imagen, $ruta);
	                                }
	                                break;
	                        }
	                    }
	                    if (!$usuario -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
	                        $this -> dibujaVista("modificarUsuario", array("modelo" => $usuario), htmlentities("Modificar usuario"));
							exit ;
	                    }
							Sistema::app() -> irAPagina(array("usuarios", "index"));
							exit ;
						}	
						
					}
				}                        
                        else {
                            $this -> dibujaVista("modificarUsuario", array("modelo" => $usuario), "Modificar usuario");
                            exit ;
                        }       
                    }               
                    $this->dibujaVista("modificarUsuario", array("modelo"=>$usuario), "Modificar el usuario");
                    exit;
                }
				Sistema::app()->paginaError(400, "El usuario no se encuentra");
       		}
		}
	
}
