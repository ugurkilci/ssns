<?php 
	include ('function.php'); // fonksiyon dosyası
?>
<html>
	<head>
		<title>Login - SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="Simple social network script ile kendi sosyal ağını kur!">
		<meta name="keywords" content="simple, social, network, script, social network, social sharing, sosyal ağ scripti, sosyal ağ, scripti">
		<link rel="author" href="Uğur KILCI">
		
		<link rel="dns-prefetch" href="https://google-analytics.com/">
		<link rel="dns-prefetch" href="https://www.google-analytics.com/">
		<link rel="dns-prefetch" href="https://fonts.googleapis.com/">
		<link rel="dns-prefetch" href="https://pbs.twimg.com/">
		
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta http-equiv="cleartype" content="on">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	</head>
	<body>
		<?php 
			include("header.php");

			login(); // giriş yapma işlemi
			register(); // kayıt yapma işlemi

			echo '
			<h2>Login</h2>
			<form action="" method="POST">
				<strong>Username:</strong>
				<input type="text" name="kadi" class="form-control" placeholder="Username" />
				<strong>Password:</strong>
				<input type="password" name="sifre" class="form-control" placeholder="Password" />
				<input type="submit" name="login" class="btn m2 add" value="Login!" />
			</form>
			<hr>

			<h2>Register</h2>
			<form action="" method="POST">
				<strong>Username:</strong>
				<input type="text" name="kadi" class="form-control" placeholder="Username" />
				<strong>Password:</strong>
				<input type="password" name="sifre" class="form-control" placeholder="Password" />
				<strong>E-Mail:</strong>
				<input type="text" name="mail" class="form-control" placeholder="E-Mail" />
				<input type="submit" name="register" class="btn m2 add" value="Register!" />
			</form>
			<hr>
			';

			include("sidebar.php");
			include("footer.php");
		?>