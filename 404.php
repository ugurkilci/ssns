<?php 
	include ('function.php'); // fonksiyon dosyası
?>
<html>
	<head>
		<title>404 Error - SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link rel="author" href="dipnot.txt">
		
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

			echo '
			<h1>404 Error!</h1>
			<p>
				We met with an unexpected error.<br />
				<a href="home" class="btn m2 add"><- Back Turn</a>
			</p>
			<hr>
			';

			include("sidebar.php");
			include("footer.php");
		?>