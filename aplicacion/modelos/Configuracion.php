<?php

    /**
     *  CLASE MODELO CONFIGURACION
     */
    class Configuracion extends CActiveRecord {
                
        protected function fijarNombre(){
            return "configuracion";
        }   
        
        public function fijarTabla(){
            return "configuracion";
        }
        
        public function fijarId(){
            return "cod_configuracion";
        }
            
        protected function fijarAtributos(){
            return array("cod_configuracion", "nombre_empresa", "cif", "logo");
        }
        
        protected function fijarDescripciones(){
            return array("cod_configuracion"=>"Código de configuración",
                        "nombre_empresa"=>"Nombre de la empresa",
                        "cif"=>"Cif empresa",
                        "logo"=>"Logo de la empresa"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_configuracion", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_configuracion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la configuración debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"nombre_empresa", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"El nombre de empresa no puede ser tan largo", "DEFECTO"=>""),
                        array("ATRI"=>"cif", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El cif no puede ser tan largo", "DEFECTO"=>""),
                        array("ATRI"=>"logo", "TIPO"=>"CADENA", "TAMANIO"=>100, "MENSAJE"=>"El logo no puede ser tan largo", "DEFECTO"=>"")
                        );
        }
        
        protected function afterCreate(){
           $this->cod_configuracion=1;
           $this->nombre_empresa="";
           $this->cif="";
           $this->logo="";
              
        }   
        
        protected function afterBuscar(){
    
        }   
        
        protected function fijarSentenciaInsert(){
            $nombre_empresa=CGeneral::addSlashes($this->nombre_empresa);
            $cif=CGeneral::addSlashes($this->cif);
            $logo=CGeneral::addSlashes($this->logo);            
                                
            return "insert into configuracion (".
                        " nombre_empresa, cif, logo ".
                        " ) values ( ".
                        " '$nombre_empresa', '$cif', '$logo' ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre_empresa=CGeneral::addSlashes($this->nombre_empresa);
            $cif=CGeneral::addSlashes($this->cif);
            $logo=CGeneral::addSlashes($this->logo);
                
            return "update configuracion set ".
                            " nombre_empresa='$nombre_empresa', ".
                            " cif='$cif', ".
                            " logo='$logo' ".
                            " where cod_configuracion={$this->cod_configuracion} ";                                                                       
        }           
        
    }
