<?php
// OBTENER ERRORES
$errores=$modelo->getErrores();
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modifica tarifa", true);                
                echo CHTML::dibujaEtiquetaCierre("div");
				//CONTENEDOR ERRORES
				echo CHTML::dibujaEtiqueta("div");
					foreach ($errores as $error) {
						echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
					}
				echo CHTML::dibujaEtiquetaCierre("div");
				// FORMULARIO DE NUEVA TARIFA
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                              
                        //Campo actividad          
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cod_actividad");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_actividad", Actividades::listaActividades(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");                  
                        
                        // Campo tipo_cuota
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
							echo CHTML::modeloLabel($modelo, "cod_tipo_cuota");
							echo CHTML::modeloListaDropDown($modelo, "cod_tipo_cuota", TiposCuota::listaTiposCuota(),array("class"=>"form-control"));
					    echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo precio
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        	echo CHTML::modeloLabel($modelo, "precio");
                            echo CHTML::modeloText($modelo, "precio", array("class"=>"form-control", "id"=>"precio", "maxlength"=>5, "size"=>5));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
                        //Campo ocupacion
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                       		echo CHTML::modeloLabel($modelo, "ocupacion");
                            echo CHTML::modeloText($modelo, "ocupacion", array("class"=>"form-control", "id"=>"ocupacion", "maxlength"=>3, "size"=>3));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
						//Campo disponible
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "disponible");
                            echo CHTML::modeloCheckBox($modelo, "disponible");
                        echo CHTML::dibujaEtiquetaCierre("div");
						
						echo CHTML::dibujaEtiquetaCierre("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Modifica Tarifa", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
					
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
