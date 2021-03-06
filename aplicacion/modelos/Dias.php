<?php

    /*
     * CLASE MODELO DIAS
     */
    class Dias extends CActiveRecord {
        
        protected function fijarNombre() {
            return 'dia';
        }
        
        protected function fijarTabla(){
            return "dias";
        }
        
        protected function fijarID(){
            return "cod_dia";
        }
        
        protected function fijarAtributos() {
            return array("cod_dia", "dia");
        }
        protected function fijarDescripciones() {
            return array("cod_dia" => "Codigo dia:",
                            "dia"=>"Dia:");
        }
        protected function fijarRestricciones() {
            Return array(array("ATRI"=>"cod_dia",
                                "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"cod_dia",
                                "TIPO"=>"ENTERO",
                                "MIN"=>0,
                                "MENSAJE"=>"El código de día debe ser positivo",
                                "DEFECTO"=>0),
                         array("ATRI"=>"dia",
                                "TIPO"=>"CADENA",
                                "TAMANIO"=>10,
                                "MENSAJE"=>"El día no puede tener mas de 10 caracteres"),
                         array("ATRI"=>"dia",
                                "TIPO"=>"FUNCION",
                                "FUNCION"=>"convertirMayuscula"));
                                
        }
        protected function afterCreate() {
            $this -> cod_dia = 1;
            $this -> dia = "";
        }
        
        protected function convertirMayuscula(){
            $cadena=strtoupper($this->dia);
            $this->dia=$cadena;       
        }
        
        protected function fijarSentenciaInsert(){
            $dia=CGeneral::addSlashes($this->dia);
            return "insert into dias (".
                    " dia ".
                    " ) values ( ".
                    " '$dia' ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $dia=CGeneral::addSlashes($this->dia);
            return "update dias set ".
                    " dia='$dia' ".
                    " where cod_dia={$this->cod_dia} ";
        }
        
        public static function listaDias($codigo = null){
 
            $dias = new Dias();
            
            if ($codigo == null){
                
                $lista = array();
                foreach($dias->buscarTodos() as $dia)
                    $lista[$dia["cod_dia"]] = $dia["dia"];
				
				return $lista;
            }
			
            if ($dias->buscarPorId($codigo))
                return $dias->nombre;
                
            return null;
        }
        
    }
