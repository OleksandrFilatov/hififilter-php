<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		die();
	
	$state = mysqli_fetch_assoc(mysqli_query($con, "SELECT rq_state FROM reqproduct WHERE rq_id=".$_GET['id']))['rq_state'];
	$state==0?$state=1:$state=0;
	mysqli_query($con, "UPDATE reqproduct SET rq_state=$state WHERE rq_id = ".$_GET['id']);
	echo $state;
?>