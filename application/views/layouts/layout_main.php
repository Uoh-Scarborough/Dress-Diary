<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$this->pmod->insert_snippet('company_name')?></title>
	<link rel='stylesheet' type='text/css' href='/styling/bootstrap/bootstrap.css' />
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.js'></script>
	<link rel='stylesheet' type='text/css' href='/styling/styles.css' />
	<meta name='description' content='<?=$yield_meta_desc?>'>
	<meta name='keywords' content='<?=$yield_meta_keywords?>'>

	
</head>
<body>
	<div class="navbar">
	  <div class="navbar-inner">
	    <div class="container">
	     	<ul class="nav">
			  <?=$yield_footNav?>
			</ul>
	    </div>
	  </div>
	</div>
<div id="container">
	
	<div id='header'>
		<a href='/'><img src='/images/logo_transparent.png' alt='<?=$this->pmod->insert_snippet('company_name')?> logo' /></a>
	</div>
	<div id="background"></div>
	<div id='main_content'>
		<?=$yield?>
	</div>
</div>

<div class='page_footer'>
	<p class='left'>&copy; <?=$this->pmod->insert_snippet('company_name') .' '. date('Y')?></p>
	<div class='right social_media_footer'>
		<a href='<?=$this->pmod->insert_snippet('socialmedia_facebook')?>'><img src='/images/facebook.png' alt='Facebook social media(png)' /></a>
		<a href='<?=$this->pmod->insert_snippet('socialmedia_twitter')?>'><img src='/images/twitter.png' alt='Twitter social media (png)' /></a>
	</div>
</div>

</body>
</html>
