<?php
// OBTENER ERRORES
$errores=$modelo->getErrores();
	echo CHTML::cssFichero("/estilos/estiloFormularios.css");	
	echo CHTML::cssFichero("../../estilos/jquery.datetimepicker.css");
	echo CHTML::scriptFichero("../../script/jquery.datetimepicker.js");
	echo CHTML::scriptFichero("../../script/jquery.js");
	echo CHTML::scriptFichero("../../script/scriptFecha.js");
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modificar horario", true);                
                echo CHTML::dibujaEtiquetaCierre("div");
				//CONTENEDOR ERRORES
				echo CHTML::dibujaEtiqueta("div");
					foreach ($errores as $error) {
						echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
					}
				echo CHTML::dibujaEtiquetaCierre("div");
				// FORMULARIO DE MODIFICAR HORARIO
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                              
                        //Campo temporada
                        echo CHTML::dibujaEtiqueta("div");   
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cod_temporada");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_temporada", Temporadas::listaTemporadas(), array("class"=>"form-control", "disabled"=>"disabled"));
                        echo CHTML::dibujaEtiquetaCierre("div");                  
                        
                        // Campo dia
                         echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cod_dia");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_dia", Dias::listaDias(), array("class"=>"form-control", "disabled"=>"disabled"));
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
							//Campo disponible
	                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
	                            echo CHTML::modeloLabel($modelo, "disponible");
	                            echo CHTML::modeloCheckBox($modelo, "disponible");
	                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
						echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo hora_inicio
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::modeloLabel($modelo, "hora_inicio");
                            echo CHTML::modeloText($modelo, "hora_inicio", array("class"=>"form-control", "id"=>"hora_inicio", "maxlength"=>10, "size"=>10,  "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						
                        //Campo hora_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::modeloLabel($modelo, "hora_fin");
                            echo CHTML::modeloText($modelo, "hora_fin", array("class"=>"form-control", "id"=>"hora_fin", "maxlength"=>10, "size"=>10, "placeholder"=>"hh:mm:ss"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						echo CHTML::dibujaEtiquetaCierre("div");
						
                        //Campo fecha_inicio
                        echo CHTML::dibujaEtiqueta("div");
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "fecha_inicio");
                            echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control", "id"=>"fecha_inicio", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                        
                        //Campo fecha_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "fecha_fin");
                            echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control", "id"=>"fecha_fin", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
						echo CHTML::dibujaEtiquetaCierre("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Modificar", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
