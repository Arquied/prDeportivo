<?php
   
   	echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudActividades.js");
    echo CHTML::scriptFichero("../../script/scriptPerfil.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloPerfil.css");
    
   
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container-fluid"));    
        
        echo CHTML::dibujaEtiqueta("div", array("class"=>"row"));
            //Perfil
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-3 sidebar"));
                echo CHTML::dibujaEtiqueta("div", array("id"=>"contPerfil"));

                    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
                        echo CHTML::dibujaEtiqueta("h3", array(), "PERFIL", true);    
                    echo CHTML::dibujaEtiquetaCierre("div");    
                
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"contInfoPerfil"));      
                        
                    echo CHTML::dibujaEtiqueta("h4", array("class"=>"text-center"), $modelo->nombre, true);            
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center")); 
                        echo CHTML::dibujaEtiqueta("span", array(), "DNI: ".$modelo->dni, true);
                        echo CHTML::dibujaEtiqueta("span", array(), " F. nacimiento: ".CGeneral::fechaMysqlANormal($modelo->fecha_nac), true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Email: ".$modelo->correo, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Teléfono: ".$modelo->telefono, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Nick: ".$modelo->nick, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("usuarios", "modificar"), array("cod_usuario"=>$modelo->cod_usuario)), "class"=>"btn btn-default btn-block"), "Modificar mi perfil", true);
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("usuarios", "cambiarContrasena"), array("cod_usuario"=>$modelo->cod_usuario)), "class"=>"btn btn-default btn-block"), "Cambiar contraseña", true);
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("reservas", "listaReservas"), array("usuario"=>"usu")), "class"=>"btn btn-default btn-block"), "Reservas realizadas", true);
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("inicial", "cerrarSesion")), "class"=>"btn btn-default btn-block"), "Cerrar sesión", true);
                    echo CHTML::dibujaEtiquetaCierre("div");
            
                    echo CHTML::dibujaEtiquetaCierre("div");
                echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiquetaCierre("div");
            
            //Compras          
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-9 col-md-offset-3 main")); 			              
				//Titulo
			    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
			        echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "COMPRAS REALIZADAS", TRUE);
			    echo CHTML::dibujaEtiquetaCierre("div");
			
				//SI NO EXISTEN COMPRAS 
               	if(count($comprasRealizadas)==0){
			    	echo CHTML::dibujaEtiqueta("div", array("id"=>"sinCompras"), "No se ha realizado compras"); 
			    }
				//SI EXISTEN
				else{	
					echo CHTML::dibujaEtiqueta("div", array("id"=>"contListaCompras"));
                        echo CHTML::iniciarForm("#", "POST", array("role"=>"form"));                        
                            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group")); 
                                echo CHTML::campoCheckBox("temporada_actual", $tem);                          
                                echo CHTML::campoLabel("Temporada Actual", "temporada_actual");
                            echo CHTML::dibujaEtiquetaCierre("div");
                        echo CHTML::finalizarForm();
						
                        //Tabla compras
				        echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tCompras"));
				            //DIBUJAR CABECERA DE LA TABLA
				            echo CHTML::dibujaEtiqueta("thead");
				                echo CHTML::dibujaEtiqueta("tr");
				                    echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
				                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA COMPRA", TRUE);
				                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);				                   
				                    echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
				                    echo CHTML::dibujaEtiqueta("th", array(), "IMPORTE", TRUE);
				                    echo CHTML::dibujaEtiqueta("th", array(), "PAGADO/PENDIENTE", TRUE);
									echo CHTML::dibujaEtiqueta("th", array(), "IMPORTE PAGADO", TRUE);
									echo CHTML::dibujaEtiqueta("th", array(), "FACTURA", TRUE);
				                echo CHTML::dibujaEtiquetaCierre("tr");
				            echo CHTML::dibujaEtiquetaCierre("thead");
				            
				            //DIBUJAR CUERPO DE LA TABLA
				            echo CHTML::dibujaEtiqueta("tbody");
				                foreach ($comprasRealizadas as $compra) {
				                    echo CHTML::dibujaEtiqueta("tr");
				                        echo CHTML::dibujaEtiqueta("td", array(), $compra["actividad"], true);
										echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($compra["fecha_compra"]), true);
				                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($compra["fecha_inicio"]), true);
				                        echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($compra["fecha_fin"]), true);
										echo CHTML::dibujaEtiqueta("td", array(), $compra["importe"], true);
										if($compra["pendiente"]){
											echo CHTML::dibujaEtiqueta("td", array(), "Pendiente", true);
										}
										else{
											echo CHTML::dibujaEtiqueta("td", array(), "Pagado", true);
										}
										echo CHTML::dibujaEtiqueta("td", array(), $compra["importe_pagado"], true);
				                        echo CHTML::dibujaEtiqueta("td");
				                            echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("compras", "facturaPDF"), array("cod_compra"=>$compra["cod_compra"])), "title"=>"Imprimir factura"));
				                                echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_pdf.png"));
				                            echo CHTML::dibujaEtiquetaCierre("a");				                            
				                        echo CHTML::dibujaEtiquetaCierre("td");
				                    echo CHTML::dibujaEtiquetaCierre("tr");
				                }            
				            echo CHTML::dibujaEtiquetaCierre("tbody");
				        echo CHTML::dibujaEtiquetaCierre("table");
				    echo CHTML::dibujaEtiquetaCierre("div");
				
				    echo CHTML::script("$('#tCompras').dynatable();");
				}
		
            echo CHTML::dibujaEtiquetaCierre("div");
                        
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");

    
 ?>   
    
    
    
