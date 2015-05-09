$(document).ready(function() {	
	//EVENTO ONCLICK PARA BOTON CAMBIAR A ADMINISTRADOR, MUESTRA VENTANA MODAL CAMBIAR A ADMINISTRADOR
	$(".cambiarAdministrador").on("click", function(){
		var id=$(this).parent().siblings().first().html();
		$("#modalRole input[name='id_usuario']").val(id);
		$('#modalRole').modal({show:true});	
	});
});
