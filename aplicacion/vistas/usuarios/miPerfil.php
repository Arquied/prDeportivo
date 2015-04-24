<?php
   // var_dump($modelo);
   
   //Obtener compras realizadas
   $compras=new Compras();
   
   
   
    echo CHTML::cssFichero("../../estilos/estiloPerfil.css");
   
    echo CHTML::dibujaEtiqueta("div", array("class"=>"container-fluid"));
        echo CHTML::dibujaEtiqueta("div", array("class"=>"row"));
            //Perfil
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-3 sidebar"));
                echo CHTML::dibujaEtiqueta("div", array("id"=>"contPerfil"));

                    echo CHTML::dibujaEtiqueta("div", array("class"=>"contTitulo"));
                        echo CHTML::dibujaEtiqueta("h3", array(), "PERFIL", true);    
                    echo CHTML::dibujaEtiquetaCierre("div");    
                
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"contInfoPerfil"));      
                        
                    echo CHTML::dibujaEtiqueta("h4", array("class"=>"text-center"), $modelo->nombre, true);            
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center")); 
                        echo CHTML::dibujaEtiqueta("span", array(), "DNI: ".$modelo->dni, true);
                        echo CHTML::dibujaEtiqueta("span", array(), "F. nacimiento: ".CGeneral::fechaMysqlANormal($modelo->fecha_nac), true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Email: ".$modelo->correo, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Tlf: ".$modelo->telefono, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("span", array(), "Nick: ".$modelo->nick, true);
                    echo CHTML::dibujaEtiquetaCierre("div");
                    
                    echo CHTML::dibujaEtiqueta("div", array("class"=>"text-center"));
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("usuarios", "modificar"), array("cod_usuario"=>$modelo->cod_usuario)), "class"=>"btn btn-default btn-block"), "Modificar mi perfil", true);
                        echo CHTML::dibujaEtiqueta("a", array("href"=>Sistema::app()->generaURL(array("inicial", "cerrarSesion")), "class"=>"btn btn-default btn-block"), "Cerrar sesión", true);
                    echo CHTML::dibujaEtiquetaCierre("div");
            
                    echo CHTML::dibujaEtiquetaCierre("div");
                echo CHTML::dibujaEtiquetaCierre("div");
            echo CHTML::dibujaEtiquetaCierre("div");
            
            //Compras
            echo CHTML::dibujaEtiqueta("div", array("class"=>"col-md-9 col-md-offset-3 main"));
                echo CHTML::dibujaEtiqueta("div", array("id"=>"sinCompras"), "No se ha realizado compras"); 
                
                
            echo CHTML::dibujaEtiquetaCierre("div");
                        
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
