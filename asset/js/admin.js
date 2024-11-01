jQuery(document).ready(function($) {
	//* Include colorpicker
	$('.wp-color-picker-field').wpColorPicker();
	
	$('#ua_options input:checkbox:checked').each(function(){
		var check = $(this).attr("id");
		$( "input[name='ua_options["+check+"]']" ).val(1);	
	});
	
	$('#ua_options input[type="checkbox"]').change(function () {
		var check = $(this).attr("id");
		if($(this).prop('checked')){			
			$( "input[name='ua_options["+check+"]']" ).val(1);			
		}
		else {
			$( "input[name='ua_options["+check+"]']" ).val(0);
		}
	});		
});
