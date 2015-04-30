<?php
    
    
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
    
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h2", array(), "Cambiar contraseña", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO CAMBIO CONTRASENA
                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
                
                    echo CHTML::dibujaEtiqueta("div");
                        //Campo contraseña actual                    
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoLabel("Introduzca contraseña actual", "contrasenaActual");
                            echo CHTML::campoPassword("contrasenaActual", "", array("class"=>"form-control", "maxlength"=>30, "size"=>"50"));
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                      
                    echo CHTML::dibujaEtiqueta("div");  
                        //Campo contraseña nueva
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoLabel("Nueva contraseña", "nuevaContrasena");
                            echo CHTML::campoPassword("nuevaContrasena", "", array("class"=>"form-control", "maxlength"=>30, "size"=>50));    
                        echo CHTML::dibujaEtiquetaCierre("div");
                        
                        //Campo contraseña nueva
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoLabel("Repita contraseña", "nuevaContrasenaRep");
                            echo CHTML::campoPassword("nuevaContrasenaRep", "", array("class"=>"form-control", "maxlength"=>30, "size"=>50));    
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div"); 
                    
                    
                    echo CHTML::dibujaEtiqueta("div");
                        //Boton insertar
                        echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                            echo CHTML::campoBotonSubmit("Cambiar contraseña", array("class"=>"btn btn-default"));                 
                        echo CHTML::dibujaEtiquetaCierre("div");
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
