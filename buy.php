<?php 
	include ('function.min.php'); // fonksiyon dosyası
?>
<html>
	<head>
		<title>Buy Now / Şimdi Satın Al - SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="Bu scripte sahip ol! Kendi Ağını Kur! Simple social network script">
		<meta name="keywords" content="buy, satın al, simple, social, network, script, social network, social sharing, sosyal ağ scripti, sosyal ağ, scripti">
		<link rel="author" href="Uğur KILCI">
		
		<link rel="dns-prefetch" href="https://google-analytics.com/">
		<link rel="dns-prefetch" href="https://www.google-analytics.com/">
		<link rel="dns-prefetch" href="https://fonts.googleapis.com/">
		<link rel="dns-prefetch" href="https://pbs.twimg.com/">
		
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta http-equiv="cleartype" content="on">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<style type="text/css">
			.big{
				font-size: 30px;
			}
		</style>
	</head>
	<body>
		<?php 
			include("header.php");

			login(); // giriş yapma işlemi
			register(); // kayıt yapma işlemi

			echo '
			<h2>Şimdi Satın Al</h2>
			<p>
				<storng>Script Özellikleri</strong><br />
				<ul>
					<li>Kolay Kurulum</li>
					<li>Günlük Popüler Başlıklar</li>
					<li>Haftalık Popüler Başlıklar</li>
					<li>Aylık Popüler Başlıklar</li>
					<li>Giriş Sistemi</li>
					<li>Kayıt Sistemi</li>
					<li>Profil Sistemi</li>
					<li>Üye Paylaşımlarını Profilde Görme</li>
					<li>Profil Resmi Ekleme</li>
					<li>Profil Genel Ayarları Düzenleme</li>
					<li>Profil Parola Ayarları Düzenleme</li>
					<li>Sınırsız Başlık/Yazı Paylaşma</li>
					<li>Başlık Silme</li>
					<li>Başlık Beğeni Sistemi</li>
					<li>Facebook da paylaşma</li>
					<li>Twitter da paylaşma</li>
					<li>Google+ da paylaşma</li>
					<li>Sınırsız Yorum Yapma Sistemi</li>
					<li>Genel Sayfalama Sistemi</li>
					<li>404 Hata Sayfası</li>
					<li>Temel Seo Özelliği</li>
					<li>Temel Güvenlik Sistemi</li>
				</ul>
				<storng>Kullanılan Teknolojiler</strong><br />
				<ul>
					<li>Php</li>
					<li>Mysql</li>
					<li>Html</li>
					<li>Css</li>
					<li>.Htaccess</li>
					<li>Bootstrap</li>
					<li>uShare</li>
				</ul>
				<storng>Kurulum Bilgileri</strong><br />
				<ul>
					<li>1. Tüm dosyaları FTP ile siteye yüklenin.</li>
					<li>2. Sql klasöründeki tüm .sql dosyalarını PhpMyAdmin e yükleyin.</li>
					<li>3. Ayar.php dosyasını açın. Localhost/dbname/root/pass gibi yerleri gerekli şekilde doldurunuz.</li>
					<li>Tebrikler, Kendi Ağınızı Kurdunuz. :)</li>
				</ul>
				<small>30 Gün Boyunca Sadece</small><br />
				<del>40 TL</del> <strong class="big">15 TL</strong><br /><br />
				<small>Not: 50. kişiye BEDAVA verilecektir. Elini çabuk tut. 50. kişi sen olabilirsin!</small><br /><br />
				<a href="mailto:ugurbocugu8@gmail.com" class="btn m2" target="_blank">Şimdi Satın Al! - Buy Now!</a>
				<br /><br />
				<a title="Script" target="_blank" href="http://www.scripti.org"><img border="0" alt="Script" src="http://www.scripti.org/images/scripti_yeralir.gif"></a>
			</p>
			<hr>
			';

			include("sidebar.php");
			include("footer.php");
		?>