<?php

	class temporadasControlador extends CControlador {
		
		public function accionIndex(){
			
			$temporadas = new Temporadas();
			
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
			
			$this->dibujaVista("index",array("temporadas"=>$temporadas));
		}
		}
		
		public function accionNuevaTemporada() {
			
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
			$temporada = new Temporadas();
			
			$nombre = $temporada->getNombre();
			
			if (isset($_POST[$nombre])){
					
				$temporada->setValores($_POST[$nombre]);
				$temporada->cod_temporada=100;
				
				if ($temporada->validar()){
					
					if (!$temporada->guardar()){
						Sistema::app()->paginaError(404,"Se ha producido un error al guardar la temporada");
						exit;
					}
					
					Sistema::app()->irAPagina("temporada","index");
					exit;
				}
				
				else {
					$this->dibujaVista("nueva", array("modelo"=>$temporada));
				}
				
			}

			$this->dibujaVista("nueva", array("modelo"=>$temporada));
		}
		}

		public function accionModificarTemporada(){
			
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
			if (isset($_REQUEST["id"]))
			    $id=intval($_REQUEST["id"]);
			
			$temporada = new Temporadas();
			
			if(!$temporada->buscarPorId($id)){
				
				Sistema::app()->paginaError(404,"No tienes permiso para acceder a esta pagina");
				
		    	}
			
			$nombre = $temporada->getNombre();
			
			if (isset($_POST[$nombre])){
				 	
			 	$temporada->setValores($_POST[$nombre]);

				if ($temporada->validar()) {
					 
				    	if (!$temporada->guardar()){
						   	  Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
						   	  exit;
						   }
						
				    	Sistema::app()->irAPagina(array("temporada","index"));
				    	exit;
				    }
				   else { 
						$this->dibujaVista("modificar",
										array("modelo"=>$temporada),"Modificaci&oacute; de temporada");
				   	   	exit;			   	   
				   	}	
			}
			
					
			$this->dibujaVista("modificar",array("modelo"=>$temporada),"Modificaci&oacute; de temporada");
			
		}
		}
	}
