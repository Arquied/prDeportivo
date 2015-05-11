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
        
        public function accionDevuelveTarifas(){
            if(isset($_POST["cod_actividad"])){
                $tarifa=new Tarifas();
                $listaTarifa=$tarifa->buscarTodos(array("select"=>" t.cod_tarifa, tc.tipo ", 
                                            "from"=>" join tipos_cuotas tc using(cod_tipo_cuota) ",
                                            "where"=>" t.cod_actividad=".intval($_POST["cod_actividad"])));
                if($listaTarifa){
                    $json=json_encode($listaTarifa);
                    echo $json;    
                }
                else{
                    echo json_encode(0);
                }
                
            }
        }     
    }
        
