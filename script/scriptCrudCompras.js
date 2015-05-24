$(document).ready(function() {
	//EVENTO ONCLICK PARA EL BOTON ANULAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".btnAnular").on("click", function(){
		$('#modalAnular').modal({show:true});
		var id=$(this).parent().siblings().first().html()
		$("#modalAnular").data('id_compra', id);		
	});
	//EVENTO ONCLICK CONFIRMAR ANULACIÓN REDIRECCIONA PASANDOLE EL ID_COMPRA
	$("#seguroAnular").on("click", function(){
		window.location="index.php?co=compras&ac=anularCompra&id="+$("#modalAnular").data("id_compra");
	});
	
		//EVENTO ONCLICK PARA EL BOTON PAGAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".btnPagar").on("click", function(){
		$('#modalPagar').modal({show:true});
		var id=$(this).parent().siblings().first().html()
		$("#modalPagar").data('id_compra', id);		
	});
	//EVENTO ONCLICK CONFIRMAR PAGADO REDIRECCIONA PASANDOLE EL ID_COMPRA
	$("#seguroPago").on("click", function(){
		window.location="index.php?co=compras&ac=pagarCompra&id="+$("#modalPagar").data("id_compra");
	});
});
