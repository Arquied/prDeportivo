<!DOCTYPE html>
<html>
	<head>
		  <meta charset="utf-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1">
		    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		    <meta name="description" content="">
		    <meta name="author" content="">
				<title><?php echo $titulo;?></title>
				<!-- definiciones comunes a todo el sitio -->
				<link type="text/css" href="/estilos/bootstrap.min.css" rel="stylesheet" />
				<link type="text/css" href="/estilos/carousel.css" rel="stylesheet" />
				<link type="text/css" href="/estilos/principal.css" rel="stylesheet"/>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script src="script/bootstrap.min.js"></script>
			</head>
			<body>
			    <div>	
    		        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    		          <div>
    		            <div class="navbar-header">
    		              <a class="navbar-brand" href="<?php Sistema::app()->generaURL(array("inicial")) ?>">Centro Deportivo</a>
    		            </div>
    		            <?php
    		            //Comprobar si se ha iniciado el usuario y si tienen permiso de administrar se mostrar el menu de administracion
    		            $nologeado = true;
    					$esAdmin=false;
    					$logeado=false;
    					if (Sistema::app()->Acceso()->hayUsuario()){
    						$nologeado=false;
    						$logeado=true;
    					}
    					else {
    						$nologeado=true;
    						$logeado=false;	
    					}
    					if(Sistema::app()->Acceso()->puedeConfigurar()){
    						$esAdmin=true;
    					}
    					else {
    						$esAdmin=false;	
    					}
    		            $quien = array("TEXTO"=>"Quienes Somos","URL"=>Sistema::app()->generaURL(array("inicial","quien")),"SUBMENU"=>false,"ACTIVO"=>true,"ITEMS"=>array());
    					$registra = array("TEXTO"=>"Registrate","URL"=>Sistema::app()->generaURL(array("usuarios","registro")),"SUBMENU"=>false,"ACTIVO"=>$nologeado,"ITEMS"=>array());
    		            $login = array("TEXTO"=>"Login","URL"=>Sistema::app()->generaURL(array("inicial","login")),"SUBMENU"=>false,"ACTIVO"=>$nologeado,"ITEMS"=>array());
    					$logout = array("TEXTO"=>"Logout","URL"=>Sistema::app()->generaURL(array("inicial","cerrarSesion")),"SUBMENU"=>false,"ACTIVO"=>$logeado,"ITEMS"=>array());
    					$perfil = array("TEXTO"=>"Mi Perfil","URL"=>Sistema::app()->generaURL(array("usuarios", "miPerfil")),"SUBMENU"=>false,"ACTIVO"=>$logeado,"ITEMS"=>array());
    					$instalaciones = array("TEXTO"=>"Instalaciones","URL"=>Sistema::app()->generaURL(array("instalaciones")),"SUBMENU"=>false,"ACTIVO"=>true,"ITEMS"=>array());
    					$usuarios = array("TEXTO"=>"Usuarios","URL"=>Sistema::app()->generaURL(array()),"SUBMENU"=>false,"ACTIVO","ITEMS"=>array());
						$temporadas = array("TEXTO"=>"Temporadas","URL"=>Sistema::app()->generaURL(array("temporadas")),"SUBMENU"=>false,"ACTIVO","ITEMS"=>array());
						$cuotas = array("TEXTO"=>"Cuotas","URL"=>Sistema::app()->generaURL(array("cuotas")),"SUBMENU"=>false,"ACTIVO","ITEMS"=>array());
						$horarios = array("TEXTO"=>"Horarios","URL"=>Sistema::app()->generaURL(array("horarios")),"SUBMENU"=>false,"ACTIVO","ITEMS"=>array());
						$actividades = array("TEXTO"=>"Actividades","URL"=>Sistema::app()->generaURL(array("actividades","listaActividades")),"SUBMENU"=>false,"ACTIVO","ITEMS"=>array());
    					$administrar = array("TEXTO"=>"Administrar","URL"=>"","SUBMENU"=>true,"ACTIVO"=>true,"ITEMS"=>array($actividades,$cuotas,$horarios,$instalaciones,$temporadas,$usuarios));
    		            $datos = array($quien,$registra,$login,$logout,$perfil,$administrar);
    		            $cbarra = new CBarraMenu($datos);
    					$cbarra->dibujate();
    		           ?>
    		          </div>
    		        </nav>				
    				<div id="conte" role="main" class="theme-showcase">					
    					<?php 
    					   echo $contenido; 		
    					?>
    				</div>
				</div>  
					
					
			</body>
</html>
