<?php

    echo CHTML::cssFichero("/estilos/estiloActividades.css");
    
    //FILTRADO
    echo CHTML::dibujaEtiqueta("div", array("class"=>"contFiltrado"));
                echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitFormulario"));
                    echo CHTML::dibujaEtiqueta("h4", array(), "Campos de filtrado", true);                
                echo CHTML::dibujaEtiquetaCierre("div");

                //FORMULARIO DE FILTRADO
                echo CHTML::iniciarForm("", "post", array("role"=>"form"));
                    //Campo categoria           
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoLabel("Categorías", "categoria");                            
                        echo CHTML::campoListaDropDown("categoria", $categoria, Categorias::listaCategorias(), array("class"=>"form-control"));
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    //Campo nombre actividad
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoLabel("Nombre", "nombre");
                        echo CHTML::campoText("nombre", "", array("class"=>"form-control", "size"=>30));
                    echo CHTML::dibujaEtiquetaCierre("div");
					
					//Campo temporada
					echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoLabel("Temporada", "temporada");                            
                        echo CHTML::campoListaDropDown("temporada", (count($filas)>0)?$filas[0]["cod_temporada"]:"", Temporadas::listaTemporadasProximas(), array("class"=>"form-control"));
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    //Boton submit
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"form-group"));
                        echo CHTML::campoBotonSubmit("Filtrar", array("class"=>"btn btn-default"));                 
                    echo CHTML::dibujaEtiquetaCierre("div");
                
                echo CHTML::finalizarForm();
    echo CHTML::dibujaEtiquetaCierre("div");
    
    //ACTIVIDADES
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container marketing"));
        if(!$filas && count($filas)==0){
            echo CHTML::dibujaEtiqueta("div");
                echo CHTML::dibujaEtiqueta("h2", array(), "No existe resultado de busqueda", true);
            echo CHTML::dibujaEtiquetaCierre("div");
        }
        else{
            foreach ($filas as $clave => $valor) {
                $this->dibujaVistaParcial("listaActividadesParcial", array("fila"=>$valor, "clave"=>$clave));
            }    
        }
        
    
    echo CHTML::dibujaEtiquetaCierre("div");
    
    
    //PAGINADOR
    echo CPager::requisitos();
    if(count($filas)>0){
        $pagi=new CPager($paginador,array());
        echo $pagi->dibujate();
    }
