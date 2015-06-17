$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnBorrar", function(){
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalBorrado").data('id_actividad', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_ACTIVIDAD
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=actividades&ac=borraActividad&id="+$("#modalBorrado").data("id_actividad");
	});
	
	//CARGA DATETIMEPICKER
	$(".fecha").datetimepicker({
				  format:'d/m/Y',
				  lang:'es',
				  timepicker:false,
				  dayOfWeekStart: 1,
				  scrollInput: false,
				  scrollMonth: false,
				  scrollTime: false
				});
});
