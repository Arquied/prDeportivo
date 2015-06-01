<?php
    class configuracionControlador extends CControlador {
        
        public function accionIndex(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("configuracion", "index"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else {
                $configuracion=new Configuracion();
                if($configuracion->buscarPorId(1)){
                    if(isset($_POST[$configuracion->getNombre()])){
                    $configuracion -> setValores($_POST[$configuracion->getNombre()]);                  
                    $configuracion -> imagen=$_FILES[$configuracion->getNombre()]["name"]["imagen"];
                                     
                    if ($configuracion -> validar()) {                                       
                        if (!$configuracion -> guardar()) {
                            $this -> dibujaVista("indexConfiguracion", array("modelo" => $configuracion), "Modificar configuración");
                            exit ;
                        }
                        if($configuracion->logo!=""){                       
                            $configuracion -> logo="conf".substr("0000000000".$configuracion->cod_configuracion, -10);
                            //Cargar imagen
                            if (isset($_FILES[$configuracion->getNombre()]) && $_FILES[$configuracion->getNombre()]["error"]["imagen"]!=4){
                                $imagen="";
                                //segun sea la imagen
                                switch ($_FILES[$configuracion->getNombre()]["type"]["imagen"]) {
                                    case 'image/jpeg':
                                        $imagen=imagecreatefromjpeg($_FILES[$configuracion->getNombre()]["tmp_name"]["imagen"]);
                                        $configuracion->logo.=".jpg";  
                                        imagealphablending($imagen, true);
                                        imagesavealpha($imagen, true);
                                        if (is_resource($imagen)){
                                            $ruta="/imagenes/configuracion/".$configuracion->logo;
                                            $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                            imagejpeg($imagen,$ruta);
                                        }                                   
                                        break;
                                        
                                    case 'image/gif':
                                        $imagen=imagecreatefromgif($_FILES[$configuracion->getNombre()]["tmp_name"]["imagen"]);
                                        $configuracion->logo.=".gif";  
                                        imagealphablending($imagen, true);
                                        imagesavealpha($imagen, true);
                                        if (is_resource($imagen)){
                                            $ruta="/imagenes/configuracion/".$configuracion->logo;
                                            $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                            imagegif($imagen,$ruta);
                                        }
                                        break;
            
                                    case 'image/png':
                                        $imagen=imagecreatefrompng($_FILES[$configuracion->getNombre()]["tmp_name"]["imagen"]);
                                        $configuracion->logo.=".png";  
                                        imagealphablending($imagen, true);
                                        imagesavealpha($imagen, true);
                                        if (is_resource($imagen)){
                                            $ruta="/imagenes/configuracion/".$configuracion->logo;
                                            $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                            imagepng($imagen,$ruta);
                                        }
                                        break;
                                }
                            }
                            if(!$configuracion->guardar()){
                                $this -> dibujaVista("indexConfiguracion", array("modelo" => $configuracion), "Modificar configuración");
                                exit ;
                            }
                        }
                        Sistema::app()->irAPagina(array("inicial"));
                        exit ;
                    } 
                    else {
                        $this -> dibujaVista("indexConfiguracion", array("modelo" => $configuracion), "Modificar configuración");
                        exit ;
                    }       
                }               
                $this->dibujaVista("indexConfiguracion", array("modelo"=>$configuracion), "Modificar configuración");
                exit;
            }   
            Sistema::app()->paginaError(400, "La configuración no se encuentra");
                
            } 
        }
                        
           /* if (!Sistema::app() -> acceso() -> hayUsuario()) {
                  Sistema::app() -> sesion() -> set("pagPrevia", array("configuracion"));
                  Sistema::app() -> sesion() -> set("parametrosAnt", array("modelo"=>$_POST["configuracion"]));
                  Sistema::app() -> irAPagina(array("inicial", "login"));
                  exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                  Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                  exit ;
            } 
            else {
                $configuracion = new Configuracion();                 
                if ($configuracion->buscarPorId(1)){                    
                    $nombre = $configuracion->getNombre();                    
                    if (isset($_POST[$nombre])){
                        
                        $configuracion->setValores($_POST["nombre"]);
                        
                        if ($configuracion->validar()){
                            
                            if (!$configuracion->guardar()){
                              Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
                              exit;
                            }
                            
                            Sistema::app()->irAPagina(array("configuracion"));
                            exit;
                        }
                        else {
                            $this->dibujaVista("indexConfiguracion",array("modelo"=>$configuracion),"Modificaci&oacute; de Configuraci$oacuten");
                            exit;
                        }
                        
                    }
                    
                }
                
                $this->dibujaVista("indexConfiguracion",array("modelo"=>$configuracion), "Lista de Configuracion");
                
            }
        }*/
        
    }
