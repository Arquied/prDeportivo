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
            return array("cod_configuracion", "nombre_empresa", "cif", "logo", "url_facebook", "url_twitter");
        }
        
        protected function fijarDescripciones(){
            return array("cod_configuracion"=>"Código de configuración",
                        "nombre_empresa"=>"Nombre de la empresa",
                        "cif"=>"Cif empresa",
                        "logo"=>"Logo de la empresa",
                        "url_facebook"=>"URL facebook",
                        "url_twitter"=>"URL twitter"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_configuracion", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_configuracion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la configuración debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"nombre_empresa", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"El nombre de empresa no puede ser tan largo", "DEFECTO"=>""),
                        array("ATRI"=>"cif", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El cif no puede ser tan largo", "DEFECTO"=>""),
                        array("ATRI"=>"logo", "TIPO"=>"CADENA", "TAMANIO"=>100, "MENSAJE"=>"El logo no puede ser tan largo", "DEFECTO"=>""),
                        array("ATRI"=>"url_facebook", "TIPO"=>"CADENA", "TAMANIO"=>100, "MENSAJE"=>"La url de facebook no puede ser tan larga", "DEFECTO"=>""),
                        array("ATRI"=>"url_twitter", "TIPO"=>"CADENA", "TAMANIO"=>100, "MENSAJE"=>"La url de twitter no puede ser tan larga", "DEFECTO"=>""),
                        );
        }
        
        protected function afterCreate(){
           $this->cod_configuracion=1;
           $this->nombre_empresa="";
           $this->cif="";
           $this->logo="";
           $this->url_facebook="";
		   $this->url_twitter="";
              
        }   
        
        protected function afterBuscar(){
    
        }   
        
        protected function fijarSentenciaInsert(){
            $nombre_empresa=CGeneral::addSlashes($this->nombre_empresa);
            $cif=CGeneral::addSlashes($this->cif);
            $logo=CGeneral::addSlashes($this->logo);        
            $url_facebook=CGeneral::addSlashes($this->url_facebook);
			$url_twitter=CGeneral::addSlashes($this->url_twitter);    
                                
            return "insert into configuracion (".
                        " nombre_empresa, cif, logo, url_facebook, url_twitter ".
                        " ) values ( ".
                        " '$nombre_empresa', '$cif', '$logo', '$url_facebook', '$url_twitter' ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre_empresa=CGeneral::addSlashes($this->nombre_empresa);
            $cif=CGeneral::addSlashes($this->cif);
            $logo=CGeneral::addSlashes($this->logo);
			$url_facebook=CGeneral::addSlashes($this->url_facebook);
			$url_twitter=CGeneral::addSlashes($this->url_twitter);
                
            return "update configuracion set ".
                            " nombre_empresa='$nombre_empresa', ".
                            " cif='$cif', ".
                            " logo='$logo', ".
                            " url_facebook='$url_facebook', ".
                            " url_twitter='$url_twitter' ".
                            " where cod_configuracion={$this->cod_configuracion} ";                                                                       
        }           
        
    }
