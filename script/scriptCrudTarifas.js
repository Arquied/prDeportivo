$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".btnBorrar").on("click", function(){
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html()
		$("#modalBorrado").data('id_tarifa', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_TARIFAS
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=tarifas&ac=borraTarifa&id="+$("#modalBorrado").data("id_tarifa");
	});
});
