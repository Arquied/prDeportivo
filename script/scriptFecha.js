jQuery(function(){
 jQuery('#fecha_inicio').datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){	
   this.setOptions({
    maxDate:jQuery('#fecha_fin').val()?jQuery('#fecha_fin').val():false,
    lang:'es'
   })
  },
  timepicker:false
 });
 jQuery('#fecha_fin').datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#fecha_inicio').val()?jQuery('#fecha_inicio').val():false,
    lang: 'es'
   })
  },
  timepicker:false
 });
  jQuery('#hora_inicio').datetimepicker({
  datepicker:false,
  format:'H:i:s',
  onShow:function(ct){
  	this.setOptions({
  	maxTime:jQuery('#hora_fin').val()?jQuery('#hora_fin').val():false,
  	})
  },
});
 jQuery('#hora_fin').datetimepicker({
  datepicker:false,
  format:'H:i:s',
  onShow:function(ct){
  	this.setOptions({
  	minTime:jQuery('#hora_inicio').val()?jQuery('#hora_inicio').val():false,
  	
  	})
  },
});
});
