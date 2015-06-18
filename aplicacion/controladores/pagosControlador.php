<?php


    class pagosControlador extends CControlador {
        
        public function accionIndex(){
            
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                  Sistema::app() -> sesion() -> set("pagPrevia", array("pagos"));
                  Sistema::app() -> sesion() -> set("parametrosAnt", array());
                  Sistema::app() -> irAPagina(array("inicial", "login"));
                  exit ;
            } 
            else if (!Sistema::app() -> acceso() -> puedeConfigurar()) {
                  Sistema::app() -> paginaError(400, "No tiene permiso para acceder");
                  exit ;
            } 
            else {
                
                $pago = new Pagos();
                $usuario = new Usuarios();
                $compra = new Compras();
                $reserva = new Reservas();
                $compra->buscarPorId($_GET["cod_compra"]);
                $pago->importe_pagado=$compra->importe;
                                
                $reserva->buscarPorId($compra -> cod_reserva);
                $usuario->buscarPorId($reserva -> cod_usuario);
                
                $nombre = $pago->getNombre();
                
            if (isset($_POST[$nombre])){                
                $pago->setValores($_POST[$nombre]);
                $pago ->cod_usuario = $usuario -> cod_usuario;
                $pago->cod_medio_pago = intval($_POST["medioPagos"]);
                
                if ($pago->validar()){                    
                    if (!$pago->guardar()){
                        Sistema::app()->paginaError(404,"Se ha producido un error al guardar el pago");
                        exit;
                    }
                    
                    $compra -> importe_pagado = $pago -> importe_pagado;
                    $compra -> pendiente = 0;
                    
                    if($compra->validar()){
                        $compra->guardar();
                    }                    
                    Sistema::app()->irAPagina(array("compras", "listaCompras"), array("cod_usuario"=>$usuario->cod_usuario));
                    exit;
                }
                                
                else {
                    $this->dibujaVista("nuevoPago", array("modelo"=>$pago, "usuario"=>$usuario, "compra"=>$compra), "Pagar");
                }
                
            }
                
                $this->dibujaVista("nuevoPago",array("modelo"=>$pago, "usuario"=>$usuario, "compra"=>$compra), "Pagar");
            }
            
        }
        
    }
