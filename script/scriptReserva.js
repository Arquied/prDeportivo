$(document).ready(function() {
	if($_GET("cod_actividad")){
		obtenerActividad($_GET("cod_actividad"));
	}
	
	//EVENTO CHANGE PARA LAS ACTIVIDADES, CARGA INFORMACION DE LA ACTIVIDAD Y 
	//HABILITA EL BOTON SIGUIENTE
	$("#contNuevaReserva #reserva_cod_actividad").on("change", function(){
		var cod_actividad=$(this).val();
		if(cod_actividad!=""){ //Carga informacion y habilita boton
			$("#reserva2paso").attr("disabled", false);
			obtenerActividad(cod_actividad);
		}
		else{ //Borra informacion y deshabilita boton
			$("#reserva2paso").attr("disabled", true);
			$("#contInformacionAct").slideUp();
		}
	});
	
	//EVENTO ONCLICK PARA EL BOTON 2PASO, MUESTRA EL HORARIO PARA LA ACTIVIDAD SELECCIONADA
	//MUESTRA OPCIONES SEGUN TIPO DE RESERVA SELECCIONADA
	$("#reserva2paso").on("click", function(){
		$("#tituloPaso").html("<em>Paso 2 - Seleccionar fechas de reserva</em>");
		var tipoReserva=$("input[name=tipo_reserva]").val();
		//console.log(tipoReserva);
		var cod_actividad=$("input [name=cod_actividad]").val();
		$("#camposForm").empty();
		if(tipoReserva=="periodo"){
			$("#camposForm").append($("<div class='form-group'>"+
										"<label for='fecha_inicio'>Fecha de inicio</label>"+
										"<input type='text' name='fecha_inicio' class='form-control fecha' />"+
									"</div>"+
									"<div class='form-group'>"+
										"<label for='fecha_fin'>Fecha de fin</label>"+
										"<input type='text' name='fecha_fin' class='form-control fecha' />"+
									"</div>"+
									"<div class='form-group'>"+
										"<label for='finTemporada'>"+
										"<input type='checkbox' name='finTemporada'/>"+
										"Reservar hasta fin de temporada</label>"+
									"</div>"));
			$(this).attr("id", "reserva3paso");
			$("#reserva3paso").attr("disabled", true);
		}
		
	});
	
	
	//EVENTO CHANGE PARA LAS ACTIVIDADES, RELLENA EL COMBO CON LAS POSIBLES TARIFAS
	/*$("#formReserva #reserva_cod_actividad").on("change", function(){
		var cod_actividad=$(this).val();
		$.ajax({
			url: "index.php?co=reservas&ac=devuelveTarifas",
			data: { cod_actividad: cod_actividad},
			type: "post",
			dataType: 'json',
			success: function(json){
				cargaComboTarifas(json);
			}
		});
	});*/
});

/** FUNCION PETICION AJAX PARA OBTENER ACTIVIDAD **/
function obtenerActividad(cod_actividad){
	$.ajax({
		url: "index.php?co=actividades&ac=actividadJSON",
		data: { cod_actividad: cod_actividad},
		type: "post",
		dataType: 'json',
		success: function(json){
			//console.log(json);
			muestraActividadSeleccionada(json);
			obtenerHorario(cod_actividad);
		}
	});	
}

/** FUNCION PETICION AJAX OBTIENE EL HORARIO SEMANAL DE UNA DETERMINADA ACTIVIDAD **/
function obtenerHorario(cod_actividad){
	$.ajax({
		url: "index.php?co=calendarios&ac=calendarioActividad",
		data: { cod_actividad: cod_actividad},
		type: "post",
		dataType: 'json',
		success: function(json){
			console.log(json);
			muestraHorarioActividad(json);			
		}
	});	
}

/** FUNCION MUESTRA LA INFORMACION DE LA ACTIVIDAD SELECCIONADA **/
		//Parametro: objeto json datos actividad
function muestraActividadSeleccionada(actividad){
	var $divContInfo=$("#contInformacionAct");
	
	if(actividad!=0){
		//console.log(actividad[0]["nombre"]);
		//Nombre actividad
		$("#nombreActividad").html(actividad[0]["nombre"]);
		
		//Descripcion
		$("#descripcion").html(actividad[0]["descripcion"]);
		
		//Imagen
		if(actividad[0]["imagen"]=="")
			$(".imagen img").attr("src", "../../imagenes/Imagen_no_disponible.svg.png");
		else
			$(".imagen img").attr("src", "../../imagenes/actividades/"+actividad[0]["imagen"]);
			
	}
	$("#contInformacionAct").slideDown();
}

/** FUNCION QUE MUESTRA EL HORARIO DE UNA DETERMINADA ACTIVIDAD **/
function muestraHorarioActividad(calendario){
	var $divContHorario=$("#contHorario");
	$divContHorario.empty();
	if(calendario.length>0){
		var $tabla=$("<table></table>");
		console.log(calendario);
		//Cabecera
		var $thead=$("<thead></thead>");
		var $cabecera=$("<tr></tr>");
		$cabecera.append($("<th>LUNES</th>"))
				.append($("<th>MARTES</th>"))
				.append($("<th>MIERCOLES</th>"))
				.append($("<th>JUEVES</th>"))
				.append($("<th>VIERNES</th>"))
				.append($("<th>SÁBADO</th>"))
				.append($("<th>DOMINGO</th>"));
		$thead.append($cabecera);
		$tabla.append($thead);
		
		//Cuerpo
		var $cuerpo=$("<tbody></tbody>");
		var $tr=$("<tr></tr>");
		for(cont=1; cont<=7; cont++){
			var $td=$("<td></td>");
			for(dia in calendario){	
				if(cont==calendario[dia]["cod_dia"]){
					$td.append("<p>"+calendario[dia]["hora_inicio"]+"-"+calendario[dia]["hora_fin"]+"</p>");
				}		
			}
			$tr.append($td);	
		}
		$cuerpo.append($tr);
		$tabla.append($cuerpo);
		
		$divContHorario.append($tabla);
	}
}


/** FUNCION PARA CARGAR EL COMBO DE LAS TARIFAS CORRESPONDIENTES A UNA ACTIVIDAD **/
function cargaComboTarifas(json){
	$("#contTarifa").remove();
	var $comboTarifa=$("<select></select>", 
						{"class":"form-control",
							name: "tarifas",
							id: "tarifas"
						});
	$("<option value=''>Seleccione una opción</option>").appendTo($comboTarifa);					
	for(tarifa in json){
		$("<option value='"+json[tarifa]["cod_tarifa"]+"_"+json[tarifa]["tipo"]+"'>"+json[tarifa]["tipo"]+"</option>").appendTo($comboTarifa);
	}
	var $div=$("<div></div>", {"class":"form-group", id: "contTarifa"}).append($("<label for='tarifas'>Tarifa</label>"))
													 .append($comboTarifa);
	$div.insertAfter($("#reserva_cod_actividad").parent());
	
	//EVENTO CHANGE PARA EL COMBO TARIFAS SEGÚN MARQUE REALIZA UNA COSA U OTRA
	$("#formReserva #tarifas").on("change", function(){
		//if($(this).val())
	});								
									

}
