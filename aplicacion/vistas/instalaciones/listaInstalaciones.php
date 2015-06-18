<?php

    echo CHTML::cssFichero("/estilos/estiloInstalaciones.css");
    
		//Titulo
    echo CHTML::dibujaEtiqueta("div", array("class"=>""));
         echo CHTML::dibujaEtiqueta("h2", array(), "Instalaciones", true);                
    echo CHTML::dibujaEtiquetaCierre("div");
	
    //FILTRADO
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contFiltrado"));

                //FORMULARIO DE FILTRADO
                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
                    
                    //Campo nombre instalacion
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoLabel("Nombre", "nombre");
                        echo CHTML::campoText("nombre", "", array("class"=>"form-control", "size"=>30));
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    //Boton submit
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoBotonSubmit("Filtrar", array("class"=>"btn btn-default"));                 
                    echo CHTML::dibujaEtiquetaCierre("div");
                
                echo CHTML::finalizarForm();
    echo CHTML::dibujaEtiquetaCierre("div");
    
    //INSTALACIONES
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container marketing"));
        if(!$filas && count($filas)==0 && $filas || $filas==false){
            echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("h2", array(), "No existe resultado de busqueda", true);
            echo CHTML::dibujaEtiquetaCierre("div");
        }
        else{
            foreach ($filas as $clave => $valor) {
            	if ($valor["cod_instalacion"] != 0)
                	$this->dibujaVistaParcial("listaInstalacionesParcial", array("fila"=>$valor, "clave"=>$clave));
            }    
        }
        
    
    echo CHTML::dibujaEtiquetaCierre("div");
    
    
    //PAGINADOR
    echo CPager::requisitos();
    if(count($filas)>0){
        $pagi=new CPager($paginador,array());
        echo $pagi->dibujate();
    }
