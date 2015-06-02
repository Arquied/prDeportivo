<?php

    /**
     *  CLASE MODELO RESERVAS
     */
    class Reservas extends CActiveRecord {
                
        protected function fijarNombre(){
            return "reserva";
        }   
        
        public function fijarTabla(){
            return "reservas";
        }
        
        public function fijarId(){
            return "cod_reserva";
        }
            
        protected function fijarAtributos(){
            return array("cod_reserva", "cod_usuario", "cod_tarifa", "cod_actividad", "fecha_reserva", "fecha_inicio", "fecha_fin", "tarifa", "anulado", "fecha_anulacion");
        }
        
        protected function fijarDescripciones(){
            return array("cod_reserva"=>"Código de reserva",
                        "cod_usuario"=>"Código de usuario",
                        "cod_tarifa"=>"Tarifa",
                        "cod_actividad"=>"Actividad",
                        "fecha_reserva"=>"Fecha de la reserva",
                        "fecha_inicio"=>"Fecha inicio",
                        "fecha_fin"=>"Fecha fin",
                        "tarifa"=>"Precio total de la reserva",
                        "anulado"=>"Anular reserva",
                        "fecha_anulacion" =>"Fecha de anulación"
                        );
        }
        
        protected function fijarRestricciones(){
            return array(array("ATRI"=>"cod_reserva", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_reserva", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la reserva debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_usuario", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_usuario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del usuario debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_tarifa", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_tarifa", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la tarifa debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"cod_actividad", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_actividad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
                        array("ATRI"=>"fecha_reserva", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_inicio", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_fin", "TIPO"=>"FECHA"),
                        array("ATRI"=>"tarifa", "TIPO"=>"REAL", "MIN"=>0.0, "MENSAJE"=>"El precio total debe ser positivo"),
                        array("ATRI"=>"anulado", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
                        array("ATRI"=>"fecha_anulacion", "TIPO"=>"FECHA"),
                        );
        }
        
        protected function afterCreate(){
           $this->cod_reserva=1;
           $this->cod_usuario=0;
           $this->cod_tarifa=0;
           $this->cod_actividad=0;
           $this->fecha_reserva=date("d/m/Y");
           $this->fecha_inicio=date("d/m/Y");
           $this->fecha_fin=date("d/m/Y");
           $this->tarifa=0.0;
           $this->anulado=0;
           $this->fecha_anulacion=null;
              
        }   
        
        protected function afterBuscar(){
            $fecha=$this->fecha_reserva;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_reserva=$fecha;        
                
            $fecha=$this->fecha_inicio;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_inicio=$fecha;        
        
            $fecha=$this->fecha_fin;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_fin=$fecha;
            
            if($this->fecha_anulacion!=null){
                $fecha=$this->fecha_anulacion;
                $fecha=CGeneral::fechaMysqlANormal($fecha);
                $this->fecha_anulacion=$fecha;    
            }           
        }   
        
        protected function fijarSentenciaInsert(){
            $cod_usuario=intval($this->cod_usuario);
            $cod_tarifa=intval($this->cod_tarifa);
            $cod_actividad=intval($this->cod_actividad);
            $fecha_reserva=CGeneral::fechaNormalAMysql($this->fecha_reserva);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $tarifa=floatval($this->tarifa);
            $anulado=intval($this->anulado);
            if($this->fecha_anulacion==null){
                return "insert into reservas (".
                        " cod_usuario, cod_tarifa, cod_actividad, fecha_reserva, fecha_inicio, fecha_fin, tarifa, anulado ".
                        " ) values ( ".
                        " $cod_usuario, $cod_tarifa, $cod_actividad, '$fecha_reserva', '$fecha_inicio', '$fecha_fin', $tarifa, $anulado ".
                        " ) " ;    
            }
            
            $fecha_anulacion=CGeneral::fechaNormalAMysql($this->fecha_anulacion);                                
            return "insert into reservas (".
                        " cod_usuario, cod_tarifa, cod_actividad, fecha_reserva, fecha_inicio, fecha_fin, tarifa, anulado, fecha_anulacion ".
                        " ) values ( ".
                        " $cod_usuario, $cod_tarifa, $cod_actividad, '$fecha_reserva', '$fecha_inicio', '$fecha_fin', $tarifa, $anulado, '$fecha_anulacion' ".
                        " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $cod_usuario=intval($this->cod_usuario);
            $cod_tarifa=intval($this->cod_tarifa);
            $cod_actividad=intval($this->cod_actividad);
            $fecha_reserva=CGeneral::fechaNormalAMysql($this->fecha_reserva);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $tarifa=floatval($this->tarifa);
            $anulado=intval($this->anulado);
            if($this->fecha_anulacion==null){
                return "update reservas set ".
                            " cod_usuario=$cod_usuario, ".
                            " cod_tarifa=$cod_tarifa, ".
                            " cod_actividad=$cod_actividad, ".
                            " fecha_reserva='$fecha_reserva', ".
                            " fecha_inicio='$fecha_inicio',".
                            " fecha_fin='$fecha_fin', ".
                            " tarifa=$tarifa, ".
                            " anulado=$anulado ".
                            " where cod_reserva={$this->cod_reserva} ";    
            }
            
            $fecha_anulacion=CGeneral::fechaNormalAMysql($this->fecha_anulacion);                
            return "update reservas set ".
                            " cod_usuario=$cod_usuario, ".
                            " cod_tarifa=$cod_tarifa, ".
                            " cod_actividad=$cod_actividad, ".
                            " fecha_reserva='$fecha_reserva', ".
                            " fecha_inicio='$fecha_inicio',".
                            " fecha_fin='$fecha_fin', ".
                            " tarifa=$tarifa, ".
                            " anulado=$anulado, ".
                            " fecha_anulacion='$fecha_anulacion' ".
                            " where cod_reserva={$this->cod_reserva} ";                                                                       
        }           
        
    }
