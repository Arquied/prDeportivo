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
            	if(isset($_GET["cod_usuario"])){
            		Sistema::app()-> Sesion() ->set("usuarioReserva", $_GET["cod_usuario"]);
            	}
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
            	$usuario=new Usuarios();
            	if(Sistema::app()->Sesion()->get("usuarioReserva")!==0){
            		$usuario->buscarPorId(intval(Sistema::app()->Sesion()->get("usuarioReserva")));	
            	}              
				else{					
					$nickUsuario=Sistema::app()->Acceso()->getNick(); 	
					$usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
					Sistema::app()->Sesion()->set("usuarioReserva", $usuario->cod_usuario);
				}              
                               
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
						//Comprueba la tarifa y la fecha de inicio por si se debe añadir la compra correspondiente
						$tipoCuota=new TiposCuota();
						$tipoCuota->buscarPorId($tarifa->cod_tipo_cuota);
						$fechaInicio=new DateTime(CGeneral::fechaNormalAMysql($inforReserva["fecha_inicio"]));
						
							//Si tipo cuota es mensual y la fecha de inicio no es 1
						if($tipoCuota->mensual && $fechaInicio->format("d")!=1){
							$compra=new Compras();
							$fecha_fin=new DateTime();
							$fecha_fin->modify('last day of this month');
							$compra->setValores(array("cod_reserva"=>$reserva->cod_reserva,
														"fecha_inicio"=>$reserva->fecha_inicio,
														"fecha_fin"=>$fecha_fin->format("d/m/Y"),
														"importe"=>$reserva->tarifa));
							if($compra->validar()){
								$compra->guardar();
							}
							else{
								$respuesta["result"]="error";	
							}
						}
						// Si el tipo de cuota es quincenal y la fecha de inicio no es ni 1 o 16
						if($tipoCuota->quincenal){
							if($fechaInicio->format("d")>1 && $fechaInicio->format("d")<16){ //Si la fecha esta entre 2 y 15
								$compra=new Compras();
								$fecha_fin=new DateTime($fechaInicio->format("Y")."-".$fechaInicio->format("m")."-30");
								$compra->setValores(array("cod_reserva"=>$reserva->cod_reserva,
														"fecha_inicio"=>$reserva->fecha_inicio,
														"fecha_fin"=>$fecha_fin->format("d/m/Y"),
														"importe"=>$reserva->tarifa));
								if($compra->validar()){
									$compra->guardar();
								}
								else{
									$respuesta["result"]="error";	
								}	
							}	
							else if($fechaInicio->format("d")>16){ //Si la fecha esta entre 17>
								$compra=new Compras();
								$fecha_fin=new DateTime();
								$fecha_fin->modify('last day of this month');
								$compra->setValores(array("cod_reserva"=>$reserva->cod_reserva,
															"fecha_inicio"=>$reserva->fecha_inicio,
															"fecha_fin"=>$fecha_fin->format("d/m/Y"),
															"importe"=>$reserva->tarifa));
								if($compra->validar()){
									$compra->guardar();
								}
								else{
									$respuesta["result"]="error";	
								}	
							}							
						}
						// Si el tipo de cuota es semanal y la fecha de inicio no es lunes
						if($tipoCuota->semanal && date("N", strtotime(CGeneral::fechaNormalAMysql($inforReserva["fecha_inicio"])))!="1"){
							$compra=new Compras();
							$fecha_fin=new DateTime();
							$fecha_fin->modify('next sunday');
							$compra->setValores(array("cod_reserva"=>$reserva->cod_reserva,
													"fecha_inicio"=>$reserva->fecha_inicio,
													"fecha_fin"=>$fecha_fin->format("d/m/Y"),
													"importe"=>$reserva->tarifa));
							if($compra->validar()){
								$compra->guardar();
							}
							else{
								$respuesta["result"]="error";	
							}		
						}                        
                    }
                    else{
                        $respuesta["result"]="error";
                    }                   
                }
                $obJSON=json_encode($respuesta);
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
            	$reservas=new Reservas(); 
				
				//establezco las opciones de filtrado
	            $opciones=array();
	            $filtrado=array();
	            $opciones["select"]=" t.*, act.nombre, act.periodo_anulacion, usu.nombre as usuario "; 
	            $opciones["from"]=" join actividades act using(cod_actividad) ".
									" join usuarios usu using(cod_usuario) ";
	            //filtrado 
	            //si no existe filtrado se muestran todas las reservas	
	            //Si se ha pinchado desde el perfil del usuario, busca las reservas del usuario con sesion iniciada
	            if(isset($_GET["usuario"]) && $_GET["usuario"]=="usu"){
	            	$nickUsuario=Sistema::app()->Acceso()->getNick();
					$usuario=new Usuarios(); 	
					$usuario->buscarPor(array("where"=>"nick='".$nickUsuario."'"));
	            	$opciones["where"]=" t.cod_usuario=".intval($usuario->cod_usuario);
					$cod_usuario=$usuario->cod_usuario;
	            }			
				//Si se ha realizado una reserva
				if(Sistema::app()->Sesion()->get("usuarioReserva") && Sistema::app()->Sesion()->get("usuarioReserva")!==0){
					$opciones["where"]=" t.cod_usuario=".Sistema::app()->Sesion()->get("usuarioReserva");
					$cod_usuario=Sistema::app()->Sesion()->get("usuarioReserva");
				}
				//Filtro usuario
				if(isset($_POST["usuario"]) && $_POST["usuario"]!==""){
					$opciones["where"]=" t.cod_usuario=".intval($_POST["usuario"]);
					$cod_usuario=$_POST["usuario"];
				}				
	            
				
				      
                $filas=$reservas->buscarTodos($opciones);												
                
				//Borrar sesion usuarioReserva una vez comprobada
				Sistema::app()->Sesion()->set("usuarioReserva", 0);
				
                $this->dibujaVista("listaReservas", array("filas"=>$filas, "usuario"=>(isset($cod_usuario))? $cod_usuario: "" ), "Lista de Reservas ");
           }
        }


        public function accionAnularReserva(){
            //Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("reservas", "anularReserva"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array("id"=>$_GET["id"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
            else{
                if(isset($_GET["id"])){
                    $reserva=new Reservas();
                    $reserva->buscarPorId(intval($_GET["id"]));
					$reserva->setValores(array("anulado"=>1, "fecha_anulacion"=>date("d/m/Y")));
                    if($reserva->validar()){
                        if(!$reserva->guardar()){
                            Sistema::app()->paginaError(400, "Error al anular la reserva");    
                        }
                        else{
                        	$compra=new Compras();
							$listaCompras=$compra->buscarTodos(array("where"=>" cod_reserva=".intval($_GET["id"])));
							foreach ($listaCompras as $datosCompra) {
								$compra->buscarPorId($datosCompra["cod_compra"]);
								$compra->anulado=1;
								if($compra->validar()){
									$compra->guardar();
								}
							}
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
        
