
$(document).ready(function(){
						   
	$(window).resize(function(){

		$('#home_container').css({
			position:'absolute',
			left: ($(window).width() - $('#home_container').outerWidth())/2,
			top: ($(window).height() - $('#home_container').outerHeight())/2
		});
		
	});
	// To initially run the function:
	$(window).resize();

});

