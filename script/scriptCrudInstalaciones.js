$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".btnBorrar").on("click", function(){
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html()
		$("#modalBorrado").data('id_instalacion', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_INSTALACION
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=instalaciones&ac=borraInstalacion&id="+$("#modalBorrado").data("id_instalacion");
	});
});
