

	<div id='main_content'>
		<div class='mainInfo'>

			<h1>Boutiques</h1>
			<p>Below is a list of the boutiques that can access the admin area to add dresses to events.</p>

			<div id="infoMessage"><?php echo $message;?></div>

			<table class='table table-bordered table-striped'>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Group</th>
					<th>Status</th>
				</tr>
				<?php foreach ($users as $user):?>
					<tr>
						<td><?php echo $user['first_name']?></td>
						<td><?php echo $user['last_name']?></td>
						<td><?php echo $user['email'];?></td>
						<td><?php echo $user['group_description'];?></td>
						<td><?php echo ($user['active']) ? anchor("auth/deactivate/".$user['id'], 'Active') : anchor("auth/activate/". $user['id'], 'Inactive');?></td>
					</tr>
				<?php endforeach;?>
			</table>

			<p><a href="<?php echo site_url('auth/create_user');?>">Add a new boutique</a></p>

		</div>
	</div>


