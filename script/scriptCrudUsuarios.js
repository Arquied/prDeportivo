$(document).ready(function() {	
	//EVENTO ONCLICK PARA BOTON CAMBIAR A ADMINISTRADOR, MUESTRA VENTANA MODAL CAMBIAR A ADMINISTRADOR
	$(".table").on("click", ".cambiarAdministrador", function(){
		var id=$(this).parent().siblings().first().html();
		$("#modalRole input[name='id_usuario']").val(id);
		$('#modalRole').modal({show:true});	
	});
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnBorrar", function(){
		console.log("pulsado");
		$('#modalBorrado').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalBorrado").data('id_usuario', id);		
	});
	//EVENTO ONCLICK CONFIRMAR BORRADO REDIRECCIONA PASANDOLE EL ID_ACTIVIDAD
	$("#seguroBorrar").on("click", function(){
		window.location="index.php?co=usuarios&ac=borraUsuario&id="+$("#modalBorrado").data("id_usuario");
	});
	
	
});
