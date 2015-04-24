<?php

    /**
     *  CLASE MODELO CALENDARIO RESERVA
     */
    class CalendariosReservas extends CActiveRecord {
                
        protected function fijarNombre(){
            return "calendarios_reservas";
        }   
        
        public function fijarTabla(){
            return "calendarios_reservas";
        }
        
        public function fijarId(){
            return "cod_calendario_reserva";
        }
            
        protected function fijarAtributos(){
            return array("cod_calendario_reserva", "cod_reserva", "cod_calendario");
        }
        
        protected function fijarDescripciones(){
            return array("cod_calendario_reserva"=>"Código del calendario reserva",
                        "cod_reserva"=>"Código de reserva",
                        "cod_calendario"=>"Código del calendario"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_calendario_reserva", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_calendario_reserva", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de calendario reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_reserva", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_reserva", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la reserva reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_calendario", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_calendario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de calendario debe ser positivo", "DEFECTO"=>0)                        
                        );
        }
        
        protected function afterCreate(){
           $this->cod_calendario_reserva=-1;
           $this->cod_reserva=0;
           $this->cod_calendario=0;              
        }   
        
        protected function afterBuscar(){
    
        }   
        
        protected function fijarSentenciaInsert(){
           $cod_reserva=intval($this->cod_reserva);
           $cod_calendario=intval($this->cod_calendario);      
                                
            return "insert into calendarios_reservas (".
                        " cod_calendario, cod_reserva ".
                        " ) values ( ".
                        " $cod_calendario, $cod_reserva ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $cod_reserva=intval($this->cod_reserva);
            $cod_calendario=intval($this->cod_calendario);
                
            return "update calendarios_reservas set ".
                            " cod_reserva=$cod_reserva, ".
                            " cod_calendario=$cod_calendario ".
                            " where cod_calendario_reserva={$this->cod_calendario_reserva} ";                                                                       
        }           
        
    }
