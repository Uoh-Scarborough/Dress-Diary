<div id='page'>
	<form action='/events/search' method='post'>
		<div class='input-append'>
		<input type='text' name='search_events' class="huge_search" placeholder="Enter a postcode" />
		<input type='submit' class='btn search_button' value='Go!' />
		</div>
	</form>
	<div id='map_canvas' style='width:940px;height:500px;'></div>
	
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAUW3sF4r0nRL5LviCX4K9GxSu7aWKGgjRi85LTO6utk_lrli1zBRHga1MKVXoqCxmjmSC9t2YYM0MbA" type="text/javascript"></script>
<script type="text/javascript" src="/js/mapscript.js"></script>

<script type='text/javascript'>

$(document).ready(function(){
		
		
			findEverything('postcode','<?=$postcode?>');
});

</script>
