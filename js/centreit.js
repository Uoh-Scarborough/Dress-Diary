
$(document).ready(function(){
						   
	$(window).resize(function(){

		$('#login_container').css({
			position:'absolute',
			left: ($(window).width() - $('#login_container').outerWidth())/2,
			top: ($(window).height() - $('#login_container').outerHeight())/2
		});
		
		
		
	});
	// To initially run the function:
	$(window).resize();
	
	

});

