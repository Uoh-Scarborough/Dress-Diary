<div class='modal fade' id='addModal'>

	<form action='this.php' id='add_form' method='post'>
		<div class='modal-header'>
			<a class='close' id='closeModal'>×</a>
			<h2>Add Event</h2>
		</div>
		<div class='modal-body'>
			<p><label>Name</label></p>
			<input type='text'  class='span2' placeholder='Enter event name' value='' name='e_name' />
			<p><label>Event Type</label></p>
			<select name='e_type' class='span2' id='type-select-add'>
			</select>
			<p><label>Date</label></p>
			<input type='text'  class='span2 small' data-datepicker='datepicker' placeholder='Select a date' value='' id='datepicker-add' name='e_date' />
			<p><label>Select Venue:</label></p>
			<select class='chzn-select current_venues' name='venue'>
				
			</select>
			<a href='' class='btn btn-success add_venue'>Add new venue</a>
			<input type='hidden' value='0' name='add_venue_flag' class='add_venue_flag'/>
			<div style='display:none' class='venue_area'>
				<hr />
				<p><label>Venue Name:</label></p>
				<input type='text'  class='span2' placeholder='e.g. The venue' value='' name='e_venue_name' />
				<p><label>Address Line 1:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_add1' />
				<p><label>Address Line 2:</label></p>
				<input type='text'  class='span2' placeholder='e.g. The venue' value='' name='e_add2' />
				<p><label>Town:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_town' />
				<p><label>Region:</label></p>
				<select id='add_region_select' name='region'></select>
				<p><label>Postcode:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_postcode' />
			</div>
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
			<h2>Edit Event</h2>
		</div>
		<div class='modal-body'>
			<p><label>Name</label></p>
			<input type='text'  class='span2' placeholder='Enter page name' value='' id='eventname' name='e_name' />
			<p><label>Event Type</label></p>
			<select name='e_type' class='span2 chzn-select' id='type-select-edit'>
			</select>
			<p><label>Date</label></p>
			<input type='text'  class='span2 small' placeholder='Select a date' value='' id='datepicker-edit' data-datepicker='datepicker' name='e_date' />
			<div class="clearfix"></div>
			<select id='edit_venue_list' name='venue_list'>
			</select>
			<input type='hidden' name='v_id' id='v_id' value='' />
			<a href='' class='btn btn-info edit_venue'>Edit venue</a>
			<input type='hidden' value='0' name='edit_venue' class='edit_venue_flag'/>
			<div style='display:none' class='venue_area'>
				<hr />
				<p><label>Venue Name:</label></p>
				<input type='text'  class='span2' placeholder='e.g. The venue' value='' name='e_venue_name' id='e_venue_name'/>
				<p><label>Address Line 1:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_add1' id='e_vadd1'/>
				<p><label>Address Line 2:</label></p>
				<input type='text'  class='span2' placeholder='e.g. The venue' value='' name='e_add2' id='e_add2' />
				<p><label>Town:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_town' id='e_town' />
				<p><label>Region:</label></p>
				<select id='edit_region_select' name='region'></select>
				<p><label>Postcode:</label></p>
				<input type='text'  class='span2' placeholder='e.g. 1 Long Road' value='' name='e_postcode' id='e_postcode' />
			</div>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn btn-danger'>Cancel</a><input type='submit' class='btn btn-primary span1' value='Edit'></p>
		</div>
	</form>
</div>

<div class='modal fade' id='deleteModal'>
		<div class='modal-header'>
			<a class='close' id='closeDeleteModal'>×</a>
			<h2>Delete Event</h2>
		</div>
		<div class='modal-body'>
			<p class='label label-important'>! WARNING</p>
			<p class='well'>Once something has been deleted it will no longer be available on the front-end or on the back-end and will not be recoverable. If you are sure you want to go ahead with the deletion click 'Delete anyway' below. If you do not want to continue, click cancel below or alternatively close this window down.</p>
		</div>
		<div class='modal-footer'>
		<p><a href='' class='btn'>Cancel</a><a href='' id='delete_button' class='btn btn-danger'>Delete anyway</a></p>
		</div>
</div>