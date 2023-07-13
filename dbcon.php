<?php 
$con=mysqli_connect("localhost","hififilter",'6L7l9D9h',"hififilter");
// $con=mysqli_connect("localhost","root",'',"hififilter");
mysqli_query($con, "SET NAMES 'utf8'");	
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>
