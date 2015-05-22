var actividad;
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
		$("#tituloPaso").html("<em>Paso 2 - Fechas de reserva</em>");
		$("#camposForm").empty();
		//Si seleccionable_horas=1 --- obtener los p con reserva
		if(actividad["seleccionable_horas"]==1){
			var reservas=new Array();			
			$("p.reserva").each(function(ind, elem){
				reservas.push({"cod_calendario" : $(elem).data("cod_calendario"),
								"fecha_inicio" : $(elem).data("fecha"),
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
										  minDate: fecha.getDate()+"/"+fecha.getMonth()+1+"/"+fecha.getFullYear()
										});	
			/*$("input.fecha").on("change", function(){
				var $this=$(this);
				if($this.attr("name")=="fecha_inicio"){	
					console.log($this.val());
					$("input[name=fecha_fin]").datetimepicker({
													  format:'d/m/Y',
													  lang:'es',
													  timepicker:false,
													  dayOfWeekStart: 1,
													  scrollInput: false,
													  scrollMonth: false,
													  scrollTime: false,
													  minDate: $this.val()
													});	
				}
			});*/
			
		}
		//Cargar tarifa
		muestraTarifa();
		//Borrar horario
		$("#contHorario").remove();
		//Cambiar boton a informacion reserva
		$(this).attr({
					id: "reserva3paso",
					disabled: true
				});			
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
					var $p=$("<p>"+calendario[dia]["hora_inicio"]+"-"+calendario[dia]["hora_fin"]+"</p>");
					//Guardar el cod_calendario y la fecha a la que corresponde ese dia
					$p.data("cod_calendario", calendario[dia]["cod_calendario"]);
					$p.data("fecha", fLunes.getDate()+"/"+(fLunes.getMonth()+1)+"/"+fLunes.getFullYear());
					//console.log($p.data("fecha"));
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
			$("table#tHorarioAct p").on("click", function(){
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
				console.log(json);
				var $comboTarifas=$("<select name='cod_tarifa' class='form-control'></select>")
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
										json[tarifa]["precio"]+"-"+json[tarifa]["tipo"]+
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

