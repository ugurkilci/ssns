<?php 
	include("function.min.php"); // fonksiyon dosyası
	if ($_SESSION) { // Eğer giriş yapılmışsa
?>
<html>
	<head>
		<title>Settings - SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="Simple social network script ile kendi sosyal ağını kur!">
		<meta name="keywords" content="simple, social, network, script, social network, social sharing, sosyal ağ scripti, sosyal ağ, scripti, settings, ayarlar">
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
			settings_one(); // genel ayarlar
		?>
		<h2>Settings</h2>
		<form action="" method="POST">
			<strong>My Profile Photo:</strong><input type="text" name="uyeler_fotograf" class="form-control" placeholder="My Profile Photo" value="<?php echo $uyeler_fotograf; ?>"><br />
			<strong>My About:</strong><input type="text" name="uyeler_hakkinda" class="form-control" placeholder="My About" value="<?php echo $uyeler_hakkinda; ?>"><br />
			<strong>My Mail:</strong><input type="text" name="uyeler_eposta" class="form-control" placeholder="My Mail" value="<?php echo $uyeler_eposta; ?>"><br />
			<strong>My Cinsiyet:</strong><input type="text" name="uyeler_cinsiyet" class="form-control" placeholder="My Mail" value="<?php echo $uyeler_cinsiyet; ?>"><br />
			<strong>My Birthday:</strong><input type="text" name="uyeler_dogumtarihi" class="form-control" placeholder="My Mail" value="<?php echo $uyeler_dogumtarihi; ?>"><br />
			<strong>My From:</strong><input type="text" name="uyeler_ulke" class="form-control" placeholder="My Mail" value="<?php echo $uyeler_ulke; ?>"><br />
			<input type="hidden" name="kod" value="<?php echo $securitycode; ?>">
			<input type="submit" name="s_one" class="btn m2" value="Update">
		</form>
		<?php settings_two(); // parola ayarları ?>
		<h2>Password</h2>
		<form action="" method="post">
			<strong>My Password:</strong><input type="password" name="password" class="form-control" placeholder="My Password"><br />
			<strong>My New Password:</strong><input type="password" name="newpassword" class="form-control" placeholder="My New Password"><br />
			<input type="hidden" name="kod" value="<?php echo $securitycode; ?>">
			<input type="submit" name="s_two" class="btn m2" value="Update">
		</form>
<?php
	include("sidebar.php");
	include("footer.php");
}else{ // Eğer giriş yapılmamışsa
	header("REFRESH:0;URL=home");
}
?>