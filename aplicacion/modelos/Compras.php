<?php

    /**
     *  CLASE MODELO COMPRAS
     */
    class Compras extends CActiveRecord {
                
        protected function fijarNombre(){
            return "compra";
        }   
        
        public function fijarTabla(){
            return "compras";
        }
        
        public function fijarId(){
            return "cod_compra";
        }
            
        protected function fijarAtributos(){
            return array("cod_compra", "cod_reserva", "importe_pagado", "pendiente", "fecha_compra", "fecha_inicio", "fecha_fin", "importe", "anulado");
        }
        
        protected function fijarDescripciones(){
            return array("cod_compra"=>"Código de la compra",
                        "cod_reserva"=>"Código de reserva",
                        "importe_pagado"=>"Importe pagado",
                        "pendiente"=>"Compra pendiente o pagado",
                        "fecha_compra"=>"Fecha de la compra",
                        "fecha_inicio"=>"Fecha inicio",
                        "fecha_fin"=>"Fecha fin",
                        "importe"=>"Importe total de la compra",
                        "anulado"=>"Anular reserva"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_compra", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_compra", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la compra debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_reserva", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_reserva", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"importe_pagado", "TIPO"=>"REAL", "MIN"=>0.0),
                        array("ATRI"=>"pendiente", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
                        array("ATRI"=>"fecha_compra", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_inicio", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_fin", "TIPO"=>"FECHA"),
                        array("ATRI"=>"importe", "TIPO"=>"REAL", "MIN"=>0.0, "MENSAJE"=>"El importe total debe ser positivo"),
                        array("ATRI"=>"anulado", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1)
                        );
        }
        
        protected function afterCreate(){
           $this->cod_compra=1;
           $this->cod_reserva=0;
           $this->importe_pagado=0;
           $this->pendiente=1;
           $this->fecha_compra=date("d/m/Y");
           $this->fecha_inicio=date("d/m/Y");
           $this->fecha_fin=date("d/m/Y");
           $this->importe=0.0;
           $this->anulado=0;
              
        }   
        
        protected function afterBuscar(){
            $fecha=$this->fecha_compra;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_compra=$fecha;        
                
            $fecha=$this->fecha_inicio;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_inicio=$fecha;        
        
            $fecha=$this->fecha_fin;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_fin=$fecha;
        }   
        
        protected function fijarSentenciaInsert(){
            $cod_reserva=intval($this->cod_reserva);
            $importe_pagado=intval($this->importe_pagado);
            $pendiente=intval($this->pendiente);
            $fecha_compra=CGeneral::fechaNormalAMysql($this->fecha_compra);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $importe=floatval($this->importe);
            $anulado=intval($this->anulado);
                             
            return "insert into compras (".
                        " cod_reserva, importe_pagado, pendiente, fecha_compra, fecha_inicio, fecha_fin, importe, anulado ".
                        " ) values ( ".
                        " $cod_reserva, $importe_pagado, $pendiente, '$fecha_compra', '$fecha_inicio', '$fecha_fin', $importe, $anulado ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $cod_reserva=intval($this->cod_reserva);
            $importe_pagado=intval($this->importe_pagado);
            $pendiente=intval($this->pendiente);
            $fecha_compra=CGeneral::fechaNormalAMysql($this->fecha_compra);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $importe=floatval($this->importe);
            $anulado=intval($this->anulado);
                
            return "update compras set ".
                            " cod_reserva=$cod_reserva, ".
                            " importe_pagado=$importe_pagado, ".
                            " pendiente=$pendiente, ".
                            " fecha_compra='$fecha_compra', ".
                            " fecha_inicio='$fecha_inicio',".
                            " fecha_fin='$fecha_fin', ".
                            " importe=$importe, ".
                            " anulado=$anulado ".
                            " where cod_compra={$this->cod_compra} ";                                                                       
        }           
        
    }
