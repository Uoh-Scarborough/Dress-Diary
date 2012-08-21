<div class='modal fade' id='addModal'>

	<form action='' id='add_form' method='post'>
		<div class='modal-header'>
			<a class='close' id='closeModal'>×</a>
			<h2>Add</h2>
		</div>
		<div class='modal-body'>
			<p><label>Title</label></p>
			<input type='text'  class='span2' placeholder='Enter page name' value='' name='title' />
			<input type='hidden' value='' name='parent_id' id='parent_id_select' />
			<p><label>Page Type</label></p>
			<select name='page-type' class='span2 chzn-select' id='type-select'>
			</select>
			
		</div>
		<div class='modal-footer'>
		<p><input type='submit' class='btn btn-primary span1' value='Add'></p>
		</div>
	</form>
</div>

<div class='modal fade' id='deleteModal'>
		<div class='modal-header'>
			<a class='close' id='closeDeleteModal'>×</a>
			<h2>Delete</h2>
		</div>
		<div class='modal-body'>
			<p class='label label-important'>! WARNING</p>
			<p class='well'>Once something has been deleted it will no longer be available on the front-end or on the back-end and will not be recoverable. If you are sure you want to go ahead with the deletion click 'Delete anyway' below. If you do not want to continue, click cancel below or alternatively close this window down.</p>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn'>Cancel</a><a href='' id='delete_button' class='btn btn-danger'>Delete anyway</a></p>
		</div>
	</form>
</div>