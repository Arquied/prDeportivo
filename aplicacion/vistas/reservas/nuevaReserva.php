<?php

    //OBTENER ERRORES
    //$errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("../../../estilos/estiloFormularios.css");
	echo CHTML::cssFichero("../../../estilos/estiloReservas.css");
    echo CHTML::scriptFichero("../../../script/scriptReserva.js");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
            echo CHTML::dibujaEtiqueta("h2", array(), "Reservar", true);                
        echo CHTML::dibujaEtiquetaCierre("div");
		
		echo CHTML::dibujaEtiqueta("div");
			echo CHTML::dibujaEtiqueta("h3", array("id"=>"tituloPaso"), "<em>Paso 1 - Seleccionar actividad</em>", true);
		echo CHTML::dibujaEtiquetaCierre("div");

        //FORMULARIO DE NUEVA RESERVA
        echo CHTML::dibujaEtiqueta("div", array("id"=>"contNuevaReserva"));
	       	echo CHTML::dibujaEtiqueta("div", array("id"=>"camposForm"));
		            echo CHTML::dibujaEtiqueta("div");
		                //Campo actividades                 
		                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
		                    if(isset($errores["cod_actividad"])){
		                        echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_actividad"], true);
		                    }
		                    echo CHTML::modeloLabel($modelo, "cod_actividad");
		                    echo CHTML::modeloListaDropDown($modelo, "cod_actividad", Actividades::listaActividades(), array("class"=>"form-control"));
		                echo CHTML::dibujaEtiquetaCierre("div");	
					echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiqueta("div");
						//Tipo de reserva: si es para un periodo o solo una fecha en concreto
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							echo CHTML::campoLabel("Reservar para: ", "tipo_reserva");
							echo CHTML::campoListaRadioButton("tipo_reserva", "periodo", array("periodo"=>"Período", "dia"=>"Fecha concreta"), "");
						echo CHTML::dibujaEtiquetaCierre("div");
					echo CHTML::dibujaEtiquetaCierre("div");
				echo CHTML::dibujaEtiquetaCierre("div");	            	
	           
				//Informacion de la actividad
				$actividad=new Actividades();
				if($actividad->buscarPorId(intval($modelo->cod_actividad))){
					echo CHTML::dibujaEtiqueta("div", array("id"=>"contInformacionAct"));
						echo CHTML::dibujaEtiqueta("div", array("class"=>"row featurette"));
							//Informacion			        
					        echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-7 col-md-push-5")); 
								echo CHTML::dibujaEtiqueta("h1", array("id"=>"nombreActividad"), $actividad->nombre, true);			            
					            echo CHTML::dibujaEtiqueta("div", array("class"=>"lead", "id"=>"descripcion"), $actividad->descripcion, true);
					        echo CHTML::dibujaEtiquetaCierre("div");
					        
					        //Imagen actividad			        
					        echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-5 col-md-pull-7 imagen")); 		        
								//si existe imagen si no se inserta una por defecto
					    		if($actividad->imagen!=""){
					    			echo CHTML::imagen("../../imagenes/actividades/".$actividad->imagen, "500x500", array("class"=>"featurette-image img-responsive center-block"));	
					    		}    
								else{
									echo CHTML::imagen("../../imagenes/Imagen_no_disponible.svg.png", "500x500", array("class"=>"featurette-image img-responsive center-block"));
								}
					            
					        echo CHTML::dibujaEtiquetaCierre("div");
					  	echo CHTML::dibujaEtiquetaCierre("div");			
					echo CHTML::dibujaEtiquetaCierre("div");
					}
			
		                //Boton insertar
		           	echo CHTML::dibujaEtiqueta("div");
		                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group pull-right"));
		                	if($modelo->cod_actividad==0){
		                		echo CHTML::boton("Siguiente", array("class"=>"btn btn-default", "id"=>"reserva2paso", "disabled"=>"disabled"));	
		                	}
							else{
								echo CHTML::boton("Siguiente", array("class"=>"btn btn-default", "id"=>"reserva2paso"));	
							}
		                                    
		                echo CHTML::dibujaEtiquetaCierre("div");
	            	echo CHTML::dibujaEtiquetaCierre("div");
            	echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
