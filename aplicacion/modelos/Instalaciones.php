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
		Return array(array("ATRI"=>"cod_instalacion","TIPO"=>"REQUERIDO"),
					 array("ATRI"=>"cod_instalacion","TIPO"=>"ENTERO","MIN"=>0,"MENSAJE"=>"El código de la instalación debe ser positivo","DEFECTO"=>0),
					 array("ATRI"=>"nombre","TIPO"=>"CADENA","TAMANIO"=>50,"MENSAJE"=>"El tamaño maximo debe ser 50"),                       
					 array("ATRI"=>"descripcion", "TIPO"=>"CADENA", "TAMANIO"=>50000, "MENSAJE"=>"La descripcion no puede ser tan larga"),
					 array("ATRI"=>"nombre","TIPO"=>"FUNCION","FUNCION"=>"convertirMayuscula"),
					 array("ATRI"=>"imagen", "TIPO"=>"FUNCION", "FUNCION"=>"validaImagen"));
							
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
	
	protected function validaImagen(){
		$cadena=$this->imagen;
		$correcto=preg_match('/\.(gif|jpg|png)$/', $cadena);
		if($correcto===0 || $correcto===false){
			$this->setError("imagen", "La imagen no es correcta");
		}		
	}

	protected function fijarSentenciaInsert(){
		$nombre=CGeneral::addSlashes($this->nombre);
		$descripcion=CGeneral::addSlashes($this->descripcion);
		$imagen = CGeneral::addSlashes($this->imagen);
		$capacidad=$this->capacidad;
		return "insert into instalaciones (".
				" nombre, descripcion, imagen, capacidad ".
				" ) values ( ".
				" '$nombre', '$descripcion', ".
				" '$imagen', $capacidad ".
				" ) " ;
	}
	
	protected function fijarSentenciaUpdate(){
		$nombre=CGeneral::addSlashes($this->nombre);
		$descripcion=CGeneral::addSlashes($this->descripcion);
		$imagen = $this->imagen;
		$capacidad=$this->capacidad;
		return "update instalaciones set ".
				" nombre='$nombre', ".
				" descripcion='$descripcion',".
				" imagen='$imagen'".
				" capacidad=$capacidad".
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
