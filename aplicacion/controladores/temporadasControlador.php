<?php

	class temporadasControlador extends CControlador {
		
		// Función que muestra la lista de temporadas
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
			$temporadas = new Temporadas();
			
			$filas = $temporadas->buscarTodos(array("select"=>" t.*"));
			
			$this->dibujaVista("indexTemporada",array("filas"=>$filas));
		}
		}
		
		// Función que añade una nueva temporada
		public function accionNuevaTemporada() {
			
		if (!Sistema::app() -> acceso() -> hayUsuario()) {
              Sistema::app() -> sesion() -> set("pagPrevia", array("temporadas", "nuevaTemporada"));
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
				$temporada->disponible=1;
				
				if ($temporada->validar()){
					
					if (!$temporada->guardar()){
						Sistema::app()->paginaError(404,"Se ha producido un error al guardar la temporada");
						exit;
					}
					
					Sistema::app()->irAPagina(array("temporadas"));
					exit;
				}
				
				else {
					$this->dibujaVista("nuevaTemporada", array("modelo"=>$temporada));
				}
				
			}

			$this->dibujaVista("nuevaTemporada", array("modelo"=>$temporada));
		}
		}

		// Función que muestra una temporada
		public function accionModificaTemporada(){
		if (!Sistema::app() -> acceso() -> hayUsuario()) {
              Sistema::app() -> sesion() -> set("pagPrevia", array("temporadas", "modificaTemporada"));
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
			
			if($temporada->buscarPorId($_GET["cod_temporada"])){
					
				$nombre = $temporada->getNombre();
			
				if (isset($_POST[$nombre])){
				 	
			 		$temporada->setValores($_POST[$nombre]);

					if ($temporada->validar()) {
					 
				    	if (!$temporada->guardar()){
						   	  Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
						   	  exit;
						   }
						
				    	Sistema::app()->irAPagina(array("temporadas"));
				    	exit;
				    }
				   else { 
						$this->dibujaVista("modificaTemporada",
										array("modelo"=>$temporada),"Modificaci&oacute; de temporada");
				   	   	exit;			   	   
				   	}	
			}
				
		    	}
					
			$this->dibujaVista("modificaTemporada",array("modelo"=>$temporada),"Modificaci&oacute; de temporada");
			
		}
		}

		// Función que borra una temporada
		public function accionBorraTemporada(){
			
			if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("temporadas", "borraTemporada"));
				Sistema::app()->sesion()->set("parametrosAnt", array());
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$temporada= new Temporadas();
				if ($temporada->buscarPorId($_REQUEST["id"])){
					$temporada -> disponible=0;
					if ($temporada->validar()) {
						if(!$temporada->guardar()){
							$this->dibujaVista("borraTemporada", array("modelo"=>$temporada),"Borrar temporada");
							exit;
						}
						Sistema::app()->irAPagina(array("temporadas"));
						exit;
					}
					else {
						$this -> dibujaVista("borraTemporada", array("modelo"=>$temporada),"Borrar temporada");
						exit;
					}
				}
				Sistema::app()->paginaError(400,"La temporada no se encuentra");
			} 
		}

	}
