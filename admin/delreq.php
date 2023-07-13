<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		die();
	
	mysqli_query($con, "DELETE FROM reqproduct WHERE rq_id = ".$_GET['id']);
?>