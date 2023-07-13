<?php 
	session_start();
	require("dbcon.php");
	
	if (isset($_POST['resetsubmit']))
	{
		$acc=$_POST['email'];
		$ac = rand(10000, 99999);
		$r = mysqli_query($con, "SELECT * FROM ugyfelek WHERE uf_email='".$_POST['email']."'");
		$userrow = mysqli_fetch_assoc($r);
		$r = mysqli_query($con, "UPDATE ugyfelek SET uf_resetcode = '$ac' WHERE uf_email='".$_POST['email']."'");
		$to = $_POST['email'];
		$headers = "From: HifiFilter <info@hififilter.hu>". PHP_EOL ."Content-Type: text/html; charset=UTF-8";
		$subject = "HifiFilter – Elfelejtett jelszó";
		$text = "<p>Kedves ".$userrow['uf_vnev']." ".$userrow['uf_knev']."!</p><p>A <a href='https://hififilter.hu' target=_blank'>HifiFilter</a> oldalon jelszó-visszaállítást kértek a fiókjához. Ha ez Ön volt, a jelszavát megváltoztathatja <a href='https://creativesales.hu/munkalatok/hififilter/password-reset.php?id=".$userrow['uf_id']."&ac=$ac' target=_blank>ide kattintva!</a></p><p>Ha a link nem működik, az alábbi hivatkozást másolja be a böngészője címsorába: https://creativesales.hu/munkalatok/hififilter/password-reset.php?id=".$userrow['uf_id']."&ac=$ac</p><p>Ha a jelszóváltoztatást nem Ön kérte, vagy mégsem kíván változtatni, hagyja figyelmen kívül ezt az üzenetet!</p><p>Üdvözlettel,<br>a HifiFilter csapata</p>";
		mail ($to, $subject, $text, $headers);
		header("Location: password-reset.php?check");
	}
	else if (isset($_POST['pwsubmit']))
	{
		mysqli_query($con, "UPDATE ugyfelek SET uf_jelszo = '".md5($_POST['pw1'])."', uf_resetcode = '' WHERE uf_id = ".$_POST['id']);
		
		header("Location: password-reset.php?done");
	}
?>