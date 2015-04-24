<?php

    /**
     *  CLASE MODELO TIPO DE CUOTA
     */
    class Tipos_cuota extends CActiveRecord {
                
        protected function fijarNombre(){
            return "tipo_cuotas";
        }   
        
        public function fijarTabla(){
            return "tipos_cuotas";
        }
        
        public function fijarId(){
            return "cod_tipo_cuota";
        }
            
        protected function fijarAtributos(){
            return array("cod_tipo_cuota", "tipo", "semanal", "quincenal", "mensual", "diario");
        }
        
        protected function fijarDescripciones(){
            return array("cod_tipo_cuota"=>"Código del tipo de cuota",
                        "tipo"=>"Nombre",
                        "semanal"=>"Cuota semanal",
                        "quincenal"=>"Cuota quincenal",
                        "mensual"=>"Cuota mensual",
                        "diario"=>"Cuota diaria"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_tipo_cuota", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_tipo_cuota", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de del tipo de cuota debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"tipo", "TIPO"=>"CADENA", "TAMANIO"=>20, "MENSAJE"=>"El nombre no puede ser tan largo"),
                        array("ATRI"=>"tipo", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula"),
                        array("ATRI"=>"semanal", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
                        array("ATRI"=>"mensual", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
                        array("ATRI"=>"quincenal", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
                        array("ATRI"=>"diario", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1)
                        );
        }
        
        protected function afterCreate(){
            $this->cod_tipo_cuota=1;
            $this->tipo="";
            $this->semanal=0;
            $this->quincenal=0;
            $this->mensual=0;
            $this->diario=0;
            
        }   
        
        protected function afterBuscar(){
      
        }   
        
        protected function fijarSentenciaInsert(){            
            $tipo=CGeneral::addSlashes($this->tipo);
            $semanal=$this->semanal;
            $quincenal=$this->quincenal;
            $mensual=$this->mensual;
            $diario=$this->diario;
                                
            return "insert into tipo_cuota (".
                        " tipo, semanal, quincenal, mensual, diario ".
                        " ) values ( ".
                        " '$tipo', $semanal, $quincenal, $mensual, $diario ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){            
            $tipo=CGeneral::addSlashes($this->tipo);
            $semanal=$this->semanal;
            $quincenal=$this->quincenal;
            $mensual=$this->mensual;
            $diario=$this->diario;
            
            return "update tipo_cuota set ".
                            " tipo='$tipo', ".
                            " semanal=$semanal, ".
                            " quincenal=$quincenal, ".
                            " mensual=$mensual, ".
                            " diario=$diario ".
                            " where cod_tipo_cuota={$this->cod_tipo_cuota} ";                                                                     
        }
        
        /**
         * METODOS PARA VALIDAR CAMPOS
         */
        protected function convertirMayuscula(){
            $cadena=strtoupper($this->tipo);
            $this->tipo=$cadena;
        }
        
       
                
        
    }
    
