<?php

    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
    echo CHTML::scriptFichero("../../script/scriptAnulacionReservas.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloReservas.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
        //Titulo
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
            echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "RESERVAS", TRUE);
        echo CHTML::dibujaEtiquetaCierre("div");
    
		if(Sistema::app() -> acceso() -> puedeConfigurar()){
	    	//FILTRADO
		    echo CHTML::dibujaEtiqueta("div", array("class"=>"contFiltrado"));
		                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
		                    echo CHTML::dibujaEtiqueta("h4", array(), "Campos de filtrado", true);                
		                echo CHTML::dibujaEtiquetaCierre("div");
		
		                //FORMULARIO DE FILTRADO
		                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
		                    //Campo usuario           
		                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
		                        echo CHTML::campoLabel("Usuarios", "usuario");                            
		                        echo CHTML::campoListaDropDown("usuario", $usuario, Usuarios::listaUsuarios(), array("class"=>"form-control"));
		                    echo CHTML::dibujaEtiquetaCierre("div");
		                    	                    
		                    //Boton submit
		                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
		                        echo CHTML::campoBotonSubmit("Filtrar", array("class"=>"btn btn-default"));                 
		                    echo CHTML::dibujaEtiquetaCierre("div");
		                
		                echo CHTML::finalizarForm();
		    echo CHTML::dibujaEtiquetaCierre("div");
	    }
        echo CHTML::dibujaEtiqueta("div", array("id"=>"contListaReservas"));
            echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tReservas"));
                //DIBUJAR CABECERA DE LA TABLA
                echo CHTML::dibujaEtiqueta("thead");
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("th", array(), "ACTIVIDAD", TRUE);
						echo CHTML::dibujaEtiqueta("th", array(), "USUARIO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA DE RESERVA", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA INICIO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA FIN", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "TARIFA", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "ANULACIÓN", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "FECHA DE ANULACIÓN", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                    echo CHTML::dibujaEtiquetaCierre("tr");
                echo CHTML::dibujaEtiquetaCierre("thead");
                
                //DIBUJAR CUERPO DE LA TABLA
                echo CHTML::dibujaEtiqueta("tbody");
                    foreach ($filas as $fila) {
                        echo CHTML::dibujaEtiqueta("tr");
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["nombre"], true);
							echo CHTML::dibujaEtiqueta("td", array(), $fila["usuario"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_reserva"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_inicio"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_fin"]), true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["tarifa"], true);
                            if($fila["anulado"]){
                                echo CHTML::dibujaEtiqueta("td", array(), "Anulado", true);
                                echo CHTML::dibujaEtiqueta("td", array(), CGeneral::fechaMysqlANormal($fila["fecha_anulacion"]), true);
                            }
                            else{
                                echo CHTML::dibujaEtiqueta("td", array(), "Activo", true);
                                echo CHTML::dibujaEtiqueta("td", array(), "", true);
                            }
                            echo CHTML::dibujaEtiqueta("td");
								if(!$fila["anulado"]){
									//Si es administrador puede anular siempre fecha_actual<=fecha_inicio
									if(Sistema::app() -> acceso() -> puedeConfigurar()){
										if(date("Y-m-d")<=$fila["fecha_inicio"]){
											echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnAnular", "title"=>"Anular reserva", "id"=>$fila["cod_reserva"]));
	                                        	echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
	                                    	echo CHTML::dibujaEtiquetaCierre("a");	
										}
										else{
											echo "Anulación no permitida";
										}	
									}
									//Si no es administrador puede anular siempre que la fecha_actual<= fecha_inicio-periodo_anulacion
									else{
										$fecha=new DateTime("now");
									    $fecha_inicio=new DateTime($fila["fecha_inicio"]);
									    $intervalo=new DateInterval("PT".abs(intval($fila["periodo_anulacion"]))."H");
									    $intervalo->invert=1;
										$fecha_inicio->add($intervalo);							
										if($fecha<=$fecha_inicio){
											echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnAnular", "title"=>"Anular reserva"));
	                                        	echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
	                                    	echo CHTML::dibujaEtiquetaCierre("a");	
										}
										else{
											echo "Anulación no permitida";	
										}	
									} 
								}
                            echo CHTML::dibujaEtiquetaCierre("td");
                        echo CHTML::dibujaEtiquetaCierre("tr");
                    }            
                echo CHTML::dibujaEtiquetaCierre("tbody");
            echo CHTML::dibujaEtiquetaCierre("table");
        echo CHTML::dibujaEtiquetaCierre("div");
    
        echo CHTML::script("$('#tReservas').dynatable();");
   
        //VENTANA MODAL MENSAJE ANULADO
        echo CHTML::dibujaEtiqueta("div", array("id"=>"modalAnulado", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
                echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
                echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar anulación", true);
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
                echo CHTML::dibujaEtiqueta("p", array(), "¿Desea anular reserva?", true);
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
                echo CHTML::boton("Anular", array("id"=>"seguroAnular", "class"=>"btn"));
                echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
            echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");    
  
    echo CHTML::dibujaEtiquetaCierre("div");  

