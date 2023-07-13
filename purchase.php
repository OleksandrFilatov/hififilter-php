<?php 
	session_start();
  date_default_timezone_set('Europe/Budapest');
  require ("dbcon.php");
	
	if (isset($_POST['submit']) && isset($_SESSION['frontenduser']))
	{
    $sql="SELECT * FROM kosar WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
    $result=mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row == null) {
        $sql1 = "INSERT INTO kosar (u_id, product_name, product_id, product_model, product_image_url, purchase_date, product_gencode, product_price, product_quantity, purchase_state) 
        
        VALUES
        
        ('".$_SESSION['frontenduser']['userid']."', 
        '".$_POST['product_name']."', 
        '".$_POST['product_id']."', 
        '".$_POST['product_model']."', 
        '".$_POST['product_image_url']."', 
        '".date('Y.m.d H:i:s')."',
        '".$_POST['product_gencode']."', 
        ".$_POST['product_price'].", 1, 0)";
        
        // echo $sql1;
        
        mysqli_query($con, $sql1);
    } else {
        $newquantity = intval($row['product_quantity']) + 1;
        $sql = "UPDATE kosar SET product_quantity=".$newquantity.", purchase_date='".date('Y.m.d H:i:s')."' WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
        mysqli_query($con, $sql);
    }
	}
  header("Location: product.php?id=".$_POST['product_id']);
?>