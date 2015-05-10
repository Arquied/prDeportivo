<?php

	class calendariosControlador extends CControlador{
		
		public function accionIndex(){
			
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
        	      Sistema::app() -> sesion() -> set("pagPrevia", array("temporadas"));
        	      Sistema::app() -> sesion() -> set("parametrosAnt", array());
        	      Sistema::app() -> irAPagina(array("inicial", "login"));
        	      exit ;
        	} 
        	else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
        	      Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
            	  exit ;
            } 
			else {
				$calendarios = new Calendarios();       
                $filas=$calendarios->buscarTodos(array("select"=>" t.*, d.dia as dia, act.nombre as actividad",
                                                    "from"=>" join dias d using(cod_dia) join actividades act using(cod_actividad)" 
                                                    )
												);
								
				$this->dibujaVista("indexCalendario",array("filas"=>$filas), "Lista de Calendarios");
			}
			
		}
		
		public function accionNuevoCalendario(){
			
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
        	   Sistema::app() -> sesion() -> set("pagPrevia", array("calendarios", "nuevoCalendario"));
           	   Sistema::app() -> sesion() -> set("parametrosAnt", array());
               Sistema::app() -> irAPagina(array("inicial", "login"));
               exit ;
        	} 
        	else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
               Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
               exit ;
            } 
			else {
			
				$calendario = new Calendarios();
				$calendarioInstalacion = new CalendariosInstalaciones();
				$nombre = $calendario->getNombre();
				
				if (isset($_POST[$nombre])){
						
					$calendario->setValores($_POST[$nombre]);
					$calendario->disponible=1;
					$calendario->cod_actividad = intval($_POST["actividad"]);
					$calendario->cod_dia = intval($_POST["dia"]);
					
					if ($calendario->validar()){
					
						if (!$calendario->guardar()){
							
							Sistema::app()->paginaError(404,"Se ha producido un error al guardar el calendario");
							exit;
						
						}
						
						if (isset($_POST["instalacion"])!=0) {
							$valores["cod_calendario"]  = $calendario->__get("cod_calendario");
							$valores["cod_instalacion"] = $_POST["instalacion"];
							$calendarioInstalacion -> setValores($valores);
							$calendarioInstalacion->cod_calendario_instalacion=100;
						
							if ($calendarioInstalacion->validar()){
								if (!$calendarioInstalacion->guardar()){
							
								echo $calendarioInstalacion->cod_calendario_instalacion;
							//	Sistema::app()->paginaError(404,"Se ha producido un error al guardar el calendario");
								exit;
								
								}
						
							}							
						}

						Sistema::app()->irAPagina(array("calendarios"));
						exit;	

					}
				
					else {
						$this->dibujaVista("nuevoCalendario", array("modelo"=>$calendariol));
					}
				}
				$this->dibujaVista("nuevoCalendario", array("modelo"=>$calendario));
			
			}		
			
		}

	public function accionBorraCalendario(){
			
		if(!Sistema::app()->acceso()->hayUsuario()){
			Sistema::app()->sesion()->set("pagPrevia", array("calendarios", "borraCalendario"));
			Sistema::app()->sesion()->set("parametrosAnt", array());
			Sistema::app()->irAPagina(array("inicial", "login"));
			exit;
		}
		else if(!Sistema::app()->acceso()->puedeConfigurar()){
			Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
			exit;
		}
		else{
			$calendario = new Calendarios();
			if ($calendario->buscarPorId($_REQUEST["id"])){
				$calendario -> disponible=0;
				if ($calendario->validar()) {
					if(!$calendario->guardar()){
						$this->dibujaVista("borraCalendario", array("modelo"=>$calendario),"Borrar calendario");
						exit;
					}
					Sistema::app()->irAPagina(array("calendarios"));
					exit;
				}
				else {
					$this -> dibujaVista("borraCalendario", array("modelo"=>$calendario),"Borrar calendario");
					exit;
				}
			}
			Sistema::app()->paginaError(400,"El Calendario no se encuentra");
		} 
			
	}
