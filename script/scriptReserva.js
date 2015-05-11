$(document).ready(function() {
	//EVENTO CHANGE PARA LAS ACTIVIDADES, CARGA INFORMACION DE LA ACTIVIDAD Y 
	//HABILITA EL BOTON SIGUIENTE
	$("#contNuevaReserva #reserva_cod_actividad").on("change", function(){
		var cod_actividad=$(this).val();
		if(cod_actividad!=""){ //Carga informacion y habilita boton
			$("#reserva2paso").attr("disabled", false);
			$.ajax({
				url: "index.php?co=actividades&ac=actividadJSON",
				data: { cod_actividad: cod_actividad},
				type: "post",
				dataType: 'json',
				success: function(json){
					muestraActividadSeleccionada(json);
				}
			});
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
		
	})
	
	
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

/** FUNCION MUESTRA LA INFORMACION DE LA ACTIVIDAD SELECCIONADA **/
		//Parametro: objeto json datos actividad
function muestraActividadSeleccionada(actividad){
	if(actividad!=0){
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
