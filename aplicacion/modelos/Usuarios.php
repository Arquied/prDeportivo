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
			return array("cod_usuario", "nombre", "dni", "correo", "telefono", "nick", "contrasenia", "fecha_nac", "saldo", "cod_role");
		}
		
		protected function fijarDescripciones(){
			return array("cod_usuario"=>"Código del usuario",
						"nombre"=>"Nombre y apellidos",
						"dni"=>"DNI",
						"correo"=>"Correo electrónico",
						"telefono"=>"Teléfono",
						"nick"=>"Nick",
						"contrasenia"=>"Contraseña",
						"fecha_nac"=>"Fecha de nacimiento",
						"saldo"=>"Saldo disponible",
						"cod_role"=>"Código del role"
						);
		}
		
		protected function fijarRestricciones(){
			return array(array("ATRI"=>"cod_usuario", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_usuario", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del usuario debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"cod_role", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"cod_role", "TIPO"=>"ENTERO", "MIN"=>0, "MENSAJE"=>"El código del role debe ser positivo", "DEFECTO"=>0),
						array("ATRI"=>"nombre", "TIPO"=>"CADENA", "TAMANIO"=>80, "MENSAJE"=>"El nombre y apellidos no puede ser tan largo"),
						array("ATRI"=>"nombre", "TIPO"=>"FUNCION", "FUNCION"=>"convertirMayuscula"),
						array("ATRI"=>"dni", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El dni no puede ser tan largo"),
						array("ATRI"=>"dni", "TIPO"=>"FUNCION", "FUNCION"=>"comprobarDni"),
						array("ATRI"=>"correo", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"El email no puede ser tan largo"),
						array("ATRI"=>"telefono", "TIPO"=>"CADENA", "TAMANIO"=>9, "MENSAJE"=>"El teléfono no puede ser tan largo"),
						array("ATRI"=>"nick", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"nick", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"El nick no puede ser tan largo"),
						array("ATRI"=>"nick", "TIPO"=>"FUNCION", "FUNCION"=>"nickUnico"),
						array("ATRI"=>"contrasenia", "TIPO"=>"CADENA", "TAMANIO"=>32, "MENSAJE"=>"La contraseña no puede ser tan larga"),
						array("ATRI"=>"fecha_nac", "TIPO"=>"FECHA"),
						array("ATRI"=>"saldo", "TIPO"=>"REAL")
						);
		}
		
		protected function afterCreate(){
			$this->cod_usuario=1;
			$this->cod_role=0;
			$this->nombre="";
			$this->dni="";
			$this->correo="";
			$this->telefono="";
			$this->nick="";
			$this->contrasenia="";
			$this->fecha_nac="";
            $this->saldo=0;
		}	
		
		protected function afterBuscar(){
			$fecha=$this->fecha_nac;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_nac=$fecha;	
		}	
		
		protected function fijarSentenciaInsert(){
			$cod_role=$this->cod_role;
			$nombre=CGeneral::addSlashes($this->nombre);
			$dni=CGeneral::addSlashes($this->dni);
			$correo=CGeneral::addSlashes($this->correo);
			$telefono=CGeneral::addSlashes($this->telefono);
			$nick=trim(CGeneral::addSlashes($this->nick));
			$contrasenia=substr(trim(CGeneral::addSlashes($this->contrasenia)), 0, 30);
			$fecha_nac=CGeneral::addSlashes(CGeneral::fechaNormalAMysql($this->fecha_nac));
            $saldo=$this->saldo;
								
			return "insert into usuarios (".
						" nombre, dni, correo, telefono, nick, contrasenia, fecha_nac, saldo, cod_role ".
						" ) values ( ".
						" '$nombre', '$dni', '$correo', '$telefono', '$nick', md5('$contrasenia'), '$fecha_nac', $saldo, $cod_role ".
						" ) " ;
		}
		
        // Funcion modifica el usuario menos la contrasena
		protected function fijarSentenciaUpdate(){
			$cod_role=$this->cod_role;
			$nombre=CGeneral::addSlashes($this->nombre);
			$dni=CGeneral::addSlashes($this->dni);
			$correo=CGeneral::addSlashes($this->correo);
			$telefono=CGeneral::addSlashes($this->telefono);
			$nick=CGeneral::addSlashes($this->nick);
			$fecha_nac=CGeneral::addSlashes(CGeneral::fechaNormalAMysql($this->fecha_nac));
            $saldo=$this->saldo;
			
			return "update usuarios set ".
							" cod_role=$cod_role, ".
							" nombre='$nombre', ".
							" dni='$dni', ".
							" correo='$correo', ".
							" telefono='$telefono', ".
							" nick='$nick', ".
							" fecha_nac='$fecha_nac', ".
							" saldo=$saldo ".
							" where cod_usuario={$this->cod_usuario} ";																		
		}
		
		public static function listaRoles(){            
            $resultadoSentencia=Sistema::app()->BD()->crearConsulta("select * from roles");
            
            $lista = array();
            foreach($resultadoSentencia->filas() as $role)
                $lista[$role["cod_role"]] = $role["nombre"];
           
            return $lista;
            
        }
        
		
		/**
		 * METODOS PARA VALIDAR CAMPOS
		 */
		protected function convertirMayuscula(){
			$cadena=strtoupper($this->nombre);
			$this->nombre=$cadena;
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
       
        protected function nickUnico(){
            $existe=$this->buscarTodos(array("where"=>"nick='".$this->nick."'"));   
            if(count($existe)!=0){
                $this->setError("nick", "Nick ya existe");    
            } 
        }
				
		
	}
	
