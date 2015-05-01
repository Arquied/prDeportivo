<?php

	/**
	 *  CLASE MODELO ACTIVIDADES
	 */
	class Actividades extends CActiveRecord {
				
		protected function fijarNombre(){
			return "actividad";
		}	
		
		public function fijarTabla(){
			return "actividades";
		}
		
		public function fijarId(){
			return "cod_actividad";
		}
			
		protected function fijarAtributos(){
			return array("cod_actividad", "nombre", "mini_descripcion", "descripcion", "imagen", "capacidad", "fecha_inicio", "fecha_fin", "novedad", "disponible", "cod_temporada", "cod_categoria");
		}
		
		protected function fijarDescripciones(){
			return array("cod_actividad"=>"Código de la actividad",
						"nombre"=>"Nombre",
						"mini_descripcion"=>"Descripción corta de la actividad",
						"descripcion"=>"Descripción de la actividad",
						"imagen"=>"Imagen",
						"capacidad"=>"Capacidad",
						"fecha_inicio"=>"Fecha inicio de la actividad",
						"fecha_fin"=>"Fecha fin de la actividad",
						"novedad" => "Es novedad",
						"disponible"=>"Está disponible",
						"cod_temporada"=>"Código de la temporada",
						"cod_categoria" =>"Código de la categoria"
						);
		}
		
		protected function fijarRestricciones(){
			return array(array("ATRI"=>"cod_actividad", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_actividad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la actividad debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_temporada", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_temporada", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la temporada debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_categoria", "TIPO"=>"REQUERIDO"),
                        array("ATRI"=>"cod_categoria", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código de la categoría debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"nombre", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"El nombre no puede ser tan largo"),
						array("ATRI"=>"nombre", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula"),
						array("ATRI"=>"mini_descripcion", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"La mini_descripcion no puede ser tan larga"),                       
						array("ATRI"=>"descripcion", "TIPO"=>"CADENA", "TAMANIO"=>50000, "MENSAJE"=>"La descripcion no puede ser tan larga"),						
						array("ATRI"=>"imagen", "TIPO"=>"FUNCION", "FUNCION"=>"validaImagen"),
						array("ATRI"=>"capacidad", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"La capadicdad debe ser positiva"),
						array("ATRI"=>"fecha_inicio", "TIPO"=>"FECHA"),
						array("ATRI"=>"fecha_fin", "TIPO"=>"FECHA"),
						array("ATRI"=>"novedad", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1),
						array("ATRI"=>"disponible", "TIPO"=>"ENTERO", "MIN"=>0, "MAX"=>1)
						);
		}
		
		protected function afterCreate(){
			$this->cod_actividad=1;
			$this->cod_temporada=0;
			$this->cod_categoria=0;
			$this->nombre="";
			$this->mini_descripcion="";
			$this->descripcion="";
			$this->imagen="";
			$this->capacidad=0;
			$this->fecha_inicio=date("d/m/Y");
			$this->fecha_fin=date("d/m/Y");
			$this->novedad=0;
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
		
		protected function fijarSentenciaInsert(){
			$cod_temporada=$this->cod_temporada;
			$cod_categoria=$this->cod_categoria;
			$nombre=CGeneral::addSlashes($this->nombre);
            $mini_descripcion=CGeneral::addSlashes($this->mini_descripcion);
			$descripcion=CGeneral::addSlashes($this->descripcion);
			$imagen=CGeneral::addSlashes($this->imagen);
			$capacidad=$this->capacidad;
			$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
			$fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            $novedad=intval($this->novedad);
			$disponible=intval($this->disponible);
								
			return "insert into actividades (".
						" nombre, mini_descripcion, descripcion, imagen, capacidad, fecha_inicio, fecha_fin, novedad, disponible, cod_temporada, cod_categoria ".
						" ) values ( ".
						" '$nombre', '$mini_descripcion', '$descripcion', '$imagen', $capacidad, '$fecha_inicio', '$fecha_fin', $novedad, $disponible, $cod_temporada, $cod_categoria ".
						" ) " ;
		}
		
		protected function fijarSentenciaUpdate(){
			$cod_temporada=$this->cod_temporada;
            $cod_categoria=$this->cod_categoria;
			$nombre=CGeneral::addSlashes($this->nombre);
            $mini_descripcion=CGeneral::addSlashes($this->mini_descripcion);
			$descripcion=CGeneral::addSlashes($this->descripcion);
			$imagen=CGeneral::addSlashes($this->imagen);
			$capacidad=$this->capacidad;
			$fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
			$fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
           	$novedad=intval($this->novedad);
			$disponible=intval($this->disponible);
			
			return "update actividades set ".
							" cod_temporada=$cod_temporada, ".
							" cod_categoria=$cod_categoria, ".
							" nombre='$nombre', ".
							" mini_descripcion='$mini_descripcion', ".
							" descripcion='$descripcion', ".
							" imagen='$imagen', ".
							" capacidad=$capacidad, ".
							" fecha_inicio='$fecha_inicio', ".
							" fecha_fin='$fecha_fin', ".
							" novedad=$novedad, ".
							" disponible=$disponible ".
							" where cod_actividad={$this->cod_actividad} ";																		
		}
		
		public static function listaActividades($codigo=null){            
            $actividades = new Actividades();
            if ($codigo == null) {
                        
                $lista = array();
                foreach($actividades->buscarTodos() as $actividad)
                    $lista[$actividad["cod_actividad"]] = $actividad["nombre"];
                
                return $lista;
            }
            
            if ($actividades->buscarPorId($codigo))
            return $actividades->nombre;
            
            return null;
            
        }
		
		/**
		 * METODOS PARA VALIDAR CAMPOS
		 */
		protected function convertirMayuscula(){
			$cadena=strtoupper($this->nombre);
			$this->nombre=$cadena;
		}
		
		protected function validaImagen(){
			$cadena=$this->imagen;
			if($cadena!=""){
				$correcto=preg_match('/\.(gif|jpg|png)$/', $cadena);
				if($correcto===0 || $correcto===false){
					$this->setError("imagen", "La imagen no es correcta");
				}	
			}	
		}
				
		
	}
	
