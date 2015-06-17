$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnBorrar", function(){
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalBorrado").data('id_temporada', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_INSTALACION
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=temporadas&ac=borraTemporada&id="+$("#modalBorrado").data("id_temporada");
	});
});
