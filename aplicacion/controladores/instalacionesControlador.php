<?php

class instalacionesControlador extends CControlador {
	
	//Funcion que muestra todos los instalaciones
	public function accionIndex(){
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
			$instalaciones = new Instalaciones();
			
			$this->dibujaVista("index",array("modelo"=>$instalaciones));			
		}

		
	}
	
	// Funcion que añade nuevas instalaciones
	public function accionNuevaInstalacion(){
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
		
		$instalacion = new Instalaciones();
		
		$nombre = $instalacion->getNombre();
		
		if(isset($_POST[$nombre])){
			
			$instalacion->setValores($_POST[$nombre]);
			$instalacion->cod_instalacion=100;
			
			if($instalacion->validar()){
				
				if (!$instalacion->guardar()){
					Sistema::app()->paginaError(404,"Se ha producido un error al guardar la temporada");
					exit;
				}
					
				Sistema::app()->irAPagina(array("instalaciones","index"));
				exit;
			}
			
			else {
				$this->dibujaVista("nueva",array("modelo"=>$instalacion));
			}
		}
		
		$this->dibujaVista("nueva",array("modelo"=>$instalacion));
		}
	}
	
	// Funcion que modifica instalaciones
	public function accionModificarInstalacion(){
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
		
		$id=-1;
		if(isset($_REQUEST["id"]))
			$id=intval($_REQUEST["id"]);
		
		$instalacion = new Instalaciones();
		
		if(!$instalacion->buscarPorId($id)){
			
			Sistema::app()->paginaError(404,"No tiene permiso para acceder a esta pagina");
	
		}
		
		$nombre = $instalacion->getNombre();
		
		if(isset($_POST[$nombre])){
			
			$instalacion->setValores($_POST[$nombre]);
			
			if($instalacion->validar()){
				
				if (!$instalacion->guardar()){
			 		Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
			     	exit;
				}

				Sistema::app()->irAPagina(array("inicial","index"));
				exit;
				}
				else { 
					$this->dibujaVista("modificar",
									array("modelo"=>$instalacion),"Modificaci&oacute; de instalacion");
				   	exit;			   	   
				   	}	
			
			}
		
		$this->dibujaVista("modificar",array("modelo"=>$instalacion),"Modificaci&oacute; de instalacion");
			
		}
		}
	}
