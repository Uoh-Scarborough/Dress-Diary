
$(document).ready(function(){
						   
	$(window).resize(function(){

		$('#error_container').css({
			position:'absolute',
			left: ($(window).width() - $('#error_container').outerWidth())/2,
			top: ($(window).height() - $('#error_container').outerHeight())/2
		});
		
	});
	// To initially run the function:
	$(window).resize();

});

