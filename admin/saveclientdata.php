<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		die();
	if ($_POST['type'] == "1") {
		mysqli_query($con, "UPDATE ugyfelek SET uf_vevoi_arszint = ".$_POST['state']." WHERE uf_id=".$_POST['id']);
		echo "success";
	} else {
		mysqli_query($con, "UPDATE ugyfelek SET uf_payment_mode = ".$_POST['state']." WHERE uf_id=".$_POST['id']);
		echo "success";
	}
?>
