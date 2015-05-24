<?php
	/**
	 *  CLASE MODELO CALENDARIOS
	 */
	class Calendarios extends CActiveRecord {
				
		protected function fijarNombre(){
			return "calendario";
		}	
		
		public function fijarTabla(){
			return "calendarios";
		}
		
		public function fijarId(){
			return "cod_calendario";
		}
			
		protected function fijarAtributos(){
			return array("cod_calendario", "cod_dia", "cod_actividad", "hora_inicio", "hora_fin", "fecha_inicio", "fecha_fin", "disponible");
		}
		
		protected function fijarDescripciones(){
			return array("cod_calendario"=>"Código calendario actividad",
						"cod_dia"=>"Código dia semana",
						"cod_actividad"=>"Código de la actividad",
                        "hora_inicio"=>"Hora de inicio:",
                        "hora_fin"=>"Hora de finalización:",
                        "fecha_inicio"=>"Fecha de inicio:",
                        "fecha_fin"=>"Fecha de fin:",
						"disponible"=>"Está disponible"
						);
		}
		
		protected function fijarRestricciones(){
			return array(array("ATRI"=>"cod_calendario", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_calendario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del calendario_actividad debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_actividad", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_actividad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_dia", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_dia", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del dia de la semana debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"hora_inicio", "TIPO"=>"HORA"),
						array("ATRI"=>"hora_fin", "TIPO"=>"HORA"),
						array("ATRI"=>"fecha_inicio", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_inicio", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"fecha_inicio","TIPO"=>"FUNCTION","FUNCTION"=>"validaFechaInicio"),
						array("ATRI"=>"fecha_fin", "TIPO"=>"FECHA"),
                        array("ATRI"=>"fecha_fin","TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"fecha_fin","TIPO"=>"FUNCTION", "FUNCTION"=>"validaFechaFin"),
						array("ATRI"=>"disponible", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1)
						);
		}
		
		protected function afterCreate(){
			$this->cod_calendario=1;
			$this->cod_actividad=0;
			$this->cod_dia=0;
            $fech = new DateTime();   
			         
            $hora = $fech->format("H:i:s");
            $this->hora_inicio = $hora;
            $this->hora_fin = $hora;
            
            $fecha = $fech->format("d/m/Y");
            $this -> fecha_inicio = $fecha;
            $this -> fecha_fin = $fecha;    
			
			$this->disponible=1;
		}	
		
		protected function afterBuscar(){
			$fecha=$this->fecha_inicio;
			$fecha=CGeneral::fechaMysqlANormal($fecha);
			$this->fecha_inicio=$fecha;		
		
			$fecha=$this->fecha_fin;
			$fecha=CGeneral::fechaMysqlANormal($fecha);
			$this->fecha_fin=$fecha;
		}	
		
        protected function validaFechaInicio(){        
            $fecha1=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
            
            $fecha2 = new DateTime();
            $fecha2= $fecha2->format("d/m/Y");
            if ($fecha1<$fecha2){
                $this->setError("fecha_inicio","La fecha de inicio debe ser posterior a ".$fecha2);
            }
        }
        
        protected function validaFechaFin(){        
            $fecha1=DateTime::createFromFormat('d/m/Y',$this->fecha_fin);
            $fecha2=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
            if ($fecha1<$fecha2){
                $this->setError("fecha_fin","La fecha de finalización debe ser posterior a ".$fecha2);
            }
        }
		
		protected function fijarSentenciaInsert(){
			$cod_actividad=$this->cod_actividad;
			$cod_dia=$this->cod_dia;
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $hora_inicio=CGeneral::addSlashes($this->hora_inicio);
            $hora_fin=CGeneral::addSlashes($this->hora_fin);
            
			$disponible=intval($this->disponible);					
			return "insert into calendarios (".
						" cod_actividad, cod_dia, hora_inicio, hora_fin, fecha_inicio, fecha_fin, disponible ".
						" ) values ( ".
						" $cod_actividad, $cod_dia, '$hora_inicio', '$hora_fin', '$fecha_inicio', '$fecha_fin', $disponible ".
						" ) " ;
		}
		
		protected function fijarSentenciaUpdate(){
			$cod_actividad=$this->cod_actividad;
			$cod_dia=$this->cod_dia;
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $hora_inicio=CGeneral::addSlashes($this->hora_inicio);
            $hora_fin=CGeneral::addSlashes($this->hora_fin);
			$disponible=intval($this->disponible);
			
			return "update calendarios set ".
							" cod_actividad=$cod_actividad, ".
							" cod_dia=$cod_dia, ".
							" hora_inicio='$hora_inicio', ".
							" hora_fin='$hora_fin', ".
							" fecha_inicio='$fecha_inicio', ".
							" fecha_fin='$fecha_fin', ".
							" disponible=$disponible ".
							" where cod_calendario={$this->cod_calendario} ";																		
		}
		
		public static function listaCalendarios($codigo=null){            
            $calendarios = new Calendarios();
            if ($codigo == null) {
                        
                $lista = array();
                foreach($calendarios->buscarTodos() as $calendario)
                    $lista[$calendario["cod_calendario"]] = $calendario["nombre"];
                
                return $lista;
            }
            
            if ($calendarios->buscarPorId($codigo))
            return $calendarios->nombre;
            
            return null;
            
        }			
		
	}
