<?php
     
    class inicialControlador extends CControlador
    {
        public function accionIndex(){
            $actividades = new Actividades();
            
            $opciones = array();
            $opciones["select"]=" t.*";
            $opciones["from"]="";
            $opciones["where"]=" t.novedad= 1 and t.disponible=1";
            
            $filas=$actividades->buscarTodos($opciones);
             
            $this->dibujaVista("index",array("filas"=>$filas));      
        }
        
        public function accionLogin(){
            $usuario="";
            $errores="";
            if (isset($_POST["inputUsuario"])){
                $usuario=CGeneral::addSlashes($_POST["inputUsuario"]);
                $contra=$_POST["inputContrasena"];
                
				if ($contra == ""){
                    $errores=htmlentities("Contraseña no puede estar vacio");
				}
				else     
                if (Sistema::app()->ACL()->esValido($usuario, $contra)){
                    //es valido el usuario
                    //registro el usuario 
                    $puedeAcceder=false;
                    $puedeAdministrar=false;
                    $nombre="";
                     
                    if (Sistema::app()->ACL()->getPermisos($usuario, $puedeAcceder, $puedeAdministrar)){
                         $nombre=Sistema::app()->ACL()->getNombre($usuario);
                         if (Sistema::app()->Acceso()-> registrarUsuario($usuario, $nombre, $puedeAcceder, $puedeAdministrar)){
                            //redirecciono
                            if (Sistema::app()->Sesion()->existe("pagPrevia")){
                                $paginaAnt=Sistema::app()->Sesion()->get("pagPrevia");
                                $parametrosAnt=array();
                                if (Sistema::app()->Sesion()->existe("parametrosAnt"))
                                      $parametrosAnt=Sistema::app()->Sesion()->get("parametrosAnt");
                                
                                Sistema::app()->irAPagina($paginaAnt,$parametrosAnt);
                                exit;
                            }
                            Sistema::app()->irAPagina(array());
                            exit;
                        }                               
                    }
                }
                else {
                    $errores=htmlentities("Usuario o contraseña erróneos");
                } 
            }       
            $this->dibujaVista("login", array("user"=>$usuario, "error"=>$errores), "Iniciar sesión");
        }
            
        
        public function accionCerrarSesion(){
            Sistema::app()->acceso()->quitarRegistroUsuario();
            Sistema::app()->irAPagina(array());
            exit;
        }
        
                
        public function accionPrivacidad(){
            
            $this->dibujaVista("privacidad");
            
        }
        
        public function accionQuien(){
            
			$configuraciones = new Configuracion();
			
			$configuracion = $configuraciones -> buscarTodos();
		
			
            $this->dibujaVista("quien",array("configuracion"=>$configuracion));
            
        }
        
    }
