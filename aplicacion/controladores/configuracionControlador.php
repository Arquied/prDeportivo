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
                    $configuracion -> imagen=$_FILES[$configuracion->getNombre()]["name"]["logo"];
                                     
                    if ($configuracion -> validar()) {                                       
                        if (!$configuracion -> guardar()) {
                            $this -> dibujaVista("indexConfiguracion", array("modelo" => $configuracion), "Modificar configuración");
                            exit ;
                        }                       
                        $configuracion -> logo="conf".substr("0000000000".$configuracion->cod_configuracion, -10);
                        //Cargar imagen
                        if (isset($_FILES[$configuracion->getNombre()]) && $_FILES[$configuracion->getNombre()]["error"]["logo"]!=4){
                            $imagen="";
                            //segun sea la imagen
                            switch ($_FILES[$configuracion->getNombre()]["type"]["logo"]) {
                                case 'image/jpeg':
                                    $imagen=imagecreatefromjpeg($_FILES[$configuracion->getNombre()]["tmp_name"]["logo"]);
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
                                    $imagen=imagecreatefromgif($_FILES[$configuracion->getNombre()]["tmp_name"]["logo"]);
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
                                    $imagen=imagecreatefrompng($_FILES[$configuracion->getNombre()]["tmp_name"]["logo"]);
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
    }
