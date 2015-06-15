<?php

    class actividadesControlador extends CControlador{
    
        //Funcion que añade nuevas actividades
        public function accionNuevaActividad(){            
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("actividades", "nuevaActividad"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else {
                $actividad = new Actividades();
                $nombre = $actividad -> getNombre();
				//Obtener el codigo de la temporada actual
				$temporada=new Temporadas();
				$datosTemporadaActual=$temporada->buscarTodos(array("where"=>" t.fecha_inicio<='".date("Y-m-d")."' and t.fecha_fin>='".date("Y-m-d")."'"));
				if($datosTemporadaActual){
					$actividad->cod_temporada=$datosTemporadaActual[0]["cod_temporada"];
				}
				
                if (isset($_POST[$nombre])) {
                    $actividad -> setValores($_POST[$nombre]);
                    
                    $actividad -> imagen = $_FILES["actividad"]["name"]["imagen"];
                    if ($actividad -> validar()) {
                        if (!$actividad -> guardar()) { //guarda la actividad
                            $this -> dibujaVista("nuevaActividad", array("modelo" => $actividad), htmlentities("Nueva Actividad"));
                            exit ;
                        }                        
                        //Cargar imagen
                        if (isset($_FILES["actividad"]) && $_FILES["actividad"]["error"]["imagen"] != 4) {
                        	$actividad -> imagen = "act" . substr("0000000000" . $actividad -> cod_actividad, -10);
                            $imagen = "";
                            //segun sea la imagen
                            switch ($_FILES["actividad"]["type"]["imagen"]) {
                                case 'image/jpeg' :
                                    $imagen = imagecreatefromjpeg($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad -> imagen .= ".jpg";
                                    if (is_resource($imagen)) {
                                        $ruta = "/imagenes/actividades/" . $actividad -> imagen;
                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
                                        imagejpeg($imagen, $ruta);
                                    }
                                    break;
    
                                case 'image/gif' :
                                    $imagen = imagecreatefromgif($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad -> imagen .= ".gif";
                                    if (is_resource($imagen)) {
                                        $ruta = "/imagenes/actividades/" . $actividad -> imagen;
                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
                                        imagegif($imagen, $ruta);
                                    }
                                    break;
    
                                case 'image/png' :
                                    $imagen = imagecreatefrompng($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad -> imagen .= ".png";
                                    if (is_resource($imagen)) {
                                        $ruta = "/imagenes/actividades/" . $actividad -> imagen;
                                        $ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
                                        imagepng($imagen, $ruta);
                                    }
                                    break;
                            }
                        }
                        if (!$actividad -> guardar()) { //vuelve a guardar la imagen despues de modificar la imagen
                            $this -> dibujaVista("nuevaActividad", array("modelo" => $actividad), "Nueva Actividad");
                            exit ;
                        } 
						Sistema::app() -> irAPagina(array("inicial", "index"));
                        exit ;
                    } else {
                        $this -> dibujaVista("nuevaActividad", array("modelo" => $actividad), "Nueva Actividad");
                        exit ;
                    }
                } else
                    $this -> dibujaVista("nuevaActividad", array("modelo" => $actividad), "Nueva Actividad");
            }    
        }   

        //Funcion que añade modifica actividades
        public function accionModificaActividad(){            
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("actividades", "modificaActividad"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("cod_actividad"=>$_GET["cod_actividad"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else {
                $actividad = new Actividades();
                if($actividad->buscarPorId($_GET["cod_actividad"])){
                    if(isset($_POST[$actividad->getNombre()])){
                    $actividad -> setValores($_POST[$actividad->getNombre()]); 	                   
                                     
                    if ($actividad -> validar()) {                                       
                        if (!$actividad -> guardar()) {
                            $this -> dibujaVista("modificaActividad", array("modelo" => $actividad), "Modificar actividad");
                            exit ;
                        }                                                                 
                        //Cargar imagen
                        if (isset($_FILES["actividad"]) && $_FILES["actividad"]["error"]["imagen"]!=4){
                        	$actividad -> imagen="act".substr("0000000000".$actividad->cod_actividad, -10);
                            $imagen="";
                            //segun sea la imagen
                            switch ($_FILES["actividad"]["type"]["imagen"]) {
                                case 'image/jpeg':
                                    $imagen=imagecreatefromjpeg($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad->imagen.=".jpg";  
                                    imagealphablending($imagen, true);
                                    imagesavealpha($imagen, true);
                                    if (is_resource($imagen)){
                                        $ruta="/imagenes/actividades/".$actividad->imagen;
                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                        imagejpeg($imagen,$ruta);
                                    }                                   
                                    break;
                                    
                                case 'image/gif':
                                    $imagen=imagecreatefromgif($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad->imagen.=".gif";  
                                    imagealphablending($imagen, true);
                                    imagesavealpha($imagen, true);
                                    if (is_resource($imagen)){
                                        $ruta="/imagenes/actividades/".$actividad->imagen;
                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                        imagegif($imagen,$ruta);
                                    }
                                    break;
        
                                case 'image/png':
                                    $imagen=imagecreatefrompng($_FILES["actividad"]["tmp_name"]["imagen"]);
                                    $actividad->imagen.=".png";  
                                    imagealphablending($imagen, true);
                                    imagesavealpha($imagen, true);
                                    if (is_resource($imagen)){
                                        $ruta="/imagenes/actividades/".$actividad->imagen;
                                        $ruta=$_SERVER["DOCUMENT_ROOT"].$ruta;
                                        imagepng($imagen,$ruta);
                                    }
                                    break;
                            }
                        }
                  	    if(!$actividad->guardar()){
                            $this -> dibujaVista("modificaActividad", array("modelo" => $actividad), "Modificar actividad");
                            exit ;
                        }	                  	
                        Sistema::app()->irAPagina(array("actividades", "listaActividadesCrud"));
                        exit ;
                    } 
                    else {
                        $this -> dibujaVista("modificaActividad", array("modelo" => $actividad), "Modificar actividad");
                        exit ;
                    }       
                }               
                $this->dibujaVista("modificaActividad", array("modelo"=>$actividad), "Modificar actividad");
                exit;
            }   
            Sistema::app()->paginaError(400, "La actividad no se encuentra");
                
            }        
        }

		public function accionBorraActividad(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de borrar		
			if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("actividades", "borraActividad"));
				Sistema::app()->sesion()->set("parametrosAnt", array("id"=>$_REQUEST["id"]));
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$actividad=new Actividades();		
				if($actividad->buscarPorId($_REQUEST["id"])){					
					$actividad -> disponible=0;				
					if ($actividad -> validar()) {										
						if(!$actividad->guardar()){
							Sistema::app()->paginaError(400, "Error al borrar la actividad");
							exit ;
						}
						Sistema::app()->irAPagina(array("actividades", "listaActividadesCrud"));
						exit ;
					} 
					else {
						Sistema::app()->paginaError(400, "Error al borrar la actividad");
						exit ;
					}		
				}
				Sistema::app()->paginaError(400, "La actividad no se encuentra");
			}
		}

		public function accionListaActividadesCrud(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("actividades", "listaActividadesCrud"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else {
                $actividades=new Actividades(); 
				
				//establezco las opciones de filtrado
	            $opciones=array();
	            $cadena=" t.disponible=1 ";
	            $filtrado=array();
	            $opciones["select"]=" t.*, tem.nombre as temporada "; 
	            $opciones["from"]=" join temporadas tem using(cod_temporada) ";
	            $opciones["order"]= " t.nombre ";
	            //filtrado 
	            //si no existe filtrado se muestran todas las actividades				
				//Filtro temporada
				if(isset($_REQUEST["temporada"]) && $_REQUEST["temporada"]!==""){
					$cadena.=" and t.cod_temporada=".intval($_REQUEST["temporada"]);
				}
				else{
					$cadena.=" and tem.fecha_inicio<='".date("Y-m-d")."' and tem.fecha_fin>='".date("Y-m-d")."'";	
				}
	            
	            $opciones["where"]=$cadena;
				
				      
                $filas=$actividades->buscarTodos($opciones);												
                
                $this->dibujaVista("listaActividadesCrud", array("filas"=>$filas), "Lista de Actividades ");
           }
        }    
    
        public function accionListaActividades(){
            $actividades=new Actividades();
            
            //establezco las opciones de filtrado
            $opciones=array();
            $cadena=" t.disponible=1 ";
            $filtrado=array();
            $opciones["select"]=" t.*"; 
            $opciones["from"]=" join temporadas tem using(cod_temporada) ";
            $opciones["order"]= " t.nombre ";
            //filtrado 
            //si no existe filtrado se muestran todas las actividades
            
            //Filtro categoria
            if(isset($_REQUEST["categoria"]) && $_REQUEST["categoria"]!==""){
                $cadena.=" and t.cod_categoria=".intval($_REQUEST["categoria"]);
            }
            
            //Filtro nombre_actividad
            if(isset($_REQUEST["nombre"]) && $_REQUEST["nombre"]!==""){
                $cadena.=" and t.nombre='".CGeneral::addSlashes($_REQUEST["nombre"])."'";
            }
			
			//Filtro temporada
			if(isset($_REQUEST["temporada"]) && $_REQUEST["temporada"]!==""){
				$cadena.=" and t.cod_temporada=".intval($_REQUEST["temporada"]);
			}
			else{
				$cadena.=" and tem.fecha_inicio<='".date("Y-m-d")."' and tem.fecha_fin>='".date("Y-m-d")."'";	
			}
            
            $opciones["where"]=$cadena;         

            //preparar los parametros para el paginador y el grid           
            $regPag=5;
            $pag=1;
            
            if (isset($_REQUEST["reg_pag"]))
               $regPag=intval($_REQUEST["reg_pag"]);
            
            if (isset($_REQUEST["pag"]))
               $pag=intval($_REQUEST["pag"]);
  
            //compruebo cuantos registros hay
            $filas=$actividades->buscarTodos($opciones);          
            
            $regTotal=count($filas);
            
            $nPaginas=intval($regTotal/$regPag);
            if ($regTotal%$regPag>0)
                $nPaginas++;
            
            //compruebo que la pagina sea correcta
            if ($pag<1 || $pag>$nPaginas)
               $pag=1;
            
            $primero=($pag-1)*$regPag;
            $opciones["limit"]="$primero,$regPag";
                 
            $filas=$actividades->buscarTodos($opciones);                               
            //opciones del paginador
            $opcPaginador= array("URL" => Sistema::app()->generaURL(array("actividades", "listaActividades"), $filtrado),
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
            $this->dibujaVista("listaActividades", array("filas"=>$filas,  "categoria"=>(isset($_REQUEST["categoria"]) && $_REQUEST["categoria"]!=="")?$_REQUEST["categoria"]: "", "paginador"=>$opcPaginador), "Lista de Actividades");
        }

        //Accion que devuelve la informacion de la actividad 
        //en un objeto JSON
        public function accionActividadJSON(){
            if($_POST["cod_actividad"]){
            	$actividad=new Actividades();                
				$datosActividad=$actividad->buscarTodos(array("where"=>"cod_actividad=".intval($_POST["cod_actividad"])));			
				
				$json=json_encode($datosActividad);
				echo $json;				
            }
        }
 		
		//Accion que devuelve las actividades para una temporada en concreto
        //en un objeto JSON
        public function accionActividadesTemporadaJSON(){
            if($_POST["cod_temporada"]){
            	$actividad=new Actividades();                
				$datosActividad=$actividad->buscarTodos(array("where"=>"cod_temporada=".intval($_POST["cod_temporada"])));			
				
				$json=json_encode($datosActividad);
				echo $json;				
            }
        }
    }
        
