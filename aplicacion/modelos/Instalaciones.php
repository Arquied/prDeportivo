<?php

class Instalaciones extends CActiveRecord {
	
	protected function fijarNombre() {
		return 'insta';
	}
	
	protected function fijarTabla(){
		return "instalaciones";
	}
	
	protected function fijarID(){
		return "cod_instalacion";
	}
	
	protected function fijarAtributos() {
		return array("cod_instalacion", "nombre",
					 "descripcion", "imagen",
					 "capacidad");
	}

	protected function fijarDescripciones() {
		return array("cod_instalacion" => "Codigo instalacion:",
						"nombre"=>"Nombre:",
						"descripcion"=>"Descripcion:",
						"capacidad"=>"Capacidad:");
	}

	protected function fijarRestricciones() {
		Return array(array("ATRI"=>"cod_instalacion",
							"TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_instalacion",
					 		"TIPO"=>"ENTERO",
							"MIN"=>0),
					 array("ATRI"=>"nombre",
					 		"TIPO"=>"CADENA",
							"TAMANIO"=>50),
					 array("ATRI"=>"nombre",
					 		"TIPO"=>"FUNCION",
							"FUNCION"=>"convertirMayuscula"),
					 array("ATRI"=>"descripcion",
					 		"TIPO"=>"CADENA",
							"TAMANIO"=>1000));
							
	}

	protected function afterCreate() {
		$this -> cod_instalacion = 0;
		$this -> nombre = "";
		$this -> descripcion = "";
		$this -> imagen = "";
		$this -> capacidad = 0;
	}

	protected function convertirMayuscula(){

		$cadena=strtoupper($this->nombre);
		$this->nombre=$cadena;		
	}

	protected function fijarSentenciaInsertar(){
		$nombre=CGeneral::addSlashes($this->nombre);
		$descripcion=CGeneral::addSlashes($this->descripcion);
		$imagen = $this->imagen;
		$capacidad=$this->capacidad;
		return "insert into instalacion (".
				" nombre, descripcion, imagen, capacidad ".
				" ) values ( ".
				" '$nombre', '$descripcion', ".
				" '$imagen', '$capacidad' ".
				" ) " ;
	}
	
	protected function fijarSentenciaUpdate(){
		$nombre=CGeneral::addSlashes($this->nombre);
		$descripcion=CGeneral::addSlashes($this->descripcion);
		$imagen = $this->imagen;
		$capacidad=$this->capacidad;
		return "update instalacion set ".
				" nombre='$nombre', ".
				" descripcion='$descripcion',".
				" imagen='$imagen'".
				" capacidad='$capacidad'".
				" where cod_instalacion={$this->cod_instalacion} ";
	}
	
	public static function listaInstalacion($codigo = null){
		
		$instalaciones = new Instalaciones();
		if($codigo == null){
			
			$lista = array();
			foreach($instalaciones->buscarTodos() as $instalcion)
				$lista[$instalacion["cod_instalacion"]] = $instalacion["nombre"];
			
			return $lista;
		}
		
		if($instalaciones->buscarPorId($codigo))
			return $instalaciones->nombre;
			
		return null;
	}
	
}
