<?php
	class horariosControlador extends CControlador {
		
		// Función que muestra la lista de horarios
		public function accionIndex(){
			
      		if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("horarios"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else {
                $horarioGeneral=new HorarioGeneral(); 
				//establezco las opciones de filtrado
	            $opciones=array();
	            $cadena="";
	            $filtrado=array();
	            $opciones["select"]=" t.*, tem.nombre as temporada, d.dia as dia "; 
	            $opciones["from"]=" join temporadas tem using(cod_temporada) join dias d using(cod_dia) ";
	            //filtrado 
	            //si no existe filtrado se muestran todas las actividades				
				//Filtro temporada
				if(isset($_REQUEST["temporada"]) && $_REQUEST["temporada"]!==""){
					$cadena.=" tem.cod_temporada=".intval($_REQUEST["temporada"]);
					$temporada=intval($_REQUEST["temporada"]);
				}
	            
	            $opciones["where"]=$cadena;
				
				      
                $filas=$horarioGeneral->buscarTodos($opciones);	      
                
                
                $this->dibujaVista("indexHorario", array("filas"=>$filas, "temporada"=>(isset($temporada)? $temporada: "")), "Lista de Horarios ");
           }
		}
		
		// Función que añade un horario nuevo
		public function accionNuevoHorario(){			
    		if (!Sistema::app() -> acceso() -> hayUsuario()) {
                  Sistema::app() -> sesion() -> set("pagPrevia", array("horarioGeneral", "nuevoHorario"));
                  Sistema::app() -> sesion() -> set("parametrosAnt", array());
                  Sistema::app() -> irAPagina(array("inicial", "login"));
                  exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                  Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                  exit ;
                } 
    		else {
    			$horarioGeneral = new HorarioGeneral();
    			$dias = new Dias();
    			
    			$nombre = $horarioGeneral->getNombre();
    			$nomDias = $dias->getNombre();
    			if(isset($_POST[$nombre])){
            		$creado = false;
    						
    				for ($cont=0; $cont < count($_POST["dia"]);$cont++){
        				$horarioGeneral -> cod_dia = intval($_POST["dia"][$cont]);
        				$horarioGeneral  -> setValores($_POST[$nombre]);
        				$horarioGeneral -> cod_temporada = intval($_POST["temporada"]);
    					
    					if ($horarioGeneral -> validar()){
    						if (!$horarioGeneral -> guardar()){
    							Sistema::app()->paginaError(404, "Se ha producido un error al guardar el horario");
    							exit;
    						}
    						else {
    							$creado = true;
    						}
    					}		
    					else {
    						$this->dibujaVista("nuevoHorario", array("modelo" => $horarioGeneral), "Nuevo horario");
    						exit;
    					}				
    					$horarioGeneral = new HorarioGeneral();	
    			     }
        			 if ($creado == true){
        			    Sistema::app() -> irAPagina(array("horarios"));
        				exit;
        		     }		
    	       }
           $this -> dibujaVista("nuevoHorario", array("modelo" => $horarioGeneral,"dias"=>$dias), "Nuevo horario");
    	   }
		}
		
		// Función que modifica un horario
		public function accionModificaHorario(){			
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("horarios", "modificaHorario"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
		    else {			
			$horarioGeneral = new HorarioGeneral();
    			if ($horarioGeneral->buscarPorId($_GET["cod_horario_general"])){
    				if (isset($_POST[$horarioGeneral->getNombre()])){
    					$horarioGeneral -> setValores($_POST[$horarioGeneral->getNombre()]);
    					$horarioGeneral ->cod_dia = intval($_POST["dia"]);
    					$horarioGeneral -> cod_temporada = intval($_POST["temporada"]);
    					
    					if ($horarioGeneral -> validar()){
    						if (!$horarioGeneral -> guardar()){
    							$this -> dibujaVista("modificaHorario", array("modelo" => $horarioGeneral), "Modificar Horario");
    							exit;
    						}
    						Sistema::app()->irAPagina(array("horarios"));
    						exit;
    					}
    					else {
    						$this -> dibujaVista("modificaHorario", array("modelo" => $horarioGeneral), "Modificar Horario");
    						exit;
    					}
    				}
    				$this->dibujaVista("modificaHorario", array("modelo"=>$horarioGeneral), "Modificar Horario");
    				exit;
    			}
    			Sistema::app()->paginaError(400, "El horario no se encuentra");
		   }	
	}
	
	// Función que borra un horario
	public function accionBorraHorario(){			
		if(!Sistema::app()->acceso()->hayUsuario()){
			Sistema::app()->sesion()->set("pagPrevia", array("horarios", "borraHorario"));
			Sistema::app()->sesion()->set("parametrosAnt", array());
			Sistema::app()->irAPagina(array("inicial", "login"));
			exit;
		}
		else if(!Sistema::app()->acceso()->puedeConfigurar()){
			Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
			exit;
		}
		else{
			$horario = new HorarioGeneral();
			if ($horario->buscarPorId($_REQUEST["id"])){
				$horario -> disponible=0;
				if ($horario->validar()) {
					if(!$horario->guardar()){
						Sistema::app()->paginaError(400, "Error al borrar horario");
                        exit ;
					}
					Sistema::app()->irAPagina(array("horarios"));
					exit;
				}
				else {
					Sistema::app()->paginaError(400, "Error al borrar horario");
                    exit ;
				}
			}
			Sistema::app()->paginaError(400,"El horario no se encuentra");
		} 
			
	}
	
}
