<?php require ("dbcon.php"); 
	$r = mysqli_query($con, "SELECT * FROM ugyfelek WHERE uf_email='".$_GET['email']."'");
	echo mysqli_num_rows($r);
?>