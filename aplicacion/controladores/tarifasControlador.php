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
                        $tarifa -> cod_actividad= intval($_GET["cod_actividad"]);                                 
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
    }
    
