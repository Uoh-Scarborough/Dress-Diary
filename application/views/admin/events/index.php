

<div id='page'>
	<h1>Events</h1>
	<p>This is the event management page. On this page you can add new events, editing existing events and remove events from the list.</p>
	<p class='label label-important'>! WARNING - Deleting an event will remove it permanently. Please do not remove an event unless you are 100% sure it is no longer required.</p>
	<h2>Upcoming Events:</h2>
	
	<?=$upcoming_events?>
	<h2>Past Events:</h2>
	<p><a href='' class='btn btn-danger'><i class='icon-remove icon-white'></i> Remove all past events</a></p>
	<?=$past_events?>
</div>

<script type="text/javascript">

$(document).ready(function()  {
	
	$('.add_event').click(function(e){
		e.preventDefault();
		
		//Remove anything that is there so we can get allowed pages only
		$('#type-select').children().each(function()
		{
			$(this).remove();
		});
		
		//Set the action of the form
		
		$('#add_form').attr('action', '/admin/events/add')
		var thedata = $(this).attr('title').split('~');
		var eventtypes = thedata[0].split('|');
		var venues = thedata[1].split('|');
		
		for(var i in eventtypes)
		{
			var splitem = eventtypes[i].split(':');
			var optn = $('<option value="'+ splitem[0]+'"></option>');
			optn.text(splitem[1]);
			$('#type-select-add').append(optn);
		}
		
		for(var i in venues)
		{
			var splitem = venues[i].split(':');
			var optn = $('<option value="'+splitem[0]+'"></option>');
			optn.text(splitem[1]);
			$('.current_venues').append(optn);
		}
		
		$('#addModal').modal('show');
	});
	
	$('.edit_event').click(function(e){
		e.preventDefault();
		$('#type-select-edit').children().each(function()
		{
			$(this).remove();
		});
		$('#edit_form').attr('action', '/admin/events/edit/'  + $(this).attr('href'))
		
		var thedata = $(this).attr('title').split('~');
		
		var eventtypes = thedata[0].split("|");
		var currentdata = thedata[1].split(':');
		var venues = thedata[2].split('|');
		var selected = '';
		for(var i in eventtypes)
		{
			
			var splitem = eventtypes[i].split(':');
			if(currentdata[1] == splitem[0])
			{
				selected = 'selected';
			}else{
				selected = '';
			}
			var optn = $('<option value="'+ splitem[0]+'" '+selected+'></option>');
			
			optn.text(splitem[1]);
			$('#type-select-edit').append(optn);
		}
		$('#edit_venue_list').children().each(function()
		{
			$(this).remove();
		});
		for(var i in venues)
		{
			var splitem = venues[i].split(':');
			if(currentdata[3] == splitem[0])
			{
				selected = 'selected';
			}else{
				selected = '';
			}
			var optn = $('<option value="'+splitem[0]+'" '+selected+'></option>');
			optn.text(splitem[1]);
			$('#edit_venue_list').append(optn);
		}
		$('#eventname').val(currentdata[0]);
		$('#datepicker-edit').val(currentdata[2]);
		$('.venue').val(currentdata[5]);
		$('#v_id').val(currentdata[3]);
		$('#contact').val(currentdata[4]);

		$('#editModal').modal('show');
		
	});
	
	$('.delete_event').click(function(e){
		e.preventDefault();
		
		$('#delete_button').attr('href', '/admin/events/delete/' + $(this).attr('href'));
		
		$('#deleteModal').modal('show');
	});
	
	$('#closeModal').click(function(e){
		$('#addModal').modal('hide');
	});
	$('#closeEditModal').click(function(e){
		$('#editModal').modal('hide');
	});
	$('#closeDeleteModal').click(function(e){
		$('#deleteModal').modal('hide');
	});
	
	$('.add_venue').click(function(e){
		e.preventDefault();
		if($('.venue_area').is(":visible")){
			$('.venue_area').hide();
			$('.add_venue').addClass('btn-success');
			$('.add_venue').removeClass('btn-danger');
			$('.add_venue').text('Add venue');
			$('.add_venue_flag').val(0);
		}else{
			$('.venue_area').show();
			$('.add_venue').removeClass('btn-success');
			$('.add_venue').addClass('btn-danger');
			$('.add_venue').text('Cancel');
			$('.add_venue_flag').val(1);
		}
		
	});
	
	$('.edit_venue').click(function(e){
		$('#edit_region_select').children().each(function()
		{
			$(this).remove();
		});
		e.preventDefault();
		if($('.venue_area').is(":visible")){
			$('.venue_area').hide();
			$('.edit_venue').addClass('btn-info');
			$('.edit_venue').removeClass('btn-danger');
			$('.edit_venue').text('Edit venue');
			$('.edit_venue_flag').val(0);
		}else{
			$('.venue_area').show();
			$('.edit_venue').removeClass('btn-info');
			$('.edit_venue').addClass('btn-danger');
			$('.edit_venue').text('Cancel');
			$('.edit_venue_flag').val(1);
		}
		
		//Populate the fields using AJAX only if its the edit button clicked, not cancel
		if($('.edit_venue_flag').val() == 1){
			$.post('/admin/events/getvenuedata/', { vid: $('#v_id').val() }, function(data){
				var splitem = data.split(":");
			
				//ID = 0; Name = 1; Address Line 1 = 2; Address Line 2 = 3; Postcode = 4; Town = 5; Region = 6;
				$('#e_venue_name').val(splitem[1]);
				$('#e_vadd1').val(splitem[2]);
				$('#e_add2').val(splitem[3]);
				$('#e_town').val(splitem[5]);
				$('#e_postcode').val(splitem[4]);
				
				//Do another AJAX call to populate the regions
				
				$.post('/admin/events/getregions', function(data2){
					
					var splitregion = data2.split("|");
					
					for (var i in splitregion)
					{
						var regiondata = splitregion[i].split(":");
						//ID = 0; Region name = 1;
						if(splitem[6] == regiondata[0])
						{
							selected = 'selected';
						}else{
							selected = '';
						}
						var optn = $('<option value="'+ regiondata[0]+'" '+selected+'></option>');
						optn.text(regiondata[1]);
						$('#edit_region_select').append(optn);
						
					}
					
				});
				
			});
		}
	});
	
	$('#edit_venue_list').change(function(){
		$('.venue_area').hide();
		$('.edit_venue').addClass('btn-info');
		$('.edit_venue').removeClass('btn-danger');
		$('.edit_venue').text('Edit venue');
		$('.edit_venue_flag').val(0);
		$('#v_id').val($(this).val());
	});
});





</script>

<?php include (APPPATH . 'includes/event_modals.php');?>