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
                $filas=$horarioGeneral->buscarTodos(array("select"=>" t.*, tem.nombre as temporada, d.dia as dia",
                                                    "from"=>" join temporadas tem using(cod_temporada) join dias d using(cod_dia)" 
                                                    )
												);
                
                $this->dibujaVista("indexHorario", array("filas"=>$filas), "Lista de Horarios ");
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
				$horarioGeneral->setValores($_POST[$nombre]);
				echo  $hora_inicio = $horarioGeneral -> hora_inicio;
				echo $hora_fin = $horarioGeneral -> hora_fin;
				$horarioGeneral -> disponible = 1;
				$horarioGeneral -> cod_temporada = intval($_POST["temporada"]);
				
				$creado = false;
						
				for ($cont=0; $cont < count($_POST["dia"]);$cont++){

				$horarioGeneral -> cod_dia = intval($_POST["dia"][$cont]);
				$horarioGeneral -> hora_inicio = $hora_inicio;
				$horarioGeneral -> hora_fin = $hora_fin;
				$horarioGeneral-> setValores($_POST[$nombre]);
				$horarioGeneral -> disponible = 1;
				$horarioGeneral -> cod_temporada = intval($_POST["temporada"]);
					
					if ($horarioGeneral -> validar()){
						if (!$horarioGeneral -> guardar()){
							Sistema::app()->paginaError(404,"Se ha producido un error al guardar el horario");
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
					//	Sistema::app() -> irAPagina(array("horarios"));
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
						$this->dibujaVista("borraHorario", array("modelo"=>$horario),"Borrar horario");
						exit;
					}
					Sistema::app()->irAPagina(array("horarios"));
					exit;
				}
				else {
					$this -> dibujaVista("borraHorario", array("modelo"=>$horario),"Borrar horario");
					exit;
				}
			}
			Sistema::app()->paginaError(400,"El horario no se encuentra");
		} 
			
	}
	
	}
