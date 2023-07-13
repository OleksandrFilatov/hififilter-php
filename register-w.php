<?php 
	require ("dbcon.php");
	
	if (isset($_POST['submit']))
	{
		
		if ($_POST['szall_ua'] == "1")
		{
			$sz_ua = 1;
			$sz_o = $sz_irsz = $sz_t = $sz_u = $sz_h = "";
		}
		else
		{
			$sz_ua = 0;
			$sz_o = $_POST['uf_szallitasi_orszag'];
			$sz_irsz = $_POST['uf_szallitasi_irsz'];
			$sz_t = $_POST['uf_szallitasi_telepules'];
			$sz_u = $_POST['uf_szallitasi_utca'];
			$sz_h = $_POST['uf_szallitasi_hsz'];
		}
		
		$_POST['adotipus'] == 'kozossegi'?$kozossegi = 1:$kozossegi=0;
		$_POST['uf_maganszemely'] == 1?$msz = 1:$msz=0;
		
		$sql = "INSERT INTO ugyfelek (uf_jelszo, uf_vnev, uf_knev, uf_email, uf_telefon, uf_maganszemely, uf_cegnev, uf_adoszam, uf_kozossegi_asz, uf_szamlazasi_orszag, uf_szamlazasi_irsz, uf_szamlazasi_telepules, uf_szamlazasi_utca, uf_szamlazasi_hsz, uf_szallitas_ua, uf_szallitasi_orszag, uf_szallitasi_irsz, uf_szallitasi_telepules, uf_szallitasi_utca, uf_szallitasi_hsz, uf_payment_mode) 
		
		VALUES
		
		('".md5($_POST['uf_jelszo'])."', 
		 '".$_POST['uf_vnev']."', 
		 '".$_POST['uf_knev']."', 
		 '".$_POST['uf_email']."', 
		 '".$_POST['uf_telefon']."', 
		 '".$_POST['uf_maganszemely']."', 
		 '".$_POST['uf_cegnev']."', 
		 '".$_POST['uf_adoszam']."', 
		 $kozossegi, 
		 '".$_POST['uf_szamlazasi_orszag']."', 
		 '".$_POST['uf_szamlazasi_irsz']."', 
		 '".$_POST['uf_szamlazasi_telepules']."', 
		 '".$_POST['uf_szamlazasi_utca']."', 
		 '".$_POST['uf_szamlazasi_hsz']."', 
		 '".$sz_ua."', 
		 '".$sz_o."', 
		 '".$sz_irsz."', 
		 '".$sz_t."', 
		 '".$sz_u."', 
		 '".$sz_h."',
		 '".intval($_POST['uf_payment_mode'])."')";
		 
		 echo $sql;
		 
		mysqli_query($con, $sql);
	}
	header("Location: reg-thankyou.php");
?>