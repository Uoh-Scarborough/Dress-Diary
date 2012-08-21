<div id='page'>
	<h1>Dresses</h1>
	<p>This is the dress management page. On this page you can add new dresses, editing existing dresses and remove dresses from the list.</p>
	<p class='label label-important'>! WARNING - Deleting a dress will remove it permanently. Please do not remove a dress unless you are 100% sure it is no longer required. It may also affect the events and the dresses that are attending there.</p>
	<?=$dresses?>

</div>

<script type="text/javascript">

$(document).ready(function()  {
	
	$('.add_dress').click(function(e){
		e.preventDefault();
		
		//Remove anything that is there so we can get allowed pages only
		$('#type-select').children().each(function()
		{
			$(this).remove();
		});
		
		
		var thedata = $(this).attr('title').split('~');
		var colours = thedata[0].split('|');
		var categories = thedata[1].split('|');
		var labels = thedata[2].split('|');
		//Set the action of the form
		
		$('#add_form').attr('action', '/admin/dresses/add')
		
		for(var i in colours)
		{
			var splitem = colours[i].split(':');
			var optn = $('<option value="'+ splitem[0]+'"></option>');
			optn.text(splitem[1]);
			$('#d_colours').append(optn);
		}
		
		for(var i in categories)
		{
			var splitem = categories[i].split(':');
			var optn = $('<option value="'+splitem[0]+'"></option>');
			optn.text(splitem[1]);
			$('#d_category').append(optn);
		}
		for(var i in labels)
		{
			var splitem = labels[i].split(':');
			var optn = $('<option value="'+splitem[0]+'"></option>');
			optn.text(splitem[1]);
			$('#d_label').append(optn);
		}
		
		$('#addModal').modal('show');
	});
	
	$('.edit_dress').click(function(e){
		e.preventDefault();
		var alldata = $(this).attr('title').split("~");
		var thedata = alldata[0].split(":");
		var colours = alldata[1].split("|");
		var categories = alldata[2].split("|");
		var labels = alldata[3].split("|");
		var dname = thedata[0];
		var sku = thedata[1];
		var colours_selected = thedata[2];
		var categoryid = thedata[3];
		var labelid = thedata[4];
		var selected;
		for(var i in colours)
		{
			var splitem = colours[i].split(':');

			for(var j in colours_selected)
			{

				if (colours_selected[j] === splitem[0])
				{
					selected = 'selected';
				}
			}
			var optn = $('<option value="'+ splitem[0]+'" '+ selected +'></option>');
			selected ='';
			optn.text(splitem[1]);
			$('#d_colours_edit').append(optn);
		}
			
		$('#d_name_edit').val(thedata[0]);
		$('#d_num_edit').val(thedata[1]);
		for(var i in categories)
		{
			
			var splitem = categories[i].split(':');
			if(categoryid === splitem[0]){
				selected = 'selected';
			}else{
				selected = '';
			}
			var optn = $('<option value="'+splitem[0]+'" '+selected+'></option>');
			optn.text(splitem[1]);
			$('#d_category_edit').append(optn);
		}
		for(var i in labels)
		{
			var splitem = labels[i].split(':');
			if(labelid === splitem[0]){
				selected = 'selected';
			}else{
				selected = '';
			}
			var optn = $('<option value="'+splitem[0]+'" '+selected+'></option>');
			optn.text(splitem[1]);
			$('#d_label_edit').append(optn);
		}

		
		$('#edit_form').attr('action', '/admin/dresses/edit/'  + $(this).attr('href'))

	 
		$('#editModal').modal('show');
	});
	
	$('.delete_event').click(function(e){
		e.preventDefault();
		
		$('#delete_button').attr('href', '/admin/dresses/delete/' + $(this).attr('href'));
		
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
	
});



</script>

<?php include (APPPATH . 'includes/dress_modals.php');?>