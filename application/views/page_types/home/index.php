<div id='home_container'>
	
	<div class='logo_area'>
		<img src='/images/logo_transparent.gif' alt='Prom Dress Diary logo'>
		<h1>Find an event in your area</h1>
	</div>
	<div class='search_area'>
		<form action='events/search' method='post'>
			<div class='input-append'>
			<input type='text' name='search_events' class="huge_search" placeholder="Enter a postcode" />
			<input type='submit' class='btn search_button' value='Go!' />
			</div>
		</form>
		<?=$page->body?>
	</div>

</div>