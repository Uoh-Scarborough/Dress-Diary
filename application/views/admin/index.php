<div id='page'>
	<h1>Pages</h1>
	<p class='label label-important'>! WARNING - Deleting a dress will remove it permanently. Please do not remove a dress unless you are 100% sure it is no longer required. It may also affect the events and the dresses that are attending there.</p>
	<?=@$error?>
	<?=$pages?>

<script type="text/javascript">

$(document).ready(function()  {
  $("#tree").treeTable({
		initialState: 'expanded'
	});
	
	$('.add_child').click(function(e){
		e.preventDefault();
		
		//Grab the pageID from the href
		
		$('#parent_id_select').val($(this).attr('href'));
		
		//Remove anything that is there so we can get allowed pages only
		$('#type-select').children().each(function()
		{
			$(this).remove();
		});
		
		//Set the action of the form
		
		$('#add_form').attr('action', '/admin/pages/add')
		
		var pagetypes = $(this).attr('title').split(':');
		
		for(var i in pagetypes)
		{
			var optn = $('<option></option>');
			optn.text(pagetypes[i]);
			$('#type-select').append(optn);
		}
		$('#addModal').modal('show');
	});
	
	$('.delete_page').click(function(e){
		e.preventDefault();
		
		$('#delete_button').attr('href', '/admin/pages/delete/' + $(this).attr('href'));
		
		$('#deleteModal').modal('show');
	});
	
	$('#closeModal').click(function(e){
		$('#addModal').modal('hide');
	});
	$('#closeDeleteModal').click(function(e){
		$('#deleteModal').modal('hide');
	});
});





</script>

<?php include(APPPATH . '/includes/page_modals.php'); ?>