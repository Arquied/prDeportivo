$(document).ready(function() {
	//EVENTO CHANGE PARA EL CHECKBOX DE VER LA TEMPORADA ACTUAL
	$("input[name=temporada_actual]").on("change", function(){
		$(this).closest('form').submit();	
	});
});
