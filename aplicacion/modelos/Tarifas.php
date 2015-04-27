<?php

class Tarifas extends CActiveRecord {
	
	protected function fijarNombre() {
		return 'tarif';
	}
	
	protected function fijarTabla(){
		return "tarifas";
	}
	
	protected function fijarID(){
		return "cod_precio";
	}
	
	protected function fijarAtributos() {
		return array("cod_tarifa", "cod_actividad",
						"cod_tipo_cuota", "precio", "ocupacion");
	}

	protected function fijarDescripciones() {
		return array("cod_tarifa" => "Codigo tarifa:",
						"cod_actividad"=>"Codigo actividad:",
						"cod_tipo_cuota"=>"Tipo de cuota:",
						"precio"=>"Precio:",
						"ocupacion"=>"Ocupacion:");
	}

	protected function fijarRestricciones() {
		Return array(array("ATRI"=>"cod_tarifa","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_tarifa","TIPO"=>"ENTERO","MIN"=>0, "MENSAJE"=>"El código de la tarifa debe ser positivo", "DEFECTO"=>0),
					 array("ATRI"=>"cod_actividad","TIPO"=>"ENTERO","MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
					 array("ATRI"=>"cod_tipo_cuota","TIPO"=>"ENTERO","MIN"=>0, "MENSAJE"=>"El código de tipo_cuota debe ser positivo", "DEFECTO"=>0));
							
	}

	protected function afterCreate() {
		$this -> cod_tarifa = 0;
		$this -> cod_actividad = 0;
		$this -> cod_tipo_cuota = 0;
		$this -> precio = 0;
		$this -> ocupacion = 0;
	}
	
	protected function fijarSentenciaInsert(){
		$cod_actividad = $this->cod_actividad;
		$cod_tipo_cuota = $this->cod_tipo;
		$precio = $this->precio;
		$ocupacion = $this->ocupacion;
		return "insert into tarifas (".
				" cod_actividad, cod_tipo_cuota, precio, ocupacion ".
				" ) values ( ".
				" $cod_actividad, $cod_tipo_cuota, ".
				" $precio, $ocupacion".
				" ) " ;
	}
	
	protected function fijarSentenciaUpdate(){
		$cod_actividad = $this->cod_actividad;
		$cod_tipo_cuota = $this->cod_tipo_cuota;
		$precio = $this->precio;
		$ocupacion = $this->ocupacion;
		return "update tarifas set ".
				" cod_actividad=$cod_actividad, ".
				" cod_tipo_cuota=$cod_tipo_cuota,".
				" precio=$precio, ".
				" ocupacion=$ocupacion ".
				" where cod_tarifa={$this->cod_tarifa} ";
	}
	
}
