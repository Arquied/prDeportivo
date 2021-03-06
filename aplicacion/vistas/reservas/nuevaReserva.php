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
            echo CHTML::dibujaEtiquetaCierre("div");
        
			//Informacion de la actividad				
			echo CHTML::dibujaEtiqueta("div", array("id"=>"contInformacionAct"));
				echo CHTML::dibujaEtiqueta("div", array("class"=>"row featurette"));
					//Contenedor futura Informacion			        
			        echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-7 col-md-push-5")); 
						echo CHTML::dibujaEtiqueta("h1", array("id"=>"nombreActividad"), "", true);			            
			            echo CHTML::dibujaEtiqueta("div", array("class"=>"lead", "id"=>"descripcion"), "", true);
			        echo CHTML::dibujaEtiquetaCierre("div");
			        
			        //Contenedor futura Imagen actividad			        
			        echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-5 col-md-pull-7 imagen"));		       					
						echo CHTML::imagen("", "", array("class"=>"featurette-image img-responsive center-block"));
					echo CHTML::dibujaEtiquetaCierre("div");
			  	echo CHTML::dibujaEtiquetaCierre("div");
			
			  	
				//Horario semanal
				echo CHTML::dibujaEtiqueta("div", array("id"=>"contHorario"), "", true);			
			echo CHTML::dibujaEtiquetaCierre("div");   
        echo CHTML::dibujaEtiquetaCierre("div");
        
		//Boton insertar
           	echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group pull-right", "id"=>"contBtn"));
                	if($modelo->cod_actividad==0){
                		echo CHTML::boton("Siguiente", array("class"=>"btn btn-default", "id"=>"reserva2paso", "disabled"=>"disabled"));	
                	}
					else{
						echo CHTML::boton("Siguiente", array("class"=>"btn btn-default", "id"=>"reserva2paso"));	
					}                                    
                echo CHTML::dibujaEtiquetaCierre("div");
        	echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    
    
    
    //VENTANA MODAL MENSAJE ERROR
    echo CHTML::dibujaEtiqueta("div", array("id"=>"modalError", "class"=>"modal fade", "tabindex"=>"-1", "role"=>"dialog"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-header"));
            echo CHTML::boton("x", array("class"=>"close btn", "data-dismiss"=>"modal"));
            echo CHTML::dibujaEtiqueta("h2", array(), "Error en el proceso de reserva", true);
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-body"));
            echo CHTML::dibujaEtiqueta("p", array(), "Ocurrió un error en el proceso de reserva, recargue la pagina", true);
        echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiqueta("div", array("class"=>"modal-footer"));
            echo CHTML::boton("Ok", array("class"=>"btn", "data-dismiss"=>"modal"));
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
