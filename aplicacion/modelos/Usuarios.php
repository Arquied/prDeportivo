<?php

	/**
	 *  CLASE MODELO USUARIOS
	 */
	class Usuarios extends CActiveRecord {
				
		protected function fijarNombre(){
			return "usuario";
		}	
		
		public function fijarTabla(){
			return "usuarios";
		}
		
		public function fijarId(){
			return "cod_usuario";
		}
			
		protected function fijarAtributos(){
			return array("cod_usuario", "nombre_apellidos", "dni", "email", "tlf", "nick", "contrasenia", "fecha_nac", "cod_role");
		}
		
		protected function fijarDescripciones(){
			return array("cod_usuario"=>"Código del usuario",
						"nombre_apellidos"=>"Nombre y apellidos",
						"dni"=>"DNI",
						"email"=>"Correo electrónico",
						"tlf"=>"Teléfono",
						"nick"=>"Nick",
						"contrasenia"=>"Contraseña",
						"fecha_nac"=>"Fecha de nacimiento",
						"cod_role"=>"Código del role"
						);
		}
		
		protected function fijarRestricciones(){
			return array(array("ATRI"=>"cod_usuario", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_usuario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del usuario debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_role", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_role", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del role debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"nombre_apellidos", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"El nombre y apellidos no puede ser tan largo"),
						array("ATRI"=>"nombre_apellidos", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula"),
						array("ATRI"=>"dni", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El dni no puede ser tan largo"),
						array("ATRI"=>"dni", "TIPO"=>"FUNCION", "FUNCION"=>"comprobarDni"),
						array("ATRI"=>"email", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"El email no puede ser tan largo"),
						array("ATRI"=>"tlf", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El teléfono no puede ser tan largo"),
						array("ATRI"=>"nick", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"nick", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"El nick no puede ser tan largo"),
						array("ATRI"=>"contrasenia", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"La contraseña no puede ser tan larga"),
						array("ATRI"=>"fecha_nac", "TIPO"=>"CADENA", "TAMANIO"=>10)
						);
		}
		
		protected function afterCreate(){
			$this->cod_usuario=1;
			$this->cod_role=0;
			$this->nombre_apellidos="";
			$this->dni="";
			$this->email="";
			$this->tlf="";
			$this->nick="";
			$this->contrasenia="";
			$this->fecha_nac="";
		}	
		
		protected function afterBuscar(){
				
		}	
		
		protected function fijarSentenciaInsert(){
			$cod_role=$this->cod_role;
			$nombre_apellidos=CGeneral::addSlashes($this->nombre_apellidos);
			$dni=CGeneral::addSlashes($this->dni);
			$email=CGeneral::addSlashes($this->email);
			$tlf=CGeneral::addSlashes($this->tlf);
			$nick=trim(CGeneral::addSlashes($this->nick));
			$contrasenia=substr(trim(CGeneral::addSlashes($this->contrasenia)), 0, 30);
			$fecha_nac=CGeneral::addSlashes($this->fecha_nac);
								
			return "insert into usuarios (".
						" nombre_apellidos, dni, email, tlf, nick, contrasenia, fecha_nac, cod_role ".
						" ) values ( ".
						" '$nombre_apellidos', '$dni', '$email', '$tlf', '$nick', md5('$contrasenia'), '$fecha_nac', $cod_role ".
						" ) " ;
		}
		
		protected function fijarSentenciaUpdate(){
			$cod_role=$this->cod_role;
			$nombre_apellidos=CGeneral::addSlashes($this->nombre_apellidos);
			$dni=CGeneral::addSlashes($this->dni);
			$email=CGeneral::addSlashes($this->email);
			$tlf=CGeneral::addSlashes($this->tlf);
			$nick=CGeneral::addSlashes($this->nick);
			$contrasenia=CGeneral::addSlashes($this->contrasenia);
			$fecha_nac=CGeneral::addSlashes($this->fecha_nac);
			
			return "update usuarios set ".
							" cod_role=$cod_role, ".
							" nombre_apellidos='$nombre_apellidos', ".
							" dni='$dni', ".
							" email='$email', ".
							" tlf='$tlf', ".
							" nick='$nick', ".
							" contrasenia=md5('$contrasenia'), ".
							" fecha_nac='$fecha_nac' ".
							" where cod_usuario={$this->cod_usuario} ";																		
		}
		
		/**
		 * METODOS PARA VALIDAR CAMPOS
		 */
		protected function convertirMayuscula(){
			$cadena=strtoupper($this->titulo);
			$this->titulo=$cadena;
		}
		
		protected function comprobarDni(){
			$dni=$this->dni;
            if (strlen($dni) != 9 || preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $dni, $matches) !== 1) {
                return false;
            }     
            $map = 'TRWAGMYFPDXBNJZSQVHLCKE';
    
            list(, $number, $letter) = $matches;
    
            if(!strtoupper($letter) === $map[((int) $number) % 23]){
            	$this->setError("dni", "DNI incorrecto");
            } 
       }
				
		
	}
	
