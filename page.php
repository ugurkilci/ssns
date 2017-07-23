<?php 
	include("ayar.php"); // ayar dosyası
	include("function.min.php"); // fonksiyonlar
	include("ushare.php"); // paylaşım kodları
	page(); // page function

	if ($p) { // ?p= varsa siteyi göster
		$cek = $db->prepare("SELECT * FROM basliklar WHERE baslik_baslik_replace =:baslik_baslik_replace ");
		$cek->execute(array('baslik_baslik_replace'=>$p));
		$saydirma = $cek->rowCount();
		 
		if($saydirma >0){ // Eğer Başlık Varsa
?>
<html>
	<head>
		<title><?php echo $vericek["baslik_baslik"]; //  Yazının Başlığı ?> - SSNS - Simple Social Network Script</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/genel.css"/>
		
		<link rel="shortcut icon" href="resimler/ico.ico">
		<meta name="description" content="<?php 
			//Goruntulencek Metnin Tam Hali
			$detay = strip_tags($vericek["baslik_aciklama"]);
			//Var olan metin içindeki karakter sayısı
			$uzunluk = strlen($detay);
			//Kaç Karakter Göstermek İstiyorsunuz
			$limit = 140;
			//Uzun olan yer "devamı..." ile değişecek.
			if ($uzunluk > $limit) {
				$detay = substr($detay,0,$limit);
			}
			echo $detay ; //  Yazının Başlığı
		?>">
		<meta name="keywords" content="<?php echo str_replace(" ", ", ", $vericek["baslik_baslik"]); //  Anahtar Kelimler ?>simple, social, network, script, social network, social sharing, sosyal ağ scripti, sosyal ağ, scripti">
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
		<?php include("header.php"); ?>
		<a href="page?p=<?php echo $vericek["baslik_baslik_replace"]; // baslik link ?>" class="sharea"><h1><?php echo $vericek["baslik_baslik"];  // Başlık ?></h1></a>
		<p><?php echo $vericek["baslik_aciklama"]; // Açıklama ?></p>
		<a href="profile?u=<?php echo $vericek["baslik_sahip"]; ?>" class="sharea"><strong><?php echo $vericek["baslik_sahip"]; // Yazıyı Kim Yazdı ?></strong></a>
		 - 
		<em><small><?php echo $vericek["baslik_tarih"]; // Başlığın tarihi?></small></em>
		<?php
			if ($_SESSION) { // Eğer Giriş Yapılmışsa
			$like = $vericek["baslik_begen"]; // Beğeni sayısını AddLike değişkenine ekledik
			like(); // Başlığı beğen 
		?>
		<form action="" method="post"><!-- Beğeni Sistemi -->
			<input type="hidden" name="kod" value="<?php echo $like_code; // beğeni güvenlik kodu ?>" />
			<strong><?php echo $vericek["baslik_begen"]; /* Kaç kişi beğenmiş */ ?> Like</strong><br />
			<input type="submit" name="like" class="btn m2" value="+1 Like" />

			<a href="<?php echo ushare("fb"); ?>" class="btn m2" title="Facebook Da Paylaş!">Facebook</a>
			<a href="<?php echo ushare("twt"); ?>" class="btn m2" title="Twitter Da Paylaş!">Twitter</a>
			<a href="<?php echo ushare("gpls"); ?>" class="btn m2" title="Google+ Da Paylaş!">Google+</a>
		</form>
		
		<hr><h2>Comment</h2>
		<?php writecomment(); ?>
		<form action="" method="post"><!-- Yorum Sistemi -->
			<input type="hidden" name="kod" value="<?php echo $comment_code; // yorumun güvenlik kodu [comm = comment] ?>" />
			<textarea name="comment" class="form-control" placeholder="Do Comment Now!"></textarea>
			<input type="submit" name="comm" class="btn m2 add" value="Comment!" />
		</form>
		
		<?php }else{ /* Eğer Giriş Yapılmamışsa */ echo '<a href="login" class="btn m2 add" title="Please log in to comment!">Please log in to comment! ;)</a>'; } ?>
		<hr>

		<?php 
				comment(); // Yorum Listele 

				include("sidebar.php"); // sidebar
				include("footer.php"); // footer
				
				}else{ // Eğer Başlık Yoksa
					header("REFRESH:0;URL=404");
				}
			}else{ // Yoksa 
				header("REFRESH:0;URL=404"); // 404 sayfasına yönlendir
			}
		?>