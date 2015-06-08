<?php
	echo CHTML::dibujaEtiqueta("div");

	
		echo CHTML::dibujaEtiqueta("table",array( "class"=>"calendario "));
	
		echo CHTML::dibujaEtiqueta("tr");
		
			echo CHTML::dibujaEtiqueta("th",array(),"LUNES");
			echo CHTML::dibujaEtiqueta("th",array(),"MARTES");
			echo CHTML::dibujaEtiqueta("th",array(),"MIERCOLES");
			echo CHTML::dibujaEtiqueta("th",array(),"JUEVES");
			echo CHTML::dibujaEtiqueta("th",array(),"VIERNES");
			echo CHTML::dibujaEtiqueta("th",array(),"SABADO");
			echo CHTML::dibujaEtiqueta("th",array(),"DOMINGO");
		
		echo CHTML::dibujaEtiquetaCierre("tr");
		
		for ($i=0;$i<count($horario);$i++){
			echo CHTML::dibujaEtiqueta("tr");
			
		for ($cont=1;$cont<=7;$cont++){
			
			if (empty($filas[$cont])){
				echo CHTML::dibujaEtiqueta("td",array(),"",true);
			}
			else {
				if (empty($filas[$cont][$horario[$i]["hora_inicio"]])){
					echo CHTML::dibujaEtiqueta("td",array(),"",true);
				}
				else {
					echo CHTML::dibujaEtiqueta("td", array());
					foreach ($filas[$cont][$horario[$i]["hora_inicio"]] as $fila){
						if ($fila["actividad"] != "LIBRE"){
							 $informacion =  $fila["actividad"]."<br>".
						 				  $fila["hora_inicio"]." - ".
						 				  $fila["hora_fin"]."<br>".
									      $fila["descripcion"];
						echo CHTML::dibujaEtiqueta("a",array("href"=>Sistema::app()->generaURL(array('reservas', 'nuevaReserva'), array("cod_actividad"=>$fila["cod_actividad"]))),$informacion);
						echo CHTML::dibujaEtiqueta("br");
						}
						
					}
			   		echo CHTML::dibujaEtiquetaCierre("td");
					
				}
			}
			
		}	
		echo CHTML::dibujaEtiquetaCierre("tr");		
		}


		echo CHTML::dibujaEtiquetaCierre("table");
	
	echo CHTML::dibujaEtiquetaCierre("div");
