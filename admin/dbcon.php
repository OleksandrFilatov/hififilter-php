<?php 
$con=mysqli_connect("localhost","hififilter",'6L7l9D9h',"hififilter");
// $con=mysqli_connect("localhost","root",'',"hififilter");
mysqli_query($con, "SET NAMES 'utf8'");	
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

function getSetting($ba_nev)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "SELECT ba_ertek FROM beallitasok WHERE ba_nev = '$ba_nev'"))['ba_ertek'];
}

function setSetting($ba_nev, $ba_ertek)
{
	global $con;
	mysqli_query($con, "UPDATE beallitasok SET ba_ertek = '$ba_ertek' WHERE ba_nev = '$ba_nev'");
}
?>

