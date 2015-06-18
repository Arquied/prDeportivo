<?php
    /*
     * CLASE MODELO TARIFAS
     */
    class Tarifas extends CActiveRecord {
        
        protected function fijarNombre() {
            return 'tarifa';
        }
        
        protected function fijarTabla(){
            return "tarifas";
        }
        
        protected function fijarID(){
            return "cod_tarifa";
        }
        
        protected function fijarAtributos() {
            return array("cod_tarifa", "cod_actividad",
                            "cod_tipo_cuota", "precio", "ocupacion", "disponible");
        }
        protected function fijarDescripciones() {
            return array("cod_tarifa" => "Codigo tarifa:",
                            "cod_actividad"=>"Codigo actividad:",
                            "cod_tipo_cuota"=>"Tipo de cuota:",
                            "precio"=>"Precio:",
                            "ocupacion"=>"Ocupacion:",
                            "disponible"=>"Disponible"
							);
        }
        protected function fijarRestricciones() {
            Return array(array("ATRI"=>"cod_tarifa", "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"cod_tarifa", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la tarifa debe ser positivo", "DEFECTO"=>0),
                         array("ATRI"=>"cod_actividad", "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"cod_actividad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
                         array("ATRI"=>"cod_tipo_cuota", "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"cod_tipo_cuota", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de tipo_cuota debe ser positivo", "DEFECTO"=>0),
                         array("ATRI"=>"precio", "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"precio", "TIPO"=>"REAL", "MIN"=>0.0, "MENSAJE"=>"El precio debe ser positivo", "DEFECTO"=>0.0),
                         array("ATRI"=>"ocupacion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"La ocupación debe ser positiva"),
						 array("ATRI"=>"disponible", "TIPO"=>"ENTERO", "MAX"=>1, "MIN"=>0)   
                         );
                                
        }
        protected function afterCreate() {
            $this -> cod_tarifa = 1;
            $this -> cod_actividad = 0;
            $this -> cod_tipo_cuota = 0;
            $this -> precio = 0.0;
            $this -> ocupacion = 0;
            $this -> disponible = 1;
        }
        
        protected function fijarSentenciaInsert(){
            $cod_actividad = intval($this->cod_actividad);
            $cod_tipo_cuota = intval($this->cod_tipo_cuota);
            $precio = floatval($this->precio);
            $ocupacion = intval($this->ocupacion);
            $disponible = intval($this->disponible);
			
            return "insert into tarifas (".
                    " cod_actividad, cod_tipo_cuota, precio, ocupacion, disponible ".
                    " ) values ( ".
                    " $cod_actividad, $cod_tipo_cuota, ".
                    " $precio, $ocupacion, $disponible ".
                    " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $cod_actividad = intval($this->cod_actividad);
            $cod_tipo_cuota = intval($this->cod_tipo_cuota);
            $precio = floatval($this->precio);
            $ocupacion = intval($this->ocupacion);
			$disponible = intval($this->disponible);
            
            return "update tarifas set ".
                    " cod_actividad=$cod_actividad, ".
                    " cod_tipo_cuota=$cod_tipo_cuota,".
                    " precio=$precio, ".
                    " ocupacion=$ocupacion, ".
                    " disponible=$disponible ".
                    " where cod_tarifa={$this->cod_tarifa} ";
        }
        
        
        
    }
