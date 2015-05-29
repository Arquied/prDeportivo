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
            if(isset($_POST["reservas"]) && isset($_POST["actividad"]) && isset($_POST["tarifa"])){              
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
                $error=error_get_last();
                echo $obJSON;
            }
            else{                
                $obJSON=json_encode(array("result"=>"error"));
                echo $obJSON;
            }
            
                
        }

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
        
