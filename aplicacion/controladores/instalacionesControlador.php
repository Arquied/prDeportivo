<?php

class instalacionesControlador extends CControlador {
	
	//Funcion que muestra todos los instalaciones
	public function accionIndex(){
		 //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
         if (!Sistema::app() -> acceso() -> hayUsuario()) {
              Sistema::app() -> sesion() -> set("pagPrevia", array("instalacion"));
              Sistema::app() -> sesion() -> set("parametrosAnt", array());
              Sistema::app() -> irAPagina(array("inicial", "login"));
              exit ;
        } 
        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
              Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
              exit ;
            } 
		else {
			$instalaciones = new Instalaciones();
			
			 $filas=$instalaciones->buscarTodos(array("select"=>" t.*"));
			
			$this->dibujaVista("indexInstalacion",array("filas"=>$filas));			
		}

		
	}
	
	// Funcion que añade nuevas instalaciones
	public function accionNuevaInstalacion(){
		 //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
         if (!Sistema::app() -> acceso() -> hayUsuario()) {
			Sistema::app() -> sesion() -> set("pagPrevia", array("instalaciones", "nuevaInstalacion"));
            Sistema::app() -> sesion() -> set("parametrosAnt", array());
            Sistema::app() -> irAPagina(array("inicial", "login"));
            exit ;
        } 
        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
            Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
            exit ;
        } 
		else {
		
		$instalacion = new Instalaciones();
		
		$nombre = $instalacion->getNombre();
		
		if(isset($_POST[$nombre])){

			$instalacion->setValores($_POST[$nombre]);
			$instalacion->disponible=1;
			

			if($instalacion->validar()){
				if (!$instalacion->guardar()){
					Sistema::app()->paginaError(404,"Se ha producido un error al guardar la temporada");
					exit;
				}
				
				if ($instalacion->imagen!=""){
					$instalacion -> imagen = "ins" . substr("0000000000" . $instalacion -> cod_instalacion, -10);
					
					// Cargar imagen
					if (isset($_FILES["instalacion"]) && $_FILES["instalacion"]["error"]["imagen"] != 4){
	                            //segun sea la imagen
	                            switch ($_FILES["instalacion"]["type"]["imagen"]) {
	                                case 'image/jpeg' :
	                                    $imagen = imagecreatefromjpeg($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalaciones -> imagen .= ".jpg";
	                                    if (is_resource($imagen)) {
	                                        $ruta = "/imagenes/instalacion/" . $instalaciones -> imagen;
	                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                        imagejpeg($imagen, $ruta);
	                                    }
	                                    break;
	    
	                                case 'image/gif' :
	                                    $imagen = imagecreatefromgif($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalacion -> imagen .= ".gif";
	                                    if (is_resource($imagen)) {
	                                        $ruta = "/imagenes/instalaciones/" . $instalacion -> imagen;
	                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                        imagegif($imagen, $ruta);
	                                    }
	                                    break;
	    
	                                case 'image/png' :
	                                    $imagen = imagecreatefrompng($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalacion -> imagen .= ".png";
	                                    if (is_resource($imagen)) {
	                                        $ruta = "/imagenes/instalaciones/" . $instalacion -> imagen;
	                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	                                        imagepng($imagen, $ruta);
	                                    }
	                                    break;
					}
						
				}
	                        if (!$instalacion -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
	                            $this -> dibujaVista("nuevaInstalacion", array("modelo" => $instalacion), "Nueva Instalacion");
	                            exit ;
	                        } 
				}	
				Sistema::app()->irAPagina(array("instalaciones"));
				exit;
			}
			
			else {
				$this->dibujaVista("nuevaInstalacion",array("modelo"=>$instalacion));
			}
		}
		
		$this->dibujaVista("nuevaInstalacion",array("modelo"=>$instalacion));
		}
	}
	
	// Funcion que modifica instalaciones
	public function accionModificaInstalacion(){
		 //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
		if (!Sistema::app() -> acceso() -> hayUsuario()) {
              Sistema::app() -> sesion() -> set("pagPrevia", array("instalaciones", "modificaInstalacion"));
              Sistema::app() -> sesion() -> set("parametrosAnt", array());
              Sistema::app() -> irAPagina(array("inicial", "login"));
              exit ;
        } 
        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
              Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
              exit ;
            } 
		else {
		
		$instalacion = new Instalaciones();
			if ($instalacion->buscarPorId($_GET["cod_instalacion"])){
				if (isset($_POST[$instalacion->getNombre()])){
					$instalacion -> setValores($_POST[$instalacion->getNombre()]);
					
					if ($instalacion -> validar()){                                      
                        if (!$instalacion -> guardar()) {
                            $this -> dibujaVista("modificaInstalacion", array("modelo" => $instalacion), "Modificar instalacion");
                            exit ;
                        }
                        if($instalacion->imagen!=""){                   
	                        $instalacion -> imagen="act".substr("0000000000".$instalacion->cod_instalacion, -10);
	                        //Cargar imagen
	                        if (isset($_FILES["instalacion"]) && $_FILES["instalacion"]["error"]["imagen"]!=4){
	                            $imagen="";
	                            //segun sea la imagen
	                            switch ($_FILES["instalacion"]["type"]["imagen"]) {
	                                case 'image/jpeg':
	                                    $imagen=imagecreatefromjpeg($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalacion->imagen.=".jpg";  
	                                    imagealphablending($imagen, true);
	                                    imagesavealpha($imagen, true);
	                                    if (is_resource($imagen)){
	                                        $ruta="/imagenes/instalaciones/".$instalacion->imagen;
	                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
	                                        imagejpeg($imagen,$ruta);
	                                    }                                   
	                                    break;
	                                    
	                                case 'image/gif':
	                                    $imagen=imagecreatefromgif($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalacion->imagen.=".gif";  
	                                    imagealphablending($imagen, true);
	                                    imagesavealpha($imagen, true);
	                                    if (is_resource($imagen)){
	                                        $ruta="/imagenes/instalaciones/".$instalacion->imagen;
	                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
	                                        imagegif($imagen,$ruta);
	                                    }
	                                    break;
	        
	                                case 'image/png':
	                                    $imagen=imagecreatefrompng($_FILES["instalacion"]["tmp_name"]["imagen"]);
	                                    $instalacion->imagen.=".png";  
	                                    imagealphablending($imagen, true);
	                                    imagesavealpha($imagen, true);
	                                    if (is_resource($imagen)){
	                                        $ruta="/imagenes/instalaciones/".$instalacion->imagen;
	                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
	                                        imagepng($imagen,$ruta);
	                                    }
	                                    break;
	                            }
	                        }
	                  	    if(!$instalacion->guardar()){
	                            $this -> dibujaVista("modificaInstalacion", array("modelo" => $instalacion), "Modificar instalacion");
	                            exit ;
	                        }
	                  	}
                        Sistema::app()->irAPagina(array("instalaciones"));
                        exit ;
					}
                    else {
                        $this -> dibujaVista("modificaInstalacion", array("modelo" => $instalacion), "Modificar instalacion");
                        exit ;
                    }       
                }               
                $this->dibujaVista("modificaInstalacion", array("modelo"=>$instalacion), "Modificar instalacion");
                exit;
            }   
            Sistema::app()->paginaError(400, "La instalacion no se encuentra");
                
            }        
        }
		
		public function accionBorraInstalacion(){
			
			if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("instalacion", "borraInstalacion"));
				Sistema::app()->sesion()->set("parametrosAnt", array());
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$instalacion= new Instalaciones();
				if ($instalacion->buscarPorId($_REQUEST["id"])){
					$instalacion -> disponible=0;
					if ($instalacion->validar()) {
						if(!$instalacion->guardar()){
							$this->dibujaVista("borraInstalacion", array("modelo"=>$instalacion),"Borrar instalacion");
							exit;
						}
						Sistema::app()->irAPagina(array("instalaciones"));
						exit;
					}
					else {
						$this -> dibujaVista("borraInstalacion", array("modelo"=>$instalacion),"Borrar instalaicon");
						exit;
					}
				}
				Sistema::app()->paginaError(400,"La instalacion no se encuentra");
			} 
			
		}

		
		public function accionListaInstalaciones(){
			
			$instalaciones = new Instalaciones();
			
			$opciones=array();
			$cadena="t.disponible = 1";
			$filtrado = array();
			$opciones["select"] = "t.*";
			$opciones["from"] = "";
			$opciones["where"] = "t.cod_instalacion != 0";
			$opciones["order"] = "t.nombre";
			
			if (isset($_REQUEST["nombre"]) && $_REQUEST["nombre"] !=="")
				$cadena.= "and t.nombre='".CGeneral::addSlashes($_REQUEST["nombre"])."'";
			
			$opciones["where"]=$cadena;
			
			$regPag=5;
            $pag=1;
            
            if (isset($_REQUEST["reg_pag"]))
               $regPag=intval($_REQUEST["reg_pag"]);
            
            if (isset($_REQUEST["pag"]))
               $pag=intval($_REQUEST["pag"]);
  
            //compruebo cuantos registros hay
            $filas=$instalaciones->buscarTodos($opciones);          
            
            $regTotal=count($filas);
            
            $nPaginas=intval($regTotal/$regPag);
            if ($regTotal%$regPag>0)
                $nPaginas++;
            
            //compruebo que la pagina sea correcta
            if ($pag<1 || $pag>$nPaginas)
               $pag=1;
            
            $primero=($pag-1)*$regPag;
            $opciones["limit"]="$primero,$regPag";
                 
            $filas=$instalaciones->buscarTodos($opciones);                               
            //opciones del paginador
            $opcPaginador= array("URL" => Sistema::app()->generaURL(array("instalaciones", "listaInstalaciones"), $filtrado),
                                "TOTAL_REGISTROS" => $regTotal,
                                "PAGINA_ACTUAL" => $pag,
                                "REGISTROS_PAGINA" => $regPag,
                                "TAMANIOS_PAGINA"=>array(
                                                  5=>"5",
                                                 10=>"10",
                                                 20=>"20",
                                                 30=>"30",
                                                 40=>"40",
                                                 50=>"50"),
                                "MOSTRAR_TAMANIOS"=>true,
                                "PAGINAS_MOSTRADAS"=>7,
                            );
            $this->dibujaVista("listaInstalaciones", array("filas"=>$filas, "paginador"=>$opcPaginador), "Lista de Intalaciones");
			
		}

	}
