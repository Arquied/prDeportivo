$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnBorrar", function(){
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalBorrado").data('id_calendario', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_CALENDARIO
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=calendarios&ac=borraCalendario&id="+$("#modalBorrado").data("id_calendario");
	});
});
