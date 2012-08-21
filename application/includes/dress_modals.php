<div class='modal fade' id='addModal'>

	<form action='this.php' id='add_form' method='post' enctype="multipart/form-data">
		<div class='modal-header'>
			<a class='close' id='closeModal'>×</a>
			<h2>Add Dress</h2>
		</div>
		<div class='modal-body'>
			<p><label>Name</label></p>
			<input type='text'  class='span2' placeholder='Enter dress name' value='' name='d_name' />
			<p><label>Number (SKU)</label></p>
			<input type='text'  class='span2' placeholder='Enter unique product ID' value='' name='d_num' />
			<p><label>Colours</label></p>
			<p><select name='colours[]' multiple class='chzn-select' id='d_colours'></select></p>
			<div class='clearfix'></div>
			<p><label>Picture</label></p>
            <input type="file" name="userfile" />
			<div class='clearfix'></div>
			<p><label>Category</label></p>
			<select name='d_category' id='d_category'></select>
			<p><label>Label</label></p>
			<select name='d_label' id='d_label'></select>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn btn-danger'>Cancel</a><input type='submit' class='btn btn-primary span1' value='Add'></p>
		</div>
	</form>
</div>

<div class='modal fade' id='editModal'>

	<form action='this.php' id='edit_form' method='post'>
		<div class='modal-header'>
			<a class='close' id='closeEditModal'>×</a>
			<h2>Edit Dress</h2>
		</div>
		<div class='modal-body'>
			<p><label>Name</label></p>
			<input type='text'  class='span2' placeholder='Enter dress name' value='' id='d_name_edit' name='d_name' />
			<p><label>Number (SKU)</label></p>
			<input type='text'  class='span2' placeholder='Enter unique product ID' value='' id='d_num_edit' name='d_num' />
			<p><label>Colours</label></p>
			<select name='colours_edit[]' id='d_colours_edit' width='800px' multiple class='chzn-select'>
			</select>
			<div class='clearfix'></div>
			<p><label>Category</label></p>
			<select name='d_category_edit' id='d_category_edit'></select>
			<p><label>Label</label></p>
			<select name='d_label_edit' id='d_label_edit'></select>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn btn-danger'>Cancel</a><input type='submit' class='btn btn-primary span1' value='Edit'></p>
		</div>
	</form>
</div>

<div class='modal fade' id='deleteModal'>
		<div class='modal-header'>
			<a class='close' id='closeDeleteModal'>×</a>
			<h2>Delete Dress</h2>
		</div>
		<div class='modal-body'>
			<p class='label label-important'>! WARNING</p>
			<p class='well'>Once something has been deleted it will no longer be available on the front-end or on the back-end and will not be recoverable. If you are sure you want to go ahead with the deletion click 'Delete anyway' below. If you do not want to continue, click cancel below or alternatively close this window down.</p>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn'>Cancel</a><a href='' id='delete_button' class='btn btn-danger'>Delete anyway</a></p>
		</div>
</div>