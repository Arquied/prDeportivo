<?php

	/**
	 * CLASE MODELO MEDIO DE PAGOS
	 */
	class MedioPagos extends CActiveRecord {
		
        protected function fijarNombre(){
            return "medioPagos";
        }   
        
        public function fijarTabla(){
            return "medio_pagos";
        }
        
        public function fijarId(){
            return "cod_medio_pago";
        }
            
        protected function fijarAtributos(){
            return array("cod_medio_pago", "nombre");
        }
        
        protected function fijarDescripciones(){
            return array("cod_categoria"=>"Código del medio de pago",
                        "nombre"=>"Medio de pago"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_medio_pago", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_medio_pago", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del medio de pago debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"nombre", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"nombre", "TIPO"=>"CADENA", "TAMANIO"=>20, "MENSAJE"=>"El nombre no puede ser tan largo", "DEFECTO"=>""),
						array("ATRI"=>"nombre", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula")
                        );
        }
        
        protected function afterCreate(){
           $this->cod_medio_pago=1;
           $this->nombre="";              
        }   
        
        protected function afterBuscar(){

        }   
		
        protected function convertirMayuscula(){
            $cadena=strtoupper($this->nombre);
            $this->nombre=$cadena;      
        }
        
        protected function fijarSentenciaInsert(){
            $nombre=CGeneral::addSlashes($this->nombre);
                                            
            return "insert into medio_pagos (".
                        " nombre".
                        " ) values ( ".
                        " '$nombre' ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre=CGeneral::addSlashes($this->nombre);
                
            return "update medio_pagos set ".
                            " nombre='$nombre' ".
                            " where cod_medio_pago={$this->cod_medio_pago} ";                                                                       
        }
		
		public static function listaMedioPagos($codigo=null){
            
            $medioPagos = new MedioPagos();
            if ($codigo == null) {
                        
                $lista = array();
                foreach($medioPagos->buscarTodos() as $medioPago)
                    $lista[$medioPago["cod_medio_pago"]] = $medioPago["nombre"];
                
                return $lista;
            }
            
            if ($medioPagos->buscarPorId($codigo))
            return $medioPagos->nombre;
            
            return null;
            
        }           
        
    }
