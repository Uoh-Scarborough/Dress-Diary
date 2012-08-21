<div id='page'>
	<h1>Snippets</h1>
	<p>A snippet is a small piece of miscellaneous text that is editable throughout the site but does not fit in to any of the admin categories. From this page you will be able to add new snippets as well as edit or delete existing snippets</p>
	<p class='label label-important'>! WARNING - Deleting a snippet my have adverse effects on the website</p>
	<h2>Current Snippets:</h2>
	<p><a href='' class='btn btn-success add_snippet'><i class="icon-plus icon-white"></i> Add Snippet</a></p>
	<?=$snippets?>
</div>

<script type="text/javascript">

$(document).ready(function()  {
  $("#tree").treeTable({
		initialState: 'expanded'
	});
	
	$('.add_snippet').click(function(e){
		e.preventDefault();
		
		$('#add_form').attr('action', '/admin/snippets/add')
		
		$('#addModal').modal('show');
	});
	
	$('.edit_snippet').click(function(e){
		e.preventDefault();
		
		$('#edit_form').attr('action', '/admin/snippets/edit/'  + $(this).attr('href'))
		
		var contents = $(this).attr('title').split('|');
		
		$('#snippet_name').val(contents[0]);
		
		$('#snippet_content').val(contents[1]);
		
		$('#editModal').modal('show');
		
	});
	
	$('.delete_snippet').click(function(e){
		e.preventDefault();
		
		$('#delete_button').attr('href', '/admin/snippets/delete/' + $(this).attr('href'));
		
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

<?php include(APPPATH . '/includes/snippet_modals.php'); ?>