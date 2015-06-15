<?php
    echo CHTML::scriptFichero("../../script/jquery.dynatable.js");
	echo CHTML::scriptFichero("../../script/scriptCrudUsuarios.js");
    echo CHTML::cssFichero("../../estilos/jquery.dynatable.css");
    echo CHTML::cssFichero("../../estilos/estiloUsuarios.css");
	
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container"), "", false);
        //Titulo
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
        	echo CHTML::dibujaEtiqueta("H1", array("class"=>"text-center"), "ADMINISTRACIÓN DE USUARIOS", TRUE);
        echo CHTML::dibujaEtiquetaCierre("div");
    	
		echo CHTML::dibujaEtiqueta("div");
		echo CHTML::dibujaEtiqueta("a",array("href"=>Sistema::app()->generaURL(array("usuarios", "registrarUsuario")), "class" => "btn btn-default"),"Registrar Usuario");
		echo CHTML::dibujaEtiquetaCierre("div");
		
        echo CHTML::dibujaEtiqueta("div", array("id"=>"contUsuarios"));
            echo CHTML::dibujaEtiqueta("table", array("class"=>"table table-striped", "id"=>"tUsuarios"));
                //DIBUJAR CABECERA DE LA TABLA
                echo CHTML::dibujaEtiqueta("thead");
                    echo CHTML::dibujaEtiqueta("tr");
                        echo CHTML::dibujaEtiqueta("th", array(), "CÓDIGO", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "NOMBRE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "DNI", TRUE);
    					echo CHTML::dibujaEtiqueta("th", array(), "ROLE", TRUE);
    					echo CHTML::dibujaEtiqueta("th", array(), "SALDO", TRUE);
    					echo CHTML::dibujaEtiqueta("th", array(), "DISPONIBLE", TRUE);
                        echo CHTML::dibujaEtiqueta("th", array(), "OPCIONES", TRUE);
                    echo CHTML::dibujaEtiquetaCierre("tr");
                echo CHTML::dibujaEtiquetaCierre("thead");
                
                //DIBUJAR CUERPO DE LA TABLA
                echo CHTML::dibujaEtiqueta("tbody");
                    foreach ($filas as $fila) {
                        echo CHTML::dibujaEtiqueta("tr");
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["cod_usuario"], true);
                            echo CHTML::dibujaEtiqueta("td", array(), $fila["nombre"], true);
    						echo CHTML::dibujaEtiqueta("td", array(), $fila["dni"], true);
    						echo CHTML::dibujaEtiqueta("td", array(), $fila["role"], true);
    						echo CHTML::dibujaEtiqueta("td", array(), $fila["saldo"], true);
    						if($fila["disponible"]){
    							echo CHTML::dibujaEtiqueta("td", array(), "Disponible", true);
    						}
    						else{
    							echo CHTML::dibujaEtiqueta("td", array(), "No disponible", true);
    						}						
                            echo CHTML::dibujaEtiqueta("td");
                                echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"cambiarAdministrador", "title"=>"Cambiar rol"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_rol.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");
    							echo CHTML::dibujaEtiqueta("a", array("href"=>"#", "class"=>"btnBorrar", "title"=>"Borrar usuario"));
                                    echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_borrar.png"));
                                echo CHTML::dibujaEtiquetaCierre("a");    							
								echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("usuarios","modificarUsuario"), array("cod_usuario"=>$fila["cod_usuario"])), "title"=>"Modificar Usuario"));
									echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_edit.png"));
								echo CHTML::dibujaEtiquetaCierre("a");
								echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("compras","listaCompras"), array("cod_usuario"=>$fila["cod_usuario"])), "title"=>"Ver Compras"));
    								echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_verCompras.png"));
    							echo CHTML::dibujaEtiquetaCierre("a");
								echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("reservas","nuevaReserva"), array("cod_usuario"=>$fila["cod_usuario"])), "title"=>"Nueva Reserva"));
    								echo CHTML::dibujaEtiqueta("img", array("src"=>"../../../imagenes/ico_anadirReserva.png"));
    							echo CHTML::dibujaEtiquetaCierre("a");
                            echo CHTML::dibujaEtiquetaCierre("td");
                        echo CHTML::dibujaEtiquetaCierre("tr");
                    }            
                echo CHTML::dibujaEtiquetaCierre("tbody");
            echo CHTML::dibujaEtiquetaCierre("table");
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::script("$('#tUsuarios').dynatable();");
        
    	
    	//VENTANA MODAL CAMBIAR ROLE
    	echo CHTML::dibujaEtiqueta("div", array("id"=>"modalRole", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
    		echo CHTML::iniciarForm("index.php?co=usuarios&ac=cambiarRole", "POST", array("id"=>"formCambiarRole"));
    			echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
    				echo CHTML::dibujaEtiqueta("h2", array(), "Cambiar role", true);
    			echo CHTML::dibujaEtiquetaCierre("div");
    			echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));				
    					echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));			
    						echo CHTML::campoHidden("id_usuario");
    						echo CHTML::campoLabel("Seleccione role", "role");
    						echo CHTML::campoListaDropDown("role", "", Usuarios::listaRoles(), array("class"=>"form-control", "linea"=>false));	
    					echo CHTML::dibujaEtiquetaCierre("div");		
    			echo CHTML::dibujaEtiquetaCierre("div");
    			echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
    				echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));				
    				echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
    			echo CHTML::dibujaEtiquetaCierre("div");
    		echo CHTML::finalizarForm();
    	echo CHTML::dibujaEtiquetaCierre("div");
    	
    	//VENTANA MODAL MENSAJE BORRADO
    	echo CHTML::dibujaEtiqueta("div", array("id"=>"modalBorrado", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
    			echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
    			echo CHTML::dibujaEtiqueta("h2", array(), "Confirmar borrado", true);
    		echo CHTML::dibujaEtiquetaCierre("div");
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
    			echo CHTML::dibujaEtiqueta("p", array(), "¿Desea borrar usuario?", true);
    		echo CHTML::dibujaEtiquetaCierre("div");
    		echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
    			echo CHTML::boton("Borrar", array("id"=>"seguroBorrar", "class"=>"btn"));
    			echo CHTML::boton("Cancelar", array("class"=>"btn", "data-dismiss"=>"modal"));
    		echo CHTML::dibujaEtiquetaCierre("div");
    	echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
