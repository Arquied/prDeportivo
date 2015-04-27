<?php

class HorarioGeneral extends CActiveRecord {
	
	protected function fijarNombre() {
		return 'horario_gen';
	}
	
	protected function fijarTabla(){
		return "horario_general";
	}
	
	protected function fijarID(){
		return "cod_horario_generia";
	}
	
	protected function fijarAtributos() {
		return array("cod_horario_general", "cod_temporada", "cod_dia",
						"hora_inicio", "hora_fin","fecha_inicio","fecha_fin");
	}

	protected function fijarDescripciones() {
		return array("cod_horario_general" => "Codigo horario general:",
						"cod_temporada"=>"Codigo temporada:",
						"cod_dia"=>"Codigo dia:",
						"hora_inicio"=>"Hora de inicio:",
						"hora_fin"=>"Hora de finalización:",
						"fecha_inicio"=>"Fecha de inicio:",
						"fecha_fin"=>"Fecha de fin:");
	}

	protected function fijarRestricciones() {
		Return array(array("ATRI"=>"cod_horario_general","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_horario_general","TIPO"=>"ENTERO","MIN"=>0,"MENSAJE"=>"El código del horario_general debe ser positivo","DEFECTO"=>0),
					 array("ATRI"=>"cod_temporada","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_temporada","TIPO"=>"ENTERO","MIN"=>0,"MENSAJE"=>"El código de la temporada debe ser positivo","DEFECTO"=>0),
					 array("ATRI"=>"cod_dia","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_dia", "TIPO"=>"ENTERO","MIN"=>0,"MENSAJE"=>"El código del dia debe ser positivo","DEFECTO"=>0),
					 array("ATRI"=>"fecha_inicio","TIPO"=>"FECHA"),
					 array("ATRI"=>"fecha_inicio","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"fecha_inicio","TIPO"=>"FUNCTION","FUNCTION"=>"validaFechaInicio"),
					 array("ATRI"=>"fecha_fin","TIPO"=>"FECHA"),
					 array("ATRI"=>"fecha_fin","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"fecha_fin","TIPO"=>"FUNCTION","FUNCTION"=>"validaFechaFin"),
					 array("ATRI"=>"hora_inicio","TIPO"=>"HORA"),
				 	 array("ATRI"=>"hora_inicio","TIPO"=>"REQUERIDO"),
				     array("ATRI"=>"hora_fin","TIPO"=>"HORA"),
				 	 array("ATRI"=>"hora_fin","TIPO"=>"REQUERIDO"));
							
	}

	protected function afterCreate() {
		$this -> cod_horario_general = 0;
		$this -> cod_temporada = 0;
		$this -> cod_dia = 0;
		
		$hora = $fech->format("H:i:s");
		$this->hora_inicio = $hora;
		$this->hora_fin = $hora;
		
		$fech = new DateTime();
		$fecha = $fech->format("d/m/Y");
		$this -> fecha_inicio = $fecha;
		$this -> fecha_fin = $fecha;	
	}
	
	protected function validaFechaInicio(){
		
		$fecha1=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
		
		$fecha2 = new DateTime();
		$fecha2= $fecha2->format("d/m/Y");
		if ($fecha1<$fecha2){
			$this->setError("fecha_inicio","La fecha de inicio debe ser posterior a ");
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
		$cod_temporada=$this->cod_temporada;
		$cod_dia=$this->cod_dia;
		$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
		$fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
		$hora_inicio=CGeneral::addSlashes($this->hora_inicio);
		$hora_fin=CGeneral::addSlashes($this->hora_fin);
		return "insert into horario_general (".
				" cod_temporada, cod_dia, hora_inicio, hora_fin, fecha_inicio, fecha_fin ".
				" ) values ( ".
				" $cod_temporada, $cod_dia, '$hora_inicio', ".
				" '$hora_fin' '$fecha_inicio', '$fecha_fin'".
				" ) " ;
	}
	
	protected function fijarSentenciaUpdate(){
		$cod_temporada=$this->cod_temporada;
		$cod_dia=$this->cod_dia;
				$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
		$fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
		$hora_inicio=CGeneral::addSlashes($this->hora_inicio);
		$hora_fin=CGeneral::addSlashes($this->hora_fin);
		return "update horario_general set ".
				" cod_temporada=$cod_temporada, ".
				" cod_dia=$cod_dia, ".
				" hora_inicio='$hora_inicio', ".
				" hora_fin='$hora_fin', ".
				" fecha_inicio='$fecha_inicio', ".
				" fecha_fin='$fecha_fin' ".
				" where cod_horario_general={$this->cod_horario_general} ";
	}
	
}
