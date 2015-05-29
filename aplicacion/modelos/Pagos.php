<?php

    /**
     *  CLASE MODELO PAGOS
     */
    class Pagos extends CActiveRecord {
                
        protected function fijarNombre(){
            return "pago";
        }   
        
        public function fijarTabla(){
            return "pagos";
        }
        
        public function fijarId(){
            return "cod_pagos";
        }
            
        protected function fijarAtributos(){
            return array("cod_pago", "cod_medio_pago", "cod_usuario", "fecha_pago", "importe_pagado");
        }
        
        protected function fijarDescripciones(){
            return array("cod_pago" => "Código del pago",
                         "cod_medio_pago" => "Medio de pago",
                        "cod_usuario" => "Código del usuario",
                        "fecha_pago" => "Fecha del pago",
                        "importe_pagado" => "Importe pagado"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_pago", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_pago", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de pago reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_medio_pago", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_medio_pago", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del usuario reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_usuario", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_usuario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del usuario reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"fecha_pago", "TIPO"=>"FECHA"),
                        array("ATRI"=>"importe_pagado", "TIPO"=>"REAL", "MIN"=>0.0, "MENSAJE"=>"El importe debe ser positivo", "DEFECTO"=>"")
                        );
        }
        
        protected function afterCreate(){
           $this->cod_pago=1;
		   $this->cod_medio_pago=0;
           $this->cod_usuario=0;
           $this->fecha_pago=date("d/m/Y");
           $this->importe_pagado=0.0;             
        }   
        
        protected function afterBuscar(){
            $fecha=$this->fecha_pago;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_pago=$fecha;
        }   
        
        protected function fijarSentenciaInsert(){
           $cod_medio_pago=intval($this->cod_medio_pago);       
           $cod_usuario=intval($this->cod_usuario);    
           $fecha_pago=CGeneral::fechaNormalAMysql($this->fecha_pago);  
           $importe_pagado=floatval($this->importe_pagado);   
                                
            return "insert into pagos (".
                        " cod_medio_pago, cod_usuario, fecha_pago, importe_pagado ".
                        " ) values ( ".
                        " $cod_usuario, $cod_medio_pago, '$fecha_pago', $importe_pagado ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
		   $cod_medio_pago=intval($this->cod_medio_pago);
           $cod_usuario=intval($this->cod_usuario);
           $fecha_pago=CGeneral::fechaNormalAMysql($this->fecha_pago); 
           $importe_pagado=floatval($this->importe_pagado);
                
            return "update pagos set ".
                            " cod_medio_pago=$cod_medio_pago, ".
                            " cod_usuario=$cod_usuario, ".
                            " fecha_pago='$fecha_pago', ".
                            " importe_pagado=$importe_pagado ".
                            " where cod_pago={$this->cod_pago} ";                                                                       
        }           
        
    }
