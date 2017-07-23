</div>
<div class="col-sm-4">
<?php
	if (@$_SESSION) { // Eğer giriş yapılmışsa
		echo '
		<img src="' . $uyeler_fotograf . '" class="img-circle" style="width:64px;height:64px;">
		<strong>' . $uyeler_kadi . '</strong><br /><br />
		<a href="profile?u=' . $uyeler_kadi . '" class="m2">My Profile</a>
		<a href="settings" class="m2">My Settings</a>
		<a href="home?p=exit" class="m2">Exit</a>
		<br /><br />';
		add();
		echo '
		<form action="" method="post">
			<input type="text" name="title" class="form-control" placeholder="Title"/><br />
			<textarea name="content" class="form-control" placeholder="Content - How are you?"></textarea>
			<input type="hidden" name="kod" value="'.$securitycode.'" />
			<input type="submit" name="addtitle" class="btn add" value="Add Title!"/>
		</form>';
	}else{ // Eğer giriş yapılmamışsa
		echo '
		<a href="login" class="btn m2 add" title="Login">Login</a>
		<a href="login" class="btn m2 add" title="Register">Register</a>
		';
	}
?>