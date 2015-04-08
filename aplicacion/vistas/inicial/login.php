<?php
	echo CHTML::cssFichero("/estilos/estiloFormularios.css");


	echo CHTML::dibujaEtiqueta("div", array("class"=>"container"));
		echo CHTML::iniciarForm("", "post", array("class"=>"form-signin"));
			echo CHTML::dibujaEtiqueta("h2", array("class"=>"form-signin-heading"), "Inicie sesión", true);
			echo CHTML::campoLabel("Usuario", "inputUsuario", array("class"=>"sr-only"));
			echo CHTML::campoText("inputUsuario", "", array("id"=>"inputUsuario", "class"=>"form-control", "maxlenght"=>30, "autofocus"=>"autofocus", "placeholder"=>"Usuario"));
			
			echo CHTML::campoLabel("Contraseña", "inputContrasena", array("class"=>"sr-only"));
			echo CHTML::campoPassword("inputContrasena", "", array("id"=>"inputContrasena", "class"=>"form-control", "maxlenght"=>30, "placeholder"=>"Contraseña"));
			
			echo CHTML::campoBotonSubmit("Acceder", array("class"=>"btn btn-log btn-default btn-block"));			
			
		echo CHTML::finalizarForm();
	echo CHTML::dibujaEtiquetaCierre("div");
	
