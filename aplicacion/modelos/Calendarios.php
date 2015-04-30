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
			return array("cod_calendario", "cod_dia", "cod_actividad", "hora_inicio", "hora_fin", "fecha_inicio", "fecha_fin");
		}
		
		protected function fijarDescripciones(){
			return array("cod_calendario"=>"Código calendario actividad",
						"cod_dia"=>"Código dia semana",
						"cod_actividad"=>"Código de la actividad",
						"hora_inicio"=>"Hora de inicio",
						"hora_fin"=>"Hora de fin",
						"fecha_inicio"=>"Fecha inicio de la actividad",
						"fecha_fin"=>"Fecha fin de la actividad"
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
						array("ATRI"=>"fecha_fin", "TIPO"=>"FECHA")
						);
		}
		
		protected function afterCreate(){
			$this->cod_calendario=1;
			$this->cod_actividad=0;
			$this->cod_dia=0;
			$this->hora_inicio="00:00:00";
			$this->hora_fin="00:00:00";
			$this->fecha_inicio=date("d/m/Y");
			$this->fecha_fin=date("d/m/Y");
			
		}	
		
		protected function afterBuscar(){
			$fecha=$this->fecha_inicio;
			$fecha=CGeneral::fechaMysqlANormal($fecha);
			$this->fecha_inicio=$fecha;		
		
			$fecha=$this->fecha_fin;
			$fecha=CGeneral::fechaMysqlANormal($fecha);
			$this->fecha_fin=$fecha;
		}	
		
		protected function fijarSentenciaInsert(){
			$cod_actividad=$this->cod_actividad;
			$cod_dia=$this->cod_dia;
			$hora_inicio=CGeneral::addSlashes($this->hora_inicio);
			$hora_fin=CGeneral::addSlashes($this->hora_fin);
			$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
			$fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
								
			return "insert into calendarios (".
						" cod_actividad, cod_dia, hora_inicio, hora_fin, fecha_inicio, fecha_fin ".
						" ) values ( ".
						" $cod_actividad, $cod_dia, '$hora_inicio', '$hora_fin', '$fecha_inicio', '$fecha_fin' ".
						" ) " ;
		}
		
		protected function fijarSentenciaUpdate(){
			$cod_actividad=$this->cod_actividad;
			$cod_dia=$this->cod_dia;
			$hora_inicio=CGeneral::addSlashes($this->hora_inicio);
			$hora_fin=CGeneral::addSlashes($this->hora_fin);
			$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
			
			return "update calendario_actividad set ".
							" cod_actividad=$cod_actividad, ".
							" cod_dia=$cod_dia, ".
							" hora_inicio='$hora_inicio', ".
							" hora_fin='$hora_fin', ".
							" fecha_inicio='$fecha_inicio', ".
							" fecha_fin='$fecha_fin' ".
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
