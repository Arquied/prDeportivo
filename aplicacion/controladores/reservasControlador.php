<?php

    class reservasControlador extends CControlador{
        
        public function accionNuevaReserva() {
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "nuevaReserva"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            }
            else{
            	$reserva=new Reservas();
            	if(isset($_GET["cod_actividad"])){
            		$actividad=new Actividades();
					if($actividad->buscarPorId(intval($_GET["cod_actividad"]))){
						$reserva->cod_actividad=intval($actividad->cod_actividad);
						$this->dibujaVista("nuevaReserva", array("modelo"=>$reserva), "Reservar");
						exit;	
					}
					else {
						$this->dibujaVista("nuevaReserva", array("modelo"=>$reserva), "Reservar");
						exit;
					}
            	}
				else{
					$this->dibujaVista("nuevaReserva", array("modelo"=>$reserva), "Reservar");
					exit;
				}                
            }  
        }

		public function accionFinalizarReserva(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            /*if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "finalizarReserva"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("reservas"=>$_POST["reservas"], "actividad"=>$_POST["actividad"], "tarifa"=>$_POST["tarifa"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            }
			else */if(isset($_POST["reservas"]) && isset($_POST["actividad"]) && isset($_POST["tarifa"])){				
				$nickUsuario=Sistema::app()->Acceso()->getNick(); 
				$usuario=new Usuarios();                
                $usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
                
				//Buscar tarifa
				$tarifa=new Tarifas();
                $datosTarifa=$tarifa->buscarTodos(array("select" =>" t.*, tp.*",
                                            "from"=>" join tipos_cuotas tp using(cod_tipo_cuota)",
                                            "where"=>" t.cod_tarifa=".intval($_POST["tarifa"]["cod_tarifa"])));
                                            
				$respuesta=array("result"=>"success");
                
				foreach ($_POST["reservas"] as $inforReserva) { //Recorre el array con las reservas y las va guardando
				    if($_POST["actividad"]["seleccionable_horas"]){ //Si es seleccionable es para una fecha en concreto
				        $reserva=new Reservas();
                        $reserva->setValores(array("cod_actividad"=>$_POST["actividad"]["cod_actividad"],
                                                    "cod_usuario"=>$usuario->cod_usuario,
                                                    "cod_tarifa"=>$_POST["tarifa"]["cod_tarifa"],
                                                    "fecha_inicio"=>$inforReserva["fecha_inicio"],
                                                    "fecha_fin"=>$inforReserva["fecha_fin"],
                                                    "tarifa"=>$datosTarifa[0]["precio"]));
                        if($reserva->validar()){
                            if(!$reserva->guardar()){
                                $respuesta["result"]="error";
                            }   
                            else{ // inserta en caledarios-reservas
                                $calendarioReserva=new CalendariosReservas();
                                $calendarioReserva->setValores(array("cod_calendario"=>$inforReserva["cod_calendario"],
                                                                    "cod_reserva"=>$reserva->cod_reserva));
                                if($calendarioReserva->validar()){
                                    if(!$calendarioReserva->guardar()){
                                        $respuesta["result"]="error";   
                                    }                                                                       
                                }
                                else{
                                    $respuesta["result"]="error";   
                                }                                  
                            }
                        }    
				    }
                    else{ //Si no es seleccionable inserta tantas reservas a esa actividad como tramo de tarifa                                                                    
                        //Calcular el numero de dias a sumar, duracion reserva
                        $diaFechaFin;
                        if($datosTarifa[0]["semanal"]) $diaFechaFin=7;
                        else if($datosTarifa[0]["quincenal"]) $diaFechaFin=15;
                        else if($datosTarifa[0]["mensual"]) $diaFechaFin=30;
                        else if($datosTarifa[0]["diario"]) $diaFechaFin=1;
                        
                        //Se van añadiendo los dias correspondientes y realizando reservas mientras que la fecha fin sea menos o igual a la fecha
                        // fin de la reserva, en cada reserva la fecha de inicio sera la fecha de fin de la anterior reserva
                        $fecha_inicio=$inforReserva["fecha_inicio"];
                        $fecha_fin=$inforReserva["fecha_inicio"]+$diasFechaFin;
                        while ($fecha_fin<=$inforReserva["fecha_fin"]) {
                            $reserva=new Reservas();
                            $reserva->setValores(array("cod_actividad"=>$_POST["actividad"]["cod_actividad"],
                                                    "cod_usuario"=>$usuario->cod_usuario,
                                                    "cod_tarifa"=>$_POST["tarifa"]["cod_tarifa"],
                                                    "fecha_inicio"=>$fecha_inicio,
                                                    "fecha_fin"=>$fecha_fin,
                                                    "tarifa"=>$datosTarifa[0]["precio"]));
                            if($reserva->validar()){
                                if(!$reserva->guardar()){
                                    $respuesta["result"]="error";
                                }                                
                            }
                            else $respuesta["result"]="error";
                            
                            $fecha_inicio=$fecha_fin;
                            $fecha_fin+=$diaFechaFin;                            
                        }  
                    }					
				}
				$obJSON=json_encode($respuesta);
				//$error=error_get_last();
				echo $obJSON;
			}
			else{
				$obJSON=json_encode(array("result"=>"error"));
			//	echo $obJSON;
			}		
		}

        /*public function accionFinalizarReserva(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "finalizarReserva"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("reservas"=>$_POST["reservas"], "actividad"=>$_POST["actividad"], "tarifa"=>$_POST["tarifa"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            }
            else if(isset($_POST["reservas"]) && isset($_POST["actividad"]) && isset($_POST["tarifa"])){              
                $nickUsuario=Sistema::app()->Acceso()->getNick(); 
                $usuario=new Usuarios();                
                $usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
                
                //Buscar tarifa
                $tarifa=new Tarifas();
                $tarifa->buscarPorId($_POST["tarifa"]["cod_tarifa"]);
                $respuesta=array("result"=>"success");
                foreach ($_POST["reservas"] as $inforReserva) { //Recorre el array con las reservas y las va guardando
                    $reserva=new Reservas();
                    $reserva->setValores(array("cod_actividad"=>$_POST["actividad"]["cod_actividad"],
                                                "cod_usuario"=>$usuario->cod_usuario,
                                                "cod_tarifa"=>$_POST["tarifa"]["cod_tarifa"],
                                                "fecha_inicio"=>$inforReserva["fecha_inicio"],
                                                "fecha_fin"=>$inforReserva["fecha_fin"],
                                                "tarifa"=>$tarifa->precio));
                    if($reserva->validar()){
                        if(!$reserva->guardar()){
                            $respuesta["result"]="error";
                        }   
                        else{
                            if(isset($inforReserva["cod_calendario"])){ //Si existe cod_calendario, significa que la actividad es seleccionable e inserta en caledarios-reservas
                                $calendarioReserva=new CalendariosReservas();
                                $calendarioReserva->setValores(array("cod_calendario"=>$inforReserva["cod_calendario"],
                                                                    "cod_reserva"=>$reserva->cod_reserva));
                                if($calendarioReserva->validar()){
                                    if(!$calendarioReserva->guardar()){
                                        $respuesta["result"]="error";   
                                    }                                                                       
                                }
                                else{
                                    $respuesta["result"]="error";   
                                }
                            }   
                        }
                    }
                    else{
                        $respuesta["result"]="error";
                    }                   
                }
                $obJSON=json_encode($respuesta);
                //$error=error_get_last();
                echo $obJSON;
            }
            else{
                $obJSON=json_encode(array("result"=>"error"));
            //  echo $obJSON;
            }
            
                
        }*/

        public function accionListaReservas(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "listaReservas"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array());
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            }  
            else {
                $reserva=new Reservas();
                $nickUsuario=Sistema::app()->Acceso()->getNick(); 
                $usuario=new Usuarios();                
                $usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
                
                $filas=$reserva->buscarTodos(array("select"=>" t.*, a.nombre ",
                                                    "from"=>" join actividades a using(cod_actividad) ",
                                                    "where"=>" cod_usuario=".$usuario->cod_usuario." and t.cod_reserva not in(select cod_reserva from compras)" 
                                                    )
                                                );
                
                $this->dibujaVista("listaReservas", array("filas"=>$filas), "Lista de Reservas ");
           }
        }


        public function accionAnularReserva(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "anularReserva"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("cod_reserva"=>$_GET["id_reserva"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else{
                if(isset($_GET["id"])){
                    $reserva=new Reservas();
                    $reserva->buscarPorId(intval($_GET["id"]));
                    $reserva->anulado=1;
                    $reserva->fecha_anulacion=date("d/m/Y");
                    if($reserva->validar()){
                        if(!$reserva->guardar()){
                            Sistema::app()->paginaError(400, "Error al anular la reserva");    
                        }
                        else{
                            Sistema::app()->irAPagina(array("reservas", "listaReservas"));
                            exit; 
                        }    
                    }    
                    else{
                        Sistema::app()->paginaError(400, "Error al anular la reserva");  
                        exit;    
                    }
                }
                Sistema::app()->paginaError(400, "Error al anular la reserva");  
                exit;    
            }                           
        }
        
            
    }
        
