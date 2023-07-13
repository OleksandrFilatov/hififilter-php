<?php 	
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		die();
	
	$uf = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ugyfelek WHERE uf_id = ".$_GET['id']));
	
	$to = $uf['uf_email'];
	$headers = "From: HifiFilter <kapcsolat@hifi-szuro.hu>". PHP_EOL ."Content-Type: text/html; charset=UTF-8";
	if ($_GET['state'] != 0)
	{
		$subject = "HifiFilter – Értesítés regisztráció jóváhagyásáról";
		$message = "Kedves Ügyfelünk!<br><br>Köszönjük, hogy érdeklődésével megtisztelt bennünket. Regisztrációját elfogadtuk! Most már bejelentkezhet a hifi-szuro.hu webáruházba a korábban megadott adatokkal.<br><br>Az oldalra belépve az összes funkció elérhető. <br><br>Bízunk benne, hogy szolgáltatásunkat hasznosnak találja és hozzájárulhatunk vállalkozása fejlődéséhez.<br><br>Üdvözlettel:<br>Jakab József<br>Ügyvezető";
	}
	else
	{
		$subject = "HifiFilter – Értesítés regisztráció jóváhagyásának visszavonásáról";
		$message = "regisztrációjának érvényességét visszavontuk. További információért keresse ügyfélszolgálatunkat";
	}
	$text = "<p>Kedves ".$uf['uf_vnev']." ".$uf['uf_knev']."!</p><p>A <a href='https://hifi-szuro.hu' target=_blank'>HifiFilter</a> oldalon történt $message.<p>Üdvözlettel,<br>a HifiFilter csapata</p>";
	mail ($to, $subject, $text, $headers);
?>