<?php

    /*
     * CLASE MODELO INSTALACIONES
     */
    class Instalaciones extends CActiveRecord {
        
        protected function fijarNombre() {
            return 'instalacion';
        }
        
        protected function fijarTabla(){
            return "instalaciones";
        }
        
        protected function fijarId(){
            return "cod_instalacion";
        }
        
        protected function fijarAtributos() {
            return array("cod_instalacion", "nombre",
                         "descripcion", "imagen",
                         "capacidad","disponible");
        }
        
        protected function fijarDescripciones() {
            return array("cod_instalacion" => "Codigo instalacion:",
                            "nombre"=>"Nombre:",
                            "descripcion"=>"Descripcion:",
                            "imagen"=>"Imagen de la instalación:",
                            "capacidad"=>"Capacidad:",
							"disponible"=>"Está disponible");
        }
        
		protected function fijarRestricciones(){
			return array(array("ATRI"=>"cod_instalacion", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_instalacion", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"nombre", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"El nombre no puede ser tan largo"),
						array("ATRI"=>"nombre", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula"),                       
						array("ATRI"=>"descripcion", "TIPO"=>"CADENA", "TAMANIO"=>50000, "MENSAJE"=>"La descripcion no puede ser tan larga"),
						array("ATRI"=>"capacidad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"La capadicdad debe ser positiva"),
						array("ATRI"=>"disponible", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1)
			);
		}
        
        protected function afterCreate() {
            $this -> cod_instalacion = 1;
            $this -> nombre = "";
            $this -> descripcion = "";
            $this -> imagen = "";
            $this -> capacidad = 0;
			$this -> disponible = 1;
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
            $nombre = CGeneral::addSlashes($this->nombre);
            $descripcion = CGeneral::addSlashes($this->descripcion);
            $imagen = CGeneral::addSlashes($this->imagen);
            $capacidad = $this->capacidad;
			$disponible=intval($this->disponible);
            return "insert into instalaciones (".
                    " nombre, descripcion, imagen, capacidad, disponible ".
                    " ) values ( ".
                    " '$nombre', '$descripcion', ".
                    " '$imagen', $capacidad, $disponible ".
                    " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre = CGeneral::addSlashes($this->nombre);
            $descripcion = CGeneral::addSlashes($this->descripcion);
            $imagen = CGeneral::addSlashes($this->imagen);
            $capacidad = $this->capacidad;
            $disponible = intval($this->disponible);
            
            return "update instalaciones set ".
                    " nombre='$nombre', ".
                    " descripcion='$descripcion', ".
                    " imagen='$imagen', ".
                    " capacidad=$capacidad, ".
                    " disponible=$disponible ".
                    " where cod_instalacion={$this->cod_instalacion} ";
        }
        
        public static function listaInstalacion($codigo = null){        
            $instalaciones = new Instalaciones();
            if($codigo == null){
                
                $lista = array();
                foreach($instalaciones->buscarTodos() as $instalacion)
                    $lista[$instalacion["cod_instalacion"]] = $instalacion["nombre"];
                
                return $lista;
            }
            
            if($instalaciones->buscarPorId($codigo))
                return $instalaciones->nombre;
                
            return null;
        }
        
    }
