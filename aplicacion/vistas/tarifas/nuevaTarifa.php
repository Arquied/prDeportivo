<?php

// OBTENER ERRORES
$errores=$modelo->getErrores();
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Nueva tarifa", true);                
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
						echo CHTML::dibujaEtiquetaCierre("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Añadir Tarifa", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
					
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
  /*  //obtener temporadas
    $listaTemporadas=array();

    //OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Nueva tarifa", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE NUEVA TARIFA
                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
                
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo cod_actividad                 
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_actividad"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_actividad"], true);
                            }
                            echo CHTML::campoLabel("Actividad", "cod_actividad");
                            echo CHTML::campoListaDropDown("cod_actividad", (isset($_GET["cod_actividad"])?$_GET["cod_actividad"]: 0),Actividades::listaActividades(), array("class"=>"form-control", "disabled"=>"disabled"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");       
                    echo CHTML::dibujaEtiqueta("div");          
                        //Campo cod_tipo_cuota                      
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["cod_tipo_cuota"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_tipo_cuota"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "cod_tipo_cuota");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_tipo_cuota", TiposCuota::listaTiposCuota(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");                      
                        
                        //Campo precio
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["precio"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["precio"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "precio");
                            echo CHTML::modeloText($modelo, "precio", array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo ocupacion
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            if(isset($errores["ocupacion"])){
                                echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["ocupacion"], true);
                            }
                            echo CHTML::modeloLabel($modelo, "ocupacion");
                            echo CHTML::modeloCheckBox($modelo, "ocupacion");
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");    
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Añadir tarifa", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");*/
