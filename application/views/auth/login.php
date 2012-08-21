
	<div id="home_container">
	<a href='/'><img src='/images/logo_transparent.png' /></a>
	<div id="login_box">
		<form action="/auth/login/" method="post">
			<?php if (@$message):?>
				<div class="alert alert-error">
				  <a class="close" data-dismiss="alert">×</a>
				  <p><?=$message?></p>
				</div>
			<?php endif; ?>

			<p><input type="text" name="email" value="" placeholder="Email Address" /></p>
			<p><input type="password" name="password" placeholder="Password" /></p>
			<p><input type="submit" name="submit" value="Login" class='btn ' /></p>
			
		</form>
	</div>
	</div>
