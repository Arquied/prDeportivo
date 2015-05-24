<?php
    /**
     *  CLASE MODELO CALENDARIOS INSTALACIONES
     */
    class CalendariosInstalaciones extends CActiveRecord {
                
        protected function fijarNombre(){
            return "calendarios_instalacion";
        }   
        
        public function fijarTabla(){
            return "calendarios_instalaciones";
        }
        
        public function fijarId(){
            return "cod_calendario_instalacion";
        }
            
        protected function fijarAtributos(){
            return array("cod_calendario_instalacion", "cod_calendario", "cod_instalacion");
        }
        
        protected function fijarDescripciones(){
            return array("cod_calendario_instalacion"=>"Código calendario actividad instalacion",
                        "cod_calendario"=>"Código calendario actividad",
                        "cod_instalacion"=>"Código instalacion"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_calendario_instalacion", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_calendario_instalacion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del calendario_actividad_instalacion debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_calendario", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_calendario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del calendario_actividad debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_instalacion", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_instalacion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la instalacion debe ser positivo", "DEFECTO"=>0)
                        );
        }
        
        protected function afterCreate(){
            $this->cod_calendario_instalacion=1;
            $this->cod_calendario=0;
            $this->cod_instalacion=0;   
        }   
        
        protected function afterBuscar(){
            
        }   
        
        protected function fijarSentenciaInsert(){
            $cod_calendario=$this->cod_calendario;
            $cod_instalacion=$this->cod_instalacion;
            
            return "insert into calendarios_instalaciones (".
                        " cod_calendario, cod_instalacion ".
                        " ) values ( ".
                        " $cod_calendario, $cod_instalacion ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $cod_calendario=$this->cod_calendario;
            $cod_instalacion=$this->cod_instalacion;
                
            return "update calendarios_instalaciones set ".
                            " cod_calendario=$cod_calendario, ".
                            " cod_instalacion=$cod_instalacion ".
                            " where cod_calendario_instalacion={$this->cod_calendario_instalacion} ";                                                                       
        }
        
        public function borrarCalendarioInstalacion($cod){
            $sentencia = "delete from calendarios_instalaciones where cod_calendario=$cod";
            return parent::ejecutarSentencia($sentencia);
        }
        
    }
