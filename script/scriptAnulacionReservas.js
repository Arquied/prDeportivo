$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnBorrar", function(){
		$('#modalAnulado').modal({show:true});
		var id=$(this).prop("id");
		$("#modalAnulado").data('id_reserva', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_ACTIVIDAD
	$("#seguroAnular").on("click", function(){
		window.location="index.php?co=reservas&ac=anularReserva&id="+$("#modalAnulado").data("id_reserva");
	});
});
