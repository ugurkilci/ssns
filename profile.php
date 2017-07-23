<?php 
	include ("ayar.php"); // ayar dosyası
	include ("function.min.php"); // fonksiyon dosyası
	profile_data(); // profil verileri
?>
<html>
	<head>
		<title><?php echo $s_kadi; ?> SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="<?php echo $s_hakkinda; ?>">
		<meta name="keywords" content="<?php echo $s_kadi; ?>, simple, social, network, script, social network, social sharing, sosyal ağ scripti, sosyal ağ, scripti">
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

			profile(); // profil

			include("sidebar.php");
			include("footer.php");
		?>