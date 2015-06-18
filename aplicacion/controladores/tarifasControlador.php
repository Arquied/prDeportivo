<?php

    /**
     * CONTROLADOR TARIFAS
     */
    class tarifasControlador extends CControlador {
        
        //Funcion que añade nueva tarifa para una determinada actividad
        public function accionNuevaTarifa(){            
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("tarifas", "nuevaTarifa"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("cod_actividad"=>$_GET["cod_actividad"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                exit ;
            } 
            else if(isset($_GET["cod_actividad"])){
                $actividad=new Actividades();
                if($actividad->buscarPorId(intval($_GET["cod_actividad"]))){
                    $tarifa = new Tarifas();
                    $nombre = $tarifa -> getNombre();
                    if (isset($_POST[$nombre])) {
                        $tarifa -> setValores($_POST[$nombre]);
                        $tarifa -> cod_actividad = intval($_GET["cod_actividad"]);                                 
                        if ($tarifa -> validar()) {
                            if (!$tarifa -> guardar()) { //guarda la tarifa
                                $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), htmlentities("Nueva Tarifa"));
                                exit ;
                            }                                                 
                            Sistema::app() -> irAPagina(array("actividades", "listaActividadesCrud"));
                            exit ;
                        } else {
                            $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), "Nueva Tarifa");
                            exit ;
                        }
                    } else{
                        $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), "Nueva Tarifa");
                        exit;    
                    }     
                }
                Sistema::app() -> paginaError(400, "Actividad no encontrada");
                exit;               
            }
            Sistema::app() -> irAPagina(array("actividades", "listaActividadesCrud"));
            exit ;  
        }
        
        public function accionTarifasActividad(){
            if(isset($_POST["cod_actividad"])){
                $tarifa=new Tarifas();
                $tarifasActividad=$tarifa->buscarTodos(array("select"=>" t.cod_tarifa, tc.tipo, t.precio, tc.diario", 
                                            "from"=>" join tipos_cuotas tc using(cod_tipo_cuota) ",
                                            "where"=>" t.cod_actividad=".intval($_POST["cod_actividad"])));
                $obJSON=json_encode($tarifasActividad);
                echo $obJSON;
            }
        }
		
		public function accionListaTarifas(){
	         if (!Sistema::app() -> acceso() -> hayUsuario()) {
	              Sistema::app() -> sesion() -> set("pagPrevia", array("tarifas", "listaTarifas"));
	              Sistema::app() -> sesion() -> set("parametrosAnt", array());
	              Sistema::app() -> irAPagina(array("inicial", "login"));
	              exit ;
	        } 
	        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
	             Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
	             exit ;
	       	} 
			else {
				$tarifas = new Tarifas();
				
				$filas = $tarifas -> buscarTodos(array("select"=>"t.*, tc.tipo as tipo, a.nombre as actividad","from"=>"join tipos_cuotas tc using(cod_tipo_cuota) join actividades a using(cod_actividad)"));
				
				$this->dibujaVista("listaTarifas",array("filas"=>$filas), "Lista de Tarifas");
			}	
		}
		
		public function accionCrudNuevaTarifa(){
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
	              Sistema::app() -> sesion() -> set("pagPrevia", array("tarifas", "listaTarifas"));
	              Sistema::app() -> sesion() -> set("parametrosAnt", array());
	              Sistema::app() -> irAPagina(array("inicial", "login"));
	              exit ;
	        } 
	        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
	             Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
	             exit ;
	       	} 
			else {
				$tarifa = new Tarifas();
				
				$nombre = $tarifa->getNombre();
				
				if(isset($_POST[$nombre])){
					$tarifa->setValores($_POST[$nombre]);
					if ($tarifa -> validar()){
						if (!$tarifa -> guardar()) { //guarda la tarifa
                            $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), htmlentities("Nueva Tarifa"));
                            exit ;
						}
						Sistema::app()->irAPagina(array("tarifas", "listaTarifas"));
						exit;
					}
					else {
                        $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), "Nueva Tarifa");
                        exit ;
					}
				}
				else 
                    $this -> dibujaVista("nuevaTarifa", array("modelo" => $tarifa), "Nueva Tarifa");
			}
		}
		
		public function accionModificaTarifa(){
			if (!Sistema::app() -> acceso() -> hayUsuario()) {
	              Sistema::app() -> sesion() -> set("pagPrevia", array("tarifas", "listaTarifas"));
	              Sistema::app() -> sesion() -> set("parametrosAnt", array());
	              Sistema::app() -> irAPagina(array("inicial", "login"));
	              exit ;
	        } 
	        else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
	             Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
	             exit ;
	       	} 
			else {
				$tarifa = new Tarifas();
				
				if ($tarifa->buscarPorId(isset($_GET["cod_tarifa"]))){
					$nombre = $tarifa->getNombre();
					if (isset($_POST[$nombre])){
						$tarifa->setValores($_POST[$nombre]);
							
						if ($tarifa -> validar()){
							if (!$tarifa -> guardar()) { //guarda la tarifa
	                            $this -> dibujaVista("modificaTarifa", array("modelo" => $tarifa), htmlentities("Modifica Tarifa"));
	                            exit ;
							}
							Sistema::app()->irAPagina(array("tarifas", "listaTarifas"));
							exit;
						}
						else {
	                        $this -> dibujaVista("modificaTarifa", array("modelo" => $tarifa), "Modifica Tarifa");
	                        exit ;
						}
						
					}	
					else 
	                    $this -> dibujaVista("modificaTarifa", array("modelo" => $tarifa), "Modifica Tarifa");
				}
				
			}	
		}

		public function accionBorraTarifa(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de borrar		
			if(!Sistema::app()->acceso()->hayUsuario()){
				Sistema::app()->sesion()->set("pagPrevia", array("tarifas", "borraTarifa"));
				Sistema::app()->sesion()->set("parametrosAnt", array("id"=>$_REQUEST["id"]));
				Sistema::app()->irAPagina(array("inicial", "login"));
				exit;
			}
			else if(!Sistema::app()->acceso()->puedeConfigurar()){
				Sistema::app()->paginaError(400, "No tiene permiso para acceder");	
				exit;
			}
			else{
				$tarifa=new Tarifas();		
				if($tarifa->buscarPorId($_REQUEST["id"])){					
					$tarifa -> disponible=0;				
					if ($tarifa -> validar()) {										
						if(!$tarifa->guardar()){
							Sistema::app()->paginaError(400, "Error al borrar la tarifa");
							exit ;
						}
						Sistema::app()->irAPagina(array("tarifas", "listaTarifas"));
						exit ;
					} 
					else {
						Sistema::app()->paginaError(400, "Error al borrar la tarifa");
						exit ;
					}		
				}
				Sistema::app()->paginaError(400, "La tarifa no se encuentra");
			}
		}
		
    }
    
