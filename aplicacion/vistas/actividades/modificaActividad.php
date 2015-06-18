<?php

    //OBTENER ERRORES
    $errores=$modelo->getErrores();
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	echo CHTML::scriptFichero("../../script/scriptCrudActividades.js");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Modifica actividad", true);                
                echo CHTML::dibujaEtiquetaCierre("div");
				//CONTENEDOR ERRORES
				echo CHTML::dibujaEtiqueta("div");
					foreach ($errores as $error) {
						echo CHTML::dibujaEtiqueta("p", array("class"=>"help-block"), $error, true);	
					}
				echo CHTML::dibujaEtiquetaCierre("div");
                //FORMULARIO DE MODIFICA ACTIVIDAD
                echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
                
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo nombre                  
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));                            
                            echo CHTML::modeloLabel($modelo, "nombre");
                            echo CHTML::modeloText($modelo, 
                                                    "nombre",                   
                                                    array("class"=>"form-control", "maxlength"=>50, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                              
                        //Campo categoria                        
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cod_categoria");                            
                            echo CHTML::modeloListaDropDown($modelo, "cod_categoria", Categorias::listaCategorias(), array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo temporada
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "cod_temporada");                            
                            echo CHTML::modeloListaDropDown($modelo,"cod_temporada", Temporadas::listaTemporadas(), array("class"=>"form-control", "disabled"=>"disabled"));
                        echo CHTML::dibujaEtiquetaCierre("div");                        
                        
                        //Campo novedad
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "novedad");
                            echo CHTML::modeloCheckBox($modelo, "novedad");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo seleccionable horas
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "seleccionable_horas");
                            echo CHTML::modeloCheckBox($modelo, "seleccionable_horas");
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
						//Campo novedad
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "disponible");
                            echo CHTML::modeloCheckBox($modelo, "disponible");
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");    
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo fecha_inicio
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "fecha_inicio");
                            echo CHTML::modeloText($modelo, "fecha_inicio", array("class"=>"form-control fecha", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div");  
                        
                        //Campo fecha_fin
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "fecha_fin");
                            echo CHTML::modeloText($modelo, "fecha_fin", array("class"=>"form-control fecha", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                        echo CHTML::dibujaEtiquetaCierre("div"); 
                                                     
                        //Campo capacidad
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "capacidad");
                            echo CHTML::modeloNumber($modelo, "capacidad", array("class"=>"form-control", "placeholder"=>"Capacidad"));
                        echo CHTML::dibujaEtiquetaCierre("div");   
						
						//Campo periodo_anulacion
						echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "periodo_anulacion");
							echo CHTML::modeloNumber($modelo, "periodo_anulacion", array("class"=>"form-control", "placeholder"=>"Período de anulación"));
                        echo CHTML::dibujaEtiquetaCierre("div");                           
                                                     
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo imagen
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "imagen");
                            echo CHTML::modeloFile($modelo, "imagen", array("class"=>"form-control"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo mini_descripcion
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "mini_descripcion");
                            echo CHTML::modeloTextArea($modelo, "mini_descripcion",                                           
                                                    array("class"=>"form-control", "maxlength"=>50, "cols"=>"20", "rows"=>"3"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");     
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo descripcion                       
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::modeloLabel($modelo, "descripcion");
                            echo CHTML::modeloTextArea($modelo, "descripcion",                                           
                                                    array("class"=>"form-control", "cols"=>50, "rows"=>5));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Modificar actividad", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
