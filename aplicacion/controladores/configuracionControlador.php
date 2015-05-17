<?php

	class configuracionControlador extends CControlador {
		
		public function accionIndex(){
			
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
        	      Sistema::app() -> sesion() -> set("pagPrevia", array("configuracion"));
        	      Sistema::app() -> sesion() -> set("parametrosAnt", array());
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
		}
		
	}
