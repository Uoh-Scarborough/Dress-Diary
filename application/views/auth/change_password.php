<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$this->pmod->insert_snippet('company_name')?></title>
	<link rel='stylesheet' type='text/css' href='/styling/styles.css' />
	<meta name='description' content='<?=$yield_meta_desc?>'>
	<meta name='keywords' content='<?=$yield_meta_keywords?>'>

	
</head>
<body>

<div id="container">
	<div id='header'>
		<a href='/'><img src='/images/logo.png' alt='<?=$this->pmod->insert_snippet('company_name')?> logo' /></a>
	</div>
	
	<div id='navigation'>
		<ul>
			<?=$yield_nav?>
		</ul>
	</div>
	<div id='main_content'>
		<h1>Change Password</h1>

		<div id="infoMessage"><?php echo $message;?></div>

		<?php echo form_open("auth/change_password");?>

		      <p>Old Password:<br />
		      <?php echo form_input($old_password);?>
		      </p>

		      <p>New Password:<br />
		      <?php echo form_input($new_password);?>
		      </p>

		      <p>Confirm New Password:<br />
		      <?php echo form_input($new_password_confirm);?>
		      </p>

		      <?php echo form_input($user_id);?>
		      <p><?php echo form_submit('submit', 'Change');?></p>

		<?php echo form_close();?>
	</div>
	<div id='footer'>
		<p class='left'>&copy; <?=$this->pmod->insert_snippet('company_name').date('Y')?></p>
		<a href='/admin'>Admin Login</a>
	</div>
</div>

</body>
</html>