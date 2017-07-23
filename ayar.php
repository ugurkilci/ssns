<?php
	
	$host 	= "";
	$dbname = "";
	$root 	= "";
	$pass 	= "";

	try{
		$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;",$root, $pass);
	}catch(PDOExeption $error){
		echo $error->getMessage();
	}

?>