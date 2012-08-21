<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$this->pmod->insert_snippet('company_name')?></title>
	
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
	<script type='text/javascript' src='/js/centreHome.js'></script>
	
	<link rel='stylesheet' type='text/css' href='/styling/bootstrap/bootstrap.css' />
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
		<?=$yield?>

		<div class='home_footer'>
				<p>&copy; <?=$this->pmod->insert_snippet('company_name') .' '. date('Y')?></p>
		</div>
</body>

</html>