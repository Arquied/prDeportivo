$(document).ready(function() {	
	//CARGA DATETIMEPICKER A FECHA DE NACIMIENTO
	$("#usuario_fecha_nac").datetimepicker({
				  format:'d/m/Y',
				  inline:false,
				  lang:'es',
				  timepicker:false,
				  dayOfWeekStart: 1	,
				  scrollInput: false								  
				});
							
	//EVENTO ONCLICK PARA BOTON CAMBIAR A ADMINISTRADOR, MUESTRA VENTANA MODAL CAMBIAR A ADMINISTRADOR
	$(".cambiarAdministrador").on("click", function(){
		var id=$(this).parent().siblings().first().html();
		$("#modalRole input[name='id_usuario']").val(id);
		$('#modalRole').modal({show:true});	
	});
	//EVENTO ONCLICK PARA EL BOTON BORRAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".btnBorrar").on("click", function(){
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
