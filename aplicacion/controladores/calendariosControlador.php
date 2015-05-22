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
                            //  Sistema::app()->paginaError(404,"Se ha producido un error al guardar el calendario");
                                exit;
                                
                                }
                        
                            }                           
                        }

                        Sistema::app()->irAPagina(array("calendarios"));
                        exit;   
                    }
                
                    else {
                        $this->dibujaVista("nuevoCalendario", array("modelo"=>$calendario));
                    }
                }
                $this->dibujaVista("nuevoCalendario", array("modelo"=>$calendario));
            
            }       
            
        }

        public function accionModificaCalendario(){
                
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("calendarios", "modificaCalendario"));
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
                $calInstalacion = new CalendariosInstalaciones();
                
                if ($calendario->buscarPorId($_GET["cod_calendario"])){
                    
                    $nombre = $calendario->getNombre();
                    
                    if (isset($_POST[$nombre])){
                        
                        $calendario->setValores($nombre);
                        
                        $calInstalacion->borrarCaeldarioInstalacion($_GET["cod_calendario"]);
                        $valores["cod_calendario"]=$_GET["cod_calendario"];
                        $valoes["cod_instalacion"]=$_POST["instalacion"];
                        
                        $calInstalacion->setValores($valores);
                        if ($calInstalacion->validar()){
                            if (!$calInstalacion->guardar()){
                                Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
                                exit;
                            }   
                        }
                        
                        
                        if ($calendario->validar()){
                            
                            if (!$calendario->guardar()){
                              Sistema::app()->paginaError(404,"Se ha producido un error al guardar");
                              exit;
                            }
                            
                            Sistema::app()->irAPagina(array("calendarios"));
                            exit;
                            
                        }
                        
                        else {
                            $this->dibujaVista("modificaCalendario", array("modelo"=>$calendario),"Modificaci&oacute; de calendario");
                            exit;
                        }
                    }
                    
                }
                $this->dibujaVista("modificaCalendario", array("modelo"=>$calendario),"Modificaci&oacute; de calendario");
                            
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
    
    public function accionMostrarCalendario(){
            
    $time = strtotime('monday this week');
    
    echo(date('Y-m-d', strtotime('monday this week')));
    echo(date('Y-m-d', strtotime('tuesday this week')));
    
    $this -> dibujaVista("calendario",array(),"Calendario");
    
    }

	//Funcion que devuelve un objeto json con el caledanrio de la actividad
	public function accionCalendarioActividad(){
		if($_POST["cod_actividad"] && $_POST["fechaSenalada"]){	                
        	$calendario=new Calendarios();
			$sentSelect=" t.cod_calendario, t.hora_inicio, t.hora_fin, d.dia, d.cod_dia, '".date("Y-m-d",strtotime("last monday", strtotime($_POST["fechaSenalada"])))."' as lunes  ";
            $sentFrom=" join dias d using(cod_dia) ";
            $sentWhere=" t.cod_actividad=".intval($_POST["cod_actividad"]).
                        " and t.fecha_inicio<='".date("Y-m-d",strtotime("last monday", strtotime($_POST["fechaSenalada"])))."'".
                        " and t.fecha_fin>='".date("Y-m-d",strtotime("next sunday", strtotime($_POST["fechaSenalada"])))."'";
			$sentOrder=" d.cod_dia, t.hora_inicio ";
            
			$datosCalendario=$calendario->buscarTodos(array("select"=>$sentSelect, "from"=>$sentFrom, "where"=>$sentWhere, "order"=>$sentOrder));			
			
			$json=json_encode($datosCalendario);
			echo $json;	
		}	
	}
    
    
}
