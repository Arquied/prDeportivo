<?php

     echo CHTML::cssFichero("/estilos/estiloCalendario.css");
	 
	//Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>""));
         echo CHTML::dibujaEtiqueta("h2", array(), "Calendario", true);                
    echo CHTML::dibujaEtiquetaCierre("div");
	
	//FILTRADO
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contFiltrado"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h4", array(), "Campos de filtrado", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE FILTRADO
                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
                    
                    //Campo nombre instalacion
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoLabel("Nombre", "cod_instalacion");
                   		echo CHTML::campoListaDropDown("cod_instalacion", "", Instalaciones::listaInstalacion2(), array("class"=>"form-control list"));
					echo CHTML::dibujaEtiquetaCierre("div");
                    
                    //Boton submit
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoBotonSubmit("Filtrar", array("class"=>"btn btn-default"));                 
                    echo CHTML::dibujaEtiquetaCierre("div");
                
                echo CHTML::finalizarForm();
    echo CHTML::dibujaEtiquetaCierre("div");
	
    echo CHTML::dibujaEtiqueta("div", array());
        if(!$filas && count($filas)==0){
            echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("h2", array(), "No existe Calendario para esa instalación", true);
            echo CHTML::dibujaEtiquetaCierre("div");
        }
        else{
                $this->dibujaVistaParcial("mostrarCalendarioParcial", array("filas"=>$filas, "horario"=>$horario));
        }
		
		
