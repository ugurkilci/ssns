<?php 
	$p = @$_GET["p"]; // page
	include("ayar.php"); // config
	include("function.min.php"); // functions
?>
<html>
	<head>
		<title>SSNS - Simple Social Network Script</title>
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

			switch ($p) {
				case 'hot':
					echo '<h2>Hot</h2>';
					hot();
					break;

				case 'week':
					echo '<h2>Week</h2>';
					week();
					break;

				case 'month':
					echo '<h2>Month</h2>';
					month();
					break;

				case 'exit':
					echo '<h2>Exit</h2>';
					exit2();
					break;

				default:
					echo '<h1>Home (Most Like Area 5 Title)</h1><hr><h2>Today</h2>';
					home_today();

					echo '<hr><h2>Week</h2>';
					home_week();

					echo '<hr><h2>Mouth</h2>';
					home_month();
					}

			include("sidebar.php");
			include("footer.php");
		?>