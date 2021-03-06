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
			return array("cod_usuario", "nombre", "dni", "correo", "telefono", "direccion", "provincia", "localidad", "nick", "contrasenia", "foto", "fecha_nac", "saldo", "disponible", "web","local", "cod_role");
		}
		
		protected function fijarDescripciones(){
			return array("cod_usuario"=>"Código del usuario",
						"nombre"=>"Nombre y apellidos",
						"dni"=>"DNI",
						"correo"=>"Correo electrónico",
						"telefono"=>"Teléfono",
						"direccion"=>"Dirección",
						"provincia"=>"Provincia",
						"localidad"=>"Localidad",
						"nick"=>"Nick",
						"contrasenia"=>"Contraseña",
						"foto"=>"Foto",
						"fecha_nac"=>"Fecha de nacimiento",
						"saldo"=>"Saldo disponible",
						"disponible"=>"Usuario disponible",
						"web"=>"Usuario con acceso a web",
						"local"=>"Usuario con acceso local",
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
						array("ATRI"=>"foto", "TIPO"=>"FUNCION", "FUNCION"=>"validaImagen"),
						array("ATRI"=>"nick", "TIPO"=>"REQUERIDO"),
						array("ATRI"=>"nick", "TIPO"=>"CADENA", "TAMANIO"=>30, "MENSAJE"=>"El nick no puede ser tan largo"),
						array("ATRI"=>"nick", "TIPO"=>"FUNCION", "FUNCION"=>"nickUnico"),
						array("ATRI"=>"contrasenia", "TIPO"=>"CADENA", "TAMANIO"=>32, "MENSAJE"=>"La contraseña no puede ser tan larga"),
						array("ATRI"=>"fecha_nac", "TIPO"=>"FECHA"),
						array("ATRI"=>"fecha_nac", "TIPO"=>"REQUERIDO", "MENSAJE"=>"La fecha de nacimiento es obligatoria"),
						array("ATRI"=>"saldo", "TIPO"=>"REAL"),
						array("ATRI"=>"disponible", "TIPO"=>"ENTERO", "MAX"=>1, "MIN"=>0),
						array("ATRI"=>"web", "TIPO"=>"ENTERO", "MAX"=>1, "MIN"=>0),
						array("ATRI"=>"local", "TIPO"=>"ENTERO", "MAX"=>1, "MIN"=>0),
						array("ATRI"=>"direccion", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"La dirección no puede ser tan largo"),
						array("ATRI"=>"provincia", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"La provincia no puede ser tan largo"),
						array("ATRI"=>"localidad", "TIPO"=>"CADENA", "TAMANIO"=>50, "MENSAJE"=>"La localidad no puede ser tan largo"),
						);
		}
		
		protected function afterCreate(){
			$this->cod_usuario=1;
			$this->cod_role=0;
			$this->nombre="";
			$this->dni="";
			$this->correo="";
			$this->telefono="";
			$this->foto="";
			$this->nick="";
			$this->contrasenia="";
			$this->fecha_nac="";
			$this->disponible=1;
			$this->web=0;
			$this->local=0;
            $this->saldo=0;
            $this->direccion="";
			$this->provincia="";
			$this->localidad="";
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
            $foto = CGeneral::addSlashes($this->foto);
			$nick=trim(CGeneral::addSlashes($this->nick));
			$contrasenia=substr(trim(CGeneral::addSlashes($this->contrasenia)), 0, 30);
			$fecha_nac=CGeneral::addSlashes(CGeneral::fechaNormalAMysql($this->fecha_nac));
			$disponible=intval($this->disponible);
			$web=intval($this->web);
			$local=intval($this->local);
            $saldo=$this->saldo;
			$direccion=CGeneral::addSlashes($this->direccion);
			$provincia=CGeneral::addSlashes($this->provincia);
			$localidad=CGeneral::addSlashes($this->localidad);
								
			return "insert into usuarios (".
						" nombre, dni, correo, telefono, direccion, provincia, localidad, foto, nick, contrasenia, fecha_nac, saldo, disponible, web, local, cod_role ".
						" ) values ( ".
						" '$nombre', '$dni', '$correo', '$telefono', '$direccion', '$provincia', '$localidad', '$foto', '$nick', md5('$contrasenia'), '$fecha_nac', $saldo, $disponible, $web, $local, $cod_role ".
						" ) " ;
		}
		
        // Funcion modifica el usuario menos la contrasena
		protected function fijarSentenciaUpdate(){
			$cod_role=$this->cod_role;
			$nombre=CGeneral::addSlashes($this->nombre);
			$dni=CGeneral::addSlashes($this->dni);
			$correo=CGeneral::addSlashes($this->correo);
			$telefono=CGeneral::addSlashes($this->telefono);
			$foto = CGeneral::addSlashes($this->foto);
			$nick=CGeneral::addSlashes($this->nick);
			$fecha_nac=CGeneral::addSlashes(CGeneral::fechaNormalAMysql($this->fecha_nac));
			$disponible=intval($this->disponible);
			$web=intval($this->web);
			$local=intval($this->local);
            $saldo=$this->saldo;
            $direccion=CGeneral::addSlashes($this->direccion);
			$provincia=CGeneral::addSlashes($this->provincia);
			$localidad=CGeneral::addSlashes($this->localidad);
			
			return "update usuarios set ".
							" cod_role=$cod_role, ".
							" nombre='$nombre', ".
							" dni='$dni', ".
							" correo='$correo', ".
							" telefono='$telefono', ".
							" direccion='$direccion', ".
							" provincia='$provincia', ".
							" localidad='$localidad', ".
							" foto='$foto', ".
							" nick='$nick', ".
							" fecha_nac='$fecha_nac', ".
							" disponible=$disponible, ".
							" web=$web, ".
							" local=$local, ".
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
		
		public static function listaUsuarios(){            
            $usuarios = new Usuarios();                        
            $lista = array();
            foreach($usuarios->buscarTodos() as $usuario)
                $lista[$usuario["cod_usuario"]] = $usuario["nombre"];
            
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
            $existe=$this->buscarTodos(array("where"=>"nick='".$this->nick."' and cod_usuario<>".$this->cod_usuario));   
            if(count($existe)!=0){
                $this->setError("nick", "Nick ya existe");    
            } 
        }
				
        protected function validaImagen(){
            $cadena=$this->imagen;
            $correcto=preg_match('/\.(gif|jpg|png)$/', $cadena);
            if($correcto===0 || $correcto===false){
                $this->setError("imagen", "La imagen no es correcta");
            }       
        }
		
	}
