<!DOCTYPE html> 
<html lang="en">
	<head> 
		<title><?=$heading?></title> 
	
		<link rel="stylesheet" href="/styling/bootstrap/bootstrap.min.css" /> 
		<link rel="stylesheet" href="/styling/styles.css" /> 
		
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
		<script type='text/javascript' src='/js/centreError.js'></script>
		<script type='text/javascript' src='/js/bootstrap.min.js'></script>
		
		<meta charset="utf-8"> 
		<meta name="description" content="" /> 
		<meta name="keywords" content="" />
	</head> 
	<body>
	<div id="error_container">
		<a href='/'><img src='/images/temp_logo.png' /></a>
		<div class='hero-unit'>
			<h1>Oops!</h1>
			<h2><?=$heading?></h2>
			<p><?=$message?></p>
		</div>
	</div>
</body>
</html>