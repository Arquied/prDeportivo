<?php
	 
	class comprasControlador extends CControlador{
		
		public function accionFacturaPDF(){
			//Comprobar si se ha iniciado sesion y si el usuario tiene permiso de modificar
            if (!Sistema::app() -> acceso() -> hayUsuario()) {
                Sistema::app() -> sesion() -> set("pagPrevia", array("compras", "facturaPDF"));
                Sistema::app() -> sesion() -> set("parametrosAnt", array($_REQUEST["cod_compra"]));
                Sistema::app() -> irAPagina(array("inicial", "login"));
                exit ;
            } 
			else if(isset($_REQUEST["cod_compra"])){
				$compra=new Compras();
				$sentSelect=" t.*, a.nombre as actividad, u.nombre as nombreUsuario, u.dni, u.telefono ";
				$sentFrom=" join reservas r using(cod_reserva) ".
							" join actividades a using(cod_actividad) ".
							" join usuarios u using(cod_usuario) ";
				$sentWhere=" cod_compra=".intval($_REQUEST["cod_compra"]);
				
				$factura=$compra->buscarTodos(array("select"=>$sentSelect, "from"=>$sentFrom, "where"=>$sentWhere));
				
				if($factura){
					//var_dump($factura[0]['nombreUsuario']);
					$configuracion=new Configuracion();
					$configuracion->buscarPorId(1);
					
					$contenido=
						"<style>
							*{
								margin: 0;
								padding: 0;
								font-family: Arial;
							}
							.datosFactura{
								width: 50%;
							}
							table{
								width: 100%;
                                margin: 20px 0;
							}							
                            .tFactura td{
                               text-align:center; 
                               font-size: 14pt;
                            }
							.tFactura th{
								padding: 10px 20px;
								border-bottom: 1px solid white;
								background:  rgb(140, 3, 21);
								color: white;
                                text-align:center;
							}                           
                            .tFactura tbody td{
                                padding: 10px 0;
                                font-size: 14pt;
                                border-bottom: 1px solid rgb(140, 3, 21);
                            }
                            .tFactura tfoot td{
                                text-align: right;
                            }
							.datosFactura h3{
								color: rgb(140,3,21);
								font-size: 15pt;
							}												
						</style>".
						
						"<page>".							
							"<div>".
								"<h2>Factura compra</h2>".
							"</div>".
							"<table>".
							     "<tr>".
    								"<td class='datosFactura'>".
    									"<h3>$configuracion->nombre_empresa</h3>".
    									"<p>".
    										"<p>CIF: $configuracion->cif</p>".
    										"<p>Dirección: C/ El Euro 23</p>".
    										"<p>Localidad: Antequera</p>".
    										"<p>Provincia: Málaga</p>".				
    									"</p>".
    								"</td>".
    								"<td class='datosFactura'>".
    									"<h3>{$factura[0]['nombreUsuario']}</h3>".
    									"<p>".
    										"<p>NIF: {$factura[0]['dni']}</p>".				
    										"<p>Dirección: C/ El Euro 23</p>".
    										"<p>Localidad: Antequera</p>".
    										"<p>Provincia: Málaga</p>".				
    									"</p>".
    								"</td>".
    						      "</tr>".
							"</table>".
							"<div>".
								"Fecha compra: {$factura[0]['fecha_compra']}".
							"</div>".
							"<table class='tfactura'>".
								"<thead>".
									"<tr>".
										"<th style='width:33%'>ACTIVIDAD</th>".
										"<th style='width:33%'>FECHA DE INICIO</th>".
										"<th style='width:33%'>FECHA DE FIN</th>".
									"</tr>".
								"</thead>".
								"<tbody>".
									"<tr class='datos'>".
										"<td style='width:33%'>{$factura[0]['actividad']}</td>".
										"<td style='width:33%'>".CGeneral::fechaMysqlANormal($factura[0]['fecha_inicio'])."</td>".
										"<td style='width:33%'>".CGeneral::fechaMysqlANormal($factura[0]['fecha_fin'])."</td>".
									"</tr>".
								"</tbody>".
								"<tfoot>".
									"<tr>".
										"<td colspan=2>Importe Total</td>".
										"<td>{$factura[0]['importe']}</td>".					
									"</tr>".
									"<tr>".
										"<td colspan=2>Pagado</td>".
										"<td>{$factura[0]['importe_pagado']}</td>".
									"</tr>".										
								"</tfoot>".
							"</table>".								
						"</page>";
						
						// convert to PDF
					    try
					    {
					        $html2pdf = new HTML2PDF('P', 'A4', 'es');
					        $html2pdf->pdf->SetDisplayMode('fullpage');
					        $html2pdf->writeHTML($contenido);
					        $html2pdf->Output('f.pdf');
					    }
					    catch(HTML2PDF_exception $e) {
					        echo $e;
					        exit;
					    }	
				}
				else{
					Sistema::app()->paginaError(400, "La factura no se encuentra");
				}
			}
		}
		
	}
			
