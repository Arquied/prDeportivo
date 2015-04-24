<?php



class CAclBD extends CAcl
{
	private $enlaceBD;
	private $hayEnlace;
	
	//Constructor
	function __construct($conexion)
	{
		$this->hayEnlace=false;
		
		if (is_object($conexion))
		{
			$this->hayEnlace=true;
			$this->enlaceBD=$conexion;
		}		
		
	}
	
	private function existeRole($nombre)
	{
		if (!$this->hayEnlace)
		    return false;
		$nombre=str_replace("'", "''", strtoupper($nombre));
		$nombre=substr($nombre, 0,30);
		
		$sentencia="SELECT cod_role ". 
					"	FROM roles ".
    				"	where nombre='$nombre'";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if (!$fila)
		    return false;
		
		return ($fila["cod_role"]);
	}
	
	public function existeCodRole($codrole)
	{
		if (!$this->hayEnlace)
		    return false;
		$codrole=intval($codrole);
		
		$sentencia="SELECT codrol ". 
					"	FROM roles ".
    				"	where codrol=$codrole";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if (!$fila)
		    return false;
		
		return ($fila["codrol"]);
	}
	
	//Metodos
	function anadirRole($nombre,$puedeAcceder,$puedeConfigurar){
		$puedeAcceder= $puedeAcceder?'1':'0';
		$puedeConfigurar=$puedeConfigurar?'1':'0';
					
		if (!$this->hayEnlace)
		   return false;
					
		if ($this->existeRole($nombre))
		   return false;
		
		//todo va bien, inserto el role
		$nombre=str_replace("'", "''", strtoupper($nombre));
		$nombre=substr($nombre, 0,30);
		
		$sentencia="INSERT INTO roles ( ".
        			"		 nombre, puede_acceder, puede_configurar ".
    				"				)VALUES ( ".
        			"		 '$nombre', $puedeAcceder,$puedeConfigurar ".
        			"				)";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;			
		    
		return true;
	}
	
	function getCodRole($nombre){
		if (!$this->hayEnlace)
		   return false;
					
		if ($codRole=$this->existeRole($nombre)===false)
		   return false;
			
		return $codRole;
	}
	
	function anadirUsuario($nombre,$nick,$contrasena,$codRole){
		if (!$this->hayEnlace)
		    return false;
		
		if ($this->existeUsuario($nick))
		  	return false;
		
		$nick=$this->convertirNick($nick);
		$nombre=str_replace("'", "''", $nombre);
		$nombre=substr($nombre, 0,50);
		$contrasena=str_replace("'", "''", $contrasena);
		$contrasena=substr($contrasena, 0,30);
		$codRole=intval($codRole);
		if (!$this->existeCodRole($codRole))
		    return false;
		
		$sentencia="insert into usuarios (".
					"       nombre_apellidos, nick, contrasenia, cod_role".
					"			) values ( ".
					"       '$nombre', '$nick', md5('$contrasena'), $codRole".
					"			)";
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->errno()!=0)
		    return false;
	
		
		return true;						
		
	}



	private function convertirNick($nick){
		$nick=str_replace("'", "''", $nick);
		$nick=substr($nick, 0,30);
		return $nick;
	}
	
	public function existeUsuario($nick){
		if (!$this->hayEnlace)
		    return false;
		$nick=$this->convertirNick($nick);
		
		$sentencia="SELECT nick ". 
					"	FROM usuarios ".
    				"	where nick='$nick'";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if ($fila)
		    return true;
		else 
			return false;
				
	}
	
	function esValido($nick,$contrasena){
		if (!$this->hayEnlace)
		    return false;
		
		if (!$this->existeUsuario($nick))
		  	return false;
		
		$nick=$this->convertirNick($nick);
		$contrasena=str_replace("'", "''", $contrasena);
		$contrasena=substr(trim($contrasena), 0,30);
		 
		$sentencia="SELECT nick ". 
					"	FROM usuarios ".
    				"	where nick='$nick' and ".
					"			md5('$contrasena')=contrasenia";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if ($fila)
		    return true;
		else 
			return false;
		
	}
	
	function getPermisos($nick,&$puedeAcceder,&$puedeAdministrar){
		if (!$this->hayEnlace)
		    return false;
		
		if (!$this->existeUsuario($nick))
		  	return false;
		$nick=$this->convertirNick($nick);
		
		$sentencia="select r.puede_acceder, r.puede_configurar ".
     				"		from usuarios u ".
          			"			join roles r using (cod_role) ".
     				"		where u.nick='$nick'";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if (!$fila)
		    return false;		
		
		$puedeAdministrar=$fila["puede_configurar"];
		$puedeAcceder=$fila["puede_acceder"];
		
			
		return true;
	}
	
	function getNombre($nick){
		if (!$this->hayEnlace)
		    return false;
		
		if (!$this->existeUsuario($nick))
		  	return false;
		
		$nick=$this->convertirNick($nick);
		
		$sentencia="select u.nombre ".
     				"		from usuarios u ".
          			"		where u.nick='$nick'";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		$fila=$consulta->fila();
		if (!$fila)
		    return false;		
		
		return ($fila["nombre_apellidos"]);
		
	}
	
	function setNombre($nick,$nombre){
		if (!$this->hayEnlace)
		    return false;
		
		if (!$this->existeUsuario($nick))
		  	return false;
		
		$nick=$this->convertirNick($nick);
		$nombre=str_replace("'", "''", $nombre);
		$nombre=substr($nombre, 0,50);
		
		
		$sentencia="update usuarios set ".
     				"		nombre_apellidos='$nombre'";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
	
		
		return true;
		
	}
	
	public function dameUsuarios()
	{
		
		$usu=array();
		$sentencia="SELECT us.cod_usuario, us.nombre_apellidos, us.dni, us.email, us.tlf, us.nick, us.fecha_nac ".
					"		r.nombre as nombre_rol ".
					"	FROM usuarios us ".
         			"		join roles r using (cod_role)".
					"	order by nombre_apellidos";
		
		$consulta=$this->enlaceBD->crearConsulta($sentencia);
		if ($consulta->error()!=0)
		    return false;
		
		while ($fila=$consulta->fila())
		{
			$usu[]=array("COD_USUARIO"=>$fila["cod_usuario"],
						 "NOMBRE"=>$fila["nombre_apellidos"],
						 "DNI"=>$fila["dni"],
						 "EMAIL"=>$fila["email"],
						 "TLF"=>$fila["tlf"],
						 "FECHA_NAC"=>$fila["fecha_nac"],
			             "NICK"=>$fila["nick"],
						 "ROLE"=>$fila["nombre_rol"]);
		}
		$consulta->free();
		
		return $usu;
		
		
	}
	
}
