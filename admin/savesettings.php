<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		die();
	
	$a1 = $_GET['a1'];
	$a2 = $_GET['a2'];
	$a3 = $_GET['a3'];
	
	if ($a1>100) $a1=100; else if ($a1<0) $a1=0;
	if ($a2>100) $a2=100; else if ($a2<0) $a2=0;
	if ($a3>100) $a3=100; else if ($a3<0) $a3=0;

	setSetting('bronz-arres', $a1);
	setSetting('ezust-arres', $a2);
	setSetting('arany-arres', $a3);
	
	echo $a1.",".$a2.",".$a3;
?>