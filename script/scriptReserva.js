var actividad; var reservas=new Array(); var tarifa;
var fecha=new Date();
$(document).ready(function() {
	if($_GET("cod_actividad")){
		obtenerActividad($_GET("cod_actividad"));
	}
	
	//EVENTO CHANGE PARA LAS ACTIVIDADES, CARGA INFORMACION DE LA ACTIVIDAD Y 
	//HABILITA EL BOTON SIGUIENTE
	$("#contNuevaReserva #reserva_cod_actividad").on("change", function(){
		var cod_actividad=$(this).val();
		if(cod_actividad!=""){ //Carga informacion
			obtenerActividad(cod_actividad);
		}
		else{ //Borra informacion y deshabilita boton
			$("#reserva2paso").attr("disabled", true);
			$("#contFechaHorario").remove();
			$("#contInformacionAct").slideUp();
		}
	});
	
	//EVENTO ONCLICK PARA EL BOTON 2PASO,
		//Si seleccionable_horas=0 ---- muestra fecha_inicio y fecha fin para poder marcar la reserva
		//Si seleccionable_horas=1 ---- muestra fecha_inicio y fecha fin ya marcado (informar)
		//Y muestra el tipo de tarifas a seleccionar
	$("#reserva2paso").on("click", function(){
		$("#tituloPaso").html("<em>Paso 2 - Fechas de reserva y tarifa</em>");
		$("#camposForm").empty();
		//Cambiar boton a informacion reserva
		$("#contBtn").html("<input type='button' class='btn btn-default' id='reserva3paso' value='Siguiente'>");
		//Si seleccionable_horas=1 --- obtener los p con reserva
		if(actividad["seleccionable_horas"]==1){						
			$("p.reserva").each(function(ind, elem){
				reservas.push({"cod_calendario" : $(elem).data("cod_calendario"),
								"fecha_inicio" : $(elem).data("fecha"),
								"fecha_fin" : $(elem).data("fecha"),
								"horario" : $(elem).html()
							});
				$("#camposForm").append($("<div>"+
											"<div class='form-group'>"+
												"<label for='fecha_inicio'>Fecha de inicio</label>"+
												"<input type='text' name='fecha_inicio' class='form-control' readonly=true value='"+$(elem).data("fecha")+"'/>"+
											"</div>"+
											"<div class='form-group'>"+
												"<label for='fecha_fin'>Fecha de fin</label>"+
												"<input type='text' name='fecha_fin' class='form-control' readonly=true value='"+$(elem).data("fecha")+"'/>"+
											"</div>"+
											"<div class='form-group'>"+
												"<label for='hora'>Hora</label>"+
												"<input type='text' name='hora' class='form-control' readonly=true value='"+$(elem).html()+"'/>"+
											"</div>"+
										"</div>"
										));
			});	
		}
		//Si seleccionable_horas=0 --- Muestra campos fecha_inicio, fecha_fin, reserva hasta fin temporada,
		else{
			$("#camposForm").append($("<div class='form-group'>"+
									"<label for='fecha_inicio'>Fecha de inicio</label>"+
									"<input type='text' name='fecha_inicio' class='form-control fecha' />"+
									"</div>"+
									"<div class='form-group'>"+
										"<label for='fecha_fin'>Fecha de fin</label>"+
										"<input type='text' name='fecha_fin' class='form-control fecha' id='fin' />"+
									"</div>"+
									"<div class='form-group'>"+
										"<label for='finTemporada'>"+
										"<input type='checkbox' name='finTemporada'/>"+
										"Reservar hasta fin de temporada</label>"+
									"</div>"	
									));
			$("input[name=fecha_inicio]").datetimepicker({
										  format:'d/m/Y',
										  lang:'es',
										  timepicker:false,
										  dayOfWeekStart: 1,
										  scrollInput: false,
										  scrollMonth: false,
										  scrollTime: false,
										 // minDate: fecha.getDate()+"/"+fecha.getMonth()+1+"/"+fecha.getFullYear(),
										  onSelect: function(dateText, inst){
											  console.log("seleccionado");
											  $("input[name=fecha_fin]").datetimepicker('option', 'minDate', dateText);
										  }
										});
			$("input[name=fecha_fin]").datetimepicker({
										  format:'d/m/Y',
										  lang:'es',
										  timepicker:false,
										  dayOfWeekStart: 1,
										  scrollInput: false,
										  scrollMonth: false,
										  scrollTime: false,
										 // minDate: fecha.getDate()+"/"+fecha.getMonth()+1+"/"+fecha.getFullYear(),
										  onSelect: function(dateText, inst){
											  $("input[name=fecha_inicio]").datetimepicker('option', 'maxDate', dateText);
										  }										  
										});	
										
			/*$("input[name=fecha_inicio]").on("change", function(){
				var $this=$(this);
				if($this.attr("name")=="fecha_inicio"){	
					console.log($this.val());
					$("input[name=fecha_fin]").datetimepicker("option", "minDate", new Date($this.val()));
					$("input[name=fecha_fin]").val($this.val());	
					
			
				}
			});*/
			
			//Evento change para reserva hasta fin de temporada, deshabilita el campo fecha fin
			$("input[name=finTemporada]").on("change", eventFinTemporada);	
		}
		//Cargar tarifa
		muestraTarifa();
		//Borrar horario
		$("#contHorario").remove();
		
		//Evento para habilitar el boton 3paso cuando la reserva es normal
		$("#reserva3paso").on("click", function(){
			if(comprobarReserva()){
				informacionReserva();
			}
		});					
	});	
});

/** FUNCION PETICION AJAX PARA OBTENER ACTIVIDAD **/
function obtenerActividad(cod_actividad){
	$.ajax({
		url: "index.php?co=actividades&ac=actividadJSON",
		data: { cod_actividad: cod_actividad},
		type: "post",
		dataType: 'json',
		success: function(json){
			if(json.length>0){
				actividad=json[0];
				muestraActividadSeleccionada(json);				
				if(json[0]["seleccionable_horas"]==0){
					obtenerHorario(cod_actividad);
				}
			}	
		}
	});	
}

/** FUNCION PETICION AJAX OBTIENE EL HORARIO SEMANAL DE UNA DETERMINADA ACTIVIDAD **/
function obtenerHorario(cod_actividad){
	fechaSenalada = (fecha.getMonth()+1)+"/"+fecha.getDate()+"/"+fecha.getFullYear();
	//console.log(fechaSenalada);
	$.ajax({
		url: "index.php?co=calendarios&ac=calendarioActividad",
		data: { cod_actividad: cod_actividad, fechaSenalada: fechaSenalada},
		type: "post",
		dataType: 'json',
		success: function(json){
			muestraHorarioActividad(json);			
		}
	});	
}

/** FUNCION MUESTRA LA INFORMACION DE LA ACTIVIDAD SELECCIONADA **/
		//Parametro: objeto json datos actividad
function muestraActividadSeleccionada(actividad){
	var $divContInfo=$("#contInformacionAct");
	$("#camposForm").find($("input[name='fechaHorario']")).parent().remove();
	$("#contHorario").empty();	
	$("#reserva2paso").attr("disabled", true);
	if(actividad!=0){
		//Añadir campo para seleccionar semana		
		if(actividad[0]["seleccionable_horas"]==1){
			$("#camposForm").append($("<div class='form-group' id='contFechaHorario'></div>")
												.append($("<label for='fechaHorario'>Seleccione semana</label>"))
												.append($("<input type='text' name='fechaHorario' class='form-control' style='display: block !important'/>"))		
									);
			$("input[name='fechaHorario']").datetimepicker({
												  format:'d/m/Y',
												  inline:true,
												  lang:'es',
												  timepicker:false,
												  dayOfWeekStart: 1,
												  scrollInput: false,
												  scrollMonth: false,
											      scrollTime: false,
												  minDate: fecha.getDate()+"/"+fecha.getMonth()+1+"/"+fecha.getFullYear()
												});
			//Evento change sobre el campo fecha horario, realiza la peticion ajax devolviendo el horario de la semana señalada
			$("input[name='fechaHorario']").on("change", function(){
				arrayFecha=$(this).val().split("/");
				fecha=new Date(arrayFecha[2]+"-"+arrayFecha[1]+"-"+arrayFecha[0]);	
				obtenerHorario(actividad[0]["cod_actividad"]);
			});
		}
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
		var $tabla=$("<table id='tHorarioAct'></table>");
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
		$thead.append($cabecera);	$tabla.append($thead);
		
		//Cuerpo
		var $cuerpo=$("<tbody></tbody>");
		var $tr=$("<tr></tr>");
		var fLunes=new Date(calendario[0]["lunes"]);
		for(cont=1; cont<=7; cont++){
			var $td=$("<td></td>");	
			for(dia in calendario){	
				if(cont==calendario[dia]["cod_dia"]){
					var fActual=new Date();
					if(fActual<=fLunes){
						var $p=$("<p class='fecha_disponible'>"+calendario[dia]["hora_inicio"]+"-"+calendario[dia]["hora_fin"]+"</p>");
					}
					else
						var $p=$("<p>"+calendario[dia]["hora_inicio"]+"-"+calendario[dia]["hora_fin"]+"</p>");
					//Guardar el cod_calendario y la fecha a la que corresponde ese dia
					$p.data("cod_calendario", calendario[dia]["cod_calendario"]);
					$p.data("fecha", fLunes.getDate()+"/"+(fLunes.getMonth()+1)+"/"+fLunes.getFullYear());
					$td.append($p);
				}		
			}
			$tr.append($td);
			fLunes.setTime(fLunes.getTime()+1*24*60*60*1000);
		}
		$cuerpo.append($tr);  	$tabla.append($cuerpo); 	$divContHorario.append($tabla);
		
		//EVENTO PARA SELECCIONAR LOS DIAS Y HORAS SI LA ACTIVIDAD ES SELECCIONABLE_HORAS=1
		if(actividad["seleccionable_horas"]==1){
			$tabla.addClass('tSeleccionable');
			$("table#tHorarioAct p.fecha_disponible").on("click", function(){
				$(this).toggleClass("reserva");
				
				//Comprobar si existe horario marcado para poder habilitar el boton
				if($("p.reserva").length==0) $("#reserva2paso").attr("disabled", true);
					else $("#reserva2paso").attr("disabled", false);
				
			});
		}
		else{ //Al ser actividad seleccionable_horas=0 se habilita el boton siguiente
			$("#reserva2paso").attr("disabled", false);
		}
	}
	else{ //Si no existe horario para esa actividad
		$divContHorario.append("<h2 class='text-center'>HORARIO DISPONIBLE PROXIMAMENTE</h2>");	
	}
}

/** FUNCION PETICION AJAX PARA CARGAR UN COMBO CON LAS POSIBLES TARIFAS **/
function muestraTarifa(){
	$.ajax({
			url: "index.php?co=tarifas&ac=tarifasActividad",
			data: { cod_actividad: actividad["cod_actividad"]},
			type: "post",
			dataType: 'json',
			success: function(json){
				//console.log(json);
				var $comboTarifas=$("<select name='cod_tarifa' id='cod_tarifa' class='form-control'></select>");
				for(tarifa in json){
					if(actividad["seleccionable_horas"]==1){ //Si es seleccionable muestra solo las tarifa diaria
						if(json[tarifa]["diario"]==1){
							var $option=$("<option value='"+json[tarifa]["cod_tarifa"]+"'>"+
											json[tarifa]["precio"]+"-"+json[tarifa]["tipo"]+
										"</option>");
						}
					}
					else{ //Si no es seleccionable muestra todas las tarifas disponibles
						var $option=$("<option value='"+json[tarifa]["cod_tarifa"]+"'>"+
										json[tarifa]["precio"]+"€ -"+json[tarifa]["tipo"]+
									"</option>");
					}	
					$comboTarifas.append($option);
				}
				$("#camposForm").append(
							$("<div></div>").append(
												$("<div class='form-group'></div>")
														.append($("<label for='cod_tarifa'>Tarifas disponibles</label>"))
														.append($comboTarifas)
											)
										);	
			}
		});	
}

/** FUNCION PARA EL EVENTO CHANGE DE RESERVA HASTA FIN DE TEMPORADA **/
	//	DESHABILITA EL CAMPO FECHA FIN Y LO PONE CON VALOR DE FIN DE ACTIVIDAD
function eventFinTemporada(){
	if($(this).prop("checked")==true){
		var fecha_fin=actividad["fecha_fin"].split("-");
		$("input[name=fecha_fin]").val(fecha_fin[2]+"/"+fecha_fin[1]+"/"+fecha_fin[0]);
		$("input[name=fecha_fin]").prop("disabled", true);	
	}
	else{
		$("input[name=fecha_fin]").val("");
		$("input[name=fecha_fin]").prop("disabled", false);
	}
}

/** FUNCION COMPRUEBA LOS CAMPOS DE LA RESERVA, SI SON CORRECTOS LOS AÑADE AL ARRAY RESERVAS Y DEVUELVE TRUE, SI NO FALSE **/
function comprobarReserva(){
	//Si seleccionable_horas=1, las fechas estan en reserva, lo unico que guardar seria la tarifa
	if(actividad["seleccionable_horas"]==1){
		tarifa={
			"cod_tarifa" : $("#cod_tarifa").val(),
			"nombre" : $("#cod_tarifa option[value="+$("#cod_tarifa").val()+"]").html()
		};
		return true;
	}	
	//Si seleccionable_horas=0, comprueba las fechas y la tarifa y lo guarda en reservas
	else{
		var respuesta=true;
		$("span.error").remove();
		if($("input[name=fecha_inicio]").val()==""){
			$("<span class='error'>Debe introducir una fecha</span>").insertBefore($("label[for=fecha_inicio]"));
			respuesta=false;
		}
		if($("input[name=fecha_fin]").val()==""){
			$("<span class='error'>Debe introducir una fecha</span>").insertBefore($("label[for=fecha_fin]"));
			respuesta=false;
		}
		if($("#cod_tarifa").val()==""){
			$("<span class='error'>Debe introducir una fecha</span>").insertBefore($("label[for=cod_tarifa]"));
			respuesta=false;
		}
		if(respuesta==true){
			reservas.push(
				{
					"fecha_inicio" : $("input[name=fecha_inicio]").val(),
					"fecha_fin" : $("input[name=fecha_fin]").val()
				}
			);
			tarifa={
				"cod_tarifa" : $("#cod_tarifa").val(),
				"nombre" : $("#cod_tarifa option[value="+$("#cod_tarifa").val()+"]").html()
			};
		}
		//console.log(tarifa);
		return respuesta;
	}
}

/** FUNCION QUE MUESTRA LA INFORMACION DE TODAS LA RESERVAS QUE SE VAN A REALIZAR **/
function informacionReserva(){
	$("#contNuevaReserva").empty();
	$("#tituloPaso").html("<em>Paso 3 - Información/confirmación de la reserva</em>");
	$("#contBtn").html("<input type='button' class='btn btn-default' id='reserva4paso' value='Reservar'>");
	
	var $div=$("<div id='infoReserva'></div>");
	
	//Cargar la informacion de la actividad
	var $divActividad=$("<div class='well'>"+
							"<h1 class='text-center'>"+actividad["nombre"]+"</h1>"+	
						"</div>"
						);
	$div.append($divActividad);
	
	$tabla=$("<table id='inforReservaTotal'></table>").append($("<tr></tr>")
											.append($("<th>Fecha Inicio</th>"))
											.append($("<th>Fecha Fin</th>"))
											.append($("<th>Horario</th>"))
											.append($("<th>Tarifa</th>")));
	
	//Cargar la informacion de la reserva
	for(reserva in reservas){
		$trReserva=$("<tr></tr>").html("<td>"+
											reservas[reserva]["fecha_inicio"]+
										"</td>"+
										"<td>"+
											reservas[reserva]["fecha_fin"]+
										"</td>"							
									);
		if(typeof reservas[reserva]["horario"]!="undefined"){
			$trReserva.append($("<td>"+
								reservas[reserva]["horario"]+
							"</td>"));
		}
		else $trReserva.append($("<td></td>"));
		
		$trReserva.append($("<td>"+tarifa["nombre"]+"</td>"));
		
		$tabla.append($trReserva);
	}
	$div.append($tabla);
	$div.append($("<div class='well'></div>")
						.append($("<h3>La reserva se podrá anular hasta "+actividad["periodo_anulacion"]+" horas antes de la fecha de inicio</h3>")));
	$("#contNuevaReserva").append($div);
	
	//Evento sobre el boton reservar realiza peticion ajax e inserta las reservas
	$("#reserva4paso").on("click", finalizarReserva);
}

/** FUNCION QUE REALIZA UNA PETICION AJAX PARA INSERTAR LA RESERVA **/
		//Parametros: obJSON reservas y obActividad;
function finalizarReserva(){
	$.ajax({
		url: "index.php?co=reservas&ac=finalizarReserva",		
		data: { reservas: reservas, actividad: actividad, tarifa:tarifa},
		type: "post",
		dataType: 'json',
		success: function(json){
			if(json["result"]=="success"){
				window.location="index.php?co=reservas&ac=listaReservas";
			}
			else{
				$("#modalError").modal("show");
			}
		}
	});	
}
