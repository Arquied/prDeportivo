<?php

    /**
     *  CLASE MODELO CATEGORIAS
     */
    class Categorias extends CActiveRecord {
                
        protected function fijarNombre(){
            return "categoria";
        }   
        
        public function fijarTabla(){
            return "categorias";
        }
        
        public function fijarId(){
            return "cod_categoria";
        }
            
        protected function fijarAtributos(){
            return array("cod_categoria", "nombre");
        }
        
        protected function fijarDescripciones(){
            return array("cod_categoria"=>"Código de categoría",
                        "nombre"=>"Nombre de la categoría"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_categoria", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_categoria", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la categoría debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"nombre", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"nombre", "TIPO"=>"CADENA", "TAMANIO"=>20, "MENSAJE"=>"El nombre no puede ser tan largo", "DEFECTO"=>"")
                        );
        }
        
        protected function afterCreate(){
           $this->cod_categoria=1;
           $this->nombre="";              
        }   
        
        protected function afterBuscar(){

        }   
        
        protected function fijarSentenciaInsert(){
            $nombre=CGeneral::addSlashes($this->nombre);
                                            
            return "insert into categorias (".
                        " nombre".
                        " ) values ( ".
                        " '$nombre' ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre=CGeneral::addSlashes($this->nombre);
                
            return "update categorias set ".
                            " nombre='$nombre' ".
                            " where cod_categoria={$this->cod_categoria} ";                                                                       
        }           
        
    }
