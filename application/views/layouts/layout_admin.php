<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$this->pmod->insert_snippet('company_name')?></title>

	<link rel='stylesheet' type='text/css' href='/styling/bootstrap/bootstrap.min.css' />
	<link rel='stylesheet' type='text/css' href='/styling/bootstrap/bootstrap-responsive.min.css' />
	<link rel='stylesheet' type='text/css' href='/styling/page_types.css' />
	<link rel='stylesheet' type='text/css' href='/css/ui-lightness/jquery-ui-1.8.18.custom.css' />
	<link rel='stylesheet' type='text/css' href='/styling/admin.css' />
	<link rel='stylesheet' type='text/css' href='/js/chosen/chosen.css' />
	<link href="/js/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
	
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.js'></script>
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script> 
	<script type="text/javascript" src="/js/ckeditor/adapters/jquery.js"></script>
	<script type='text/javascript' src='/js/bootstrap-transition.js'></script>
	<script type='text/javascript' src='/js/bootstrap-modal.js'></script>
	<script type="text/javascript" src="/js/src/javascripts/jquery.treeTable.js"></script>
	<script type='text/javascript' src='/js/bootstrap-datepicker.js'></script>
	<script type='text/javascript' src='/js/chosen/chosen.jquery.js'></script>

</head>
<body>
<div id='admin_header'>
	<div id='admin_header_data'>
		<p class='left'>
			<a href='/'>&laquo; View the site </a>:: <a href='/auth/index'>User Management</a></p>
		<p class='right'>Logged in as: <?=$yield_user?> <a href ='/auth/logout' >(Logout?)</a></p>
	</div>
</div>
<div id='admin_navigation'>
	<div class='padit_20'>
		<div class='logo_area'>
			<a href='/'><img src='/images/logo_transparent.png' alt='<?=$this->pmod->insert_snippet('company_name')?> logo' /></a>
		</div>
		
		<ul class="navo nav nav-tabs nav-stacked">
			<?=$yield_nav?>
		</ul>
		<ul class="navo nav nav-tabs nav-stacked">
			<li>
				<a href='/admin/boutiques'>Add a dress to an event</a>
			</li>
		</ul>
		<div class='well well_admin'>
			<h4>Need help?</h4><br />
			<p>If you are struggling to use the CMS please refer to your user guide. If you need a new copy of the user guide <a href='#'>click here</a>.</p>
		</div>
	</div>
</div>
<div id='main_content'>
	<div class='padit_20'>
		<?=$yield?>
	</div>
</div>
<div class='clear'></div>
<div class='home_footer'>
	<p class='left'>&copy; <?=$this->pmod->insert_snippet('company_name') .' '. date('Y')?></p>
	<div class='right social_media_footer'>
		<a href='<?=$this->pmod->insert_snippet('socialmedia_facebook')?>'><img src='/images/facebook.png' alt='Facebook social media(png)' /></a>
		<a href='<?=$this->pmod->insert_snippet('socialmedia_twitter')?>'><img src='/images/twitter.png' alt='Twitter social media (png)' /></a>
	</div>
</div>
</body>
</html>
