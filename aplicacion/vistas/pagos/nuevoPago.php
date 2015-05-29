<?php

$listaMedioPago = array();

// OBTENER ERRORES
$errores = $modelo->getErrores();

	echo CHTML::cssFichero("../../estilos/jquery.datetimepicker.css");
	echo CHTML::scriptFichero("../../script/jquery.js");
	echo CHTML::scriptFichero("../../script/jquery.datetimepicker.js");
	echo CHTML::scriptFichero("../../script/scriptFecha.js");
    echo CHTML::cssFichero("/estilos/estiloFormularios.css");
	
	
	echo CHTML::dibujaEtiqueta("div", array("class"=>"container contForm"));
    	echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
        	echo CHTML::dibujaEtiqueta("h2", array(), "Pagar", true);                
        echo CHTML::dibujaEtiquetaCierre("div");

        // FORMULARIO DE NUEVO PAGO     
        echo CHTML::iniciarForm("", "post", array("role"=>"form", "enctype"=>"multipart/form-data"));
			
			echo CHTML::dibujaEtiqueta("div");
				
				// Campo usuario	
				echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
					echo CHTML::modeloLabel($usuario, "nombre");
					echo CHTML::modeloText($usuario, "nombre", array("class"=>"form-control", "maxlength"=>50, "size"=>50, "disabled"));
				echo CHTML::dibujaEtiquetaCierre("div");
				echo CHTML::dibujaEtiquetaCierre("div");	
				
				echo CHTML::dibujaEtiqueta("div");	
			
				// Campo fecha_pago
                echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                if(isset($errores["fecha_inicio"])){
                        echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["fecha_pago"], true);
                }
                echo CHTML::modeloLabel($modelo, "fecha_pago");
                echo CHTML::modeloText($modelo, "fecha_pago", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                echo CHTML::dibujaEtiquetaCierre("div");  
        		   echo CHTML::dibujaEtiquetaCierre("div");
				   
        	    echo CHTML::dibujaEtiqueta("div");
			
				// Campo medio_pago
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                    if(isset($errores["cod_medio_pago"])){
                        echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["cod_medio_pago"], true);
                    }
                    echo CHTML::campoLabel("MedioPagos", "medioPagos");                            
                    echo CHTML::campoListaDropDown("medioPagos", "", MedioPagos::listaMedioPagos(), array("class"=>"form-control"));
                echo CHTML::dibujaEtiquetaCierre("div");
			
			echo CHTML::dibujaEtiqueta("div");
				// Campo importe_pagado
                echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                if(isset($errores["importe_pagado"])){
                        echo CHTML::dibujaEtiqueta("span", array("class"=>"help-block"), $errores["importe_pagado"], true);
                }
                echo CHTML::modeloLabel($compra, "importe");
                echo CHTML::modeloText($compra, "importe", array("class"=>"form-control", "maxlength"=>10, "size"=>10, "placeholder"=>"dd/mm/yyyy"));                        
                echo CHTML::dibujaEtiquetaCierre("div"); 
			echo CHTML::dibujaEtiquetaCierre("div");
			
			
            //Boton insertar
            echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                 echo CHTML::campoBotonSubmit("Pagar", array("class"=>"btn btn-default"));                 
            echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiquetaCierre("div");
					
        echo CHTML::finalizarForm();
                
    echo CHTML::dibujaEtiquetaCierre("div");
			
