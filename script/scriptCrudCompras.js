$(document).ready(function() {
	//EVENTO CHANGE SELECT TEMPORADAS, CARGA EL COMBO DE ACTIVIDADES CON LAS DE LA TEMPORADA SELECCIONADA
	$("#comboTemporadas").on("change", function(){
		var idTemp=$(this).val();
		$("#comboActividades").empty();
		$("#comboActividades").append("<option value=''>Seleccione una opcion</option>");		
		$.ajax({
			url: "index.php?co=actividades&ac=actividadesTemporadaJSON",
			data: { cod_temporada: idTemp},
			type: "post",
			dataType: 'json',
			success: function(json){				
				if(json.length>0){
					for(actividad in json)
						$("#comboActividades").append("<option value='"+json[actividad]["cod_actividad"]+"'>"+json[actividad]["nombre"]+"</option>");
				}
			}
		});	
	});	
	//EVENTO ONCLICK PARA EL BOTON ANULAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnAnular", function(){
		$('#modalAnular').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalAnular").data('id_compra', id);		
	});
	//EVENTO ONCLICK CONFIRMAR ANULACIÓN REDIRECCIONA PASANDOLE EL ID_COMPRA
	$("#seguroAnular").on("click", function(){
		window.location="index.php?co=compras&ac=anularCompra&id="+$("#modalAnular").data("id_compra");
	});
	
	//EVENTO ONCLICK PARA EL BOTON PAGAR, MUESTRA VENTANA MODAL ESTA SEGURO
	$(".table").on("click", ".btnPagar", function(){
		$('#modalPagar').modal({show:true});
		var id=$(this).parent().siblings().first().html();
		$("#modalPagar").data('id_compra', id);		
	});
	//EVENTO ONCLICK CONFIRMAR PAGADO REDIRECCIONA PASANDOLE EL ID_COMPRA
	$("#seguroPago").on("click", function(){
		window.location="index.php?co=compras&ac=pagarCompra&id="+$("#modalPagar").data("id_compra");
	});
});
