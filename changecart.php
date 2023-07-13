<?php 
	session_start();
  date_default_timezone_set('Europe/Budapest');
  require ("dbcon.php");
	
	if (isset($_SESSION['frontenduser']))
	{
    $sql="SELECT * FROM kosar WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
    $result=mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $allprice = 0;

    if ($_POST['kind'] == 'add') {
      $newquantity = intval($row['product_quantity']) + 1;
      $sql = "UPDATE kosar SET product_quantity=".$newquantity.", purchase_date='".date('Y.m.d H:i:s')."' WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
      mysqli_query($con, $sql);
      $chagedprice = intval($newquantity * $row['product_price'] * 100) / 100;
      $sql="SELECT * FROM kosar WHERE purchase_state=0";
      $result=mysqli_query($con, $sql);
      foreach ($result as $key => $value) {
        $allprice += $value['product_price'] * $value['product_quantity'];
      }
      $allprice = intval($allprice * 100) / 100;
      echo $chagedprice."_".$allprice;
    } else if ($_POST['kind'] == 'sub') {
      $newquantity = intval($row['product_quantity']) - 1;
      if($newquantity < 1) {
        echo 'fail';
      } else {
        $sql = "UPDATE kosar SET product_quantity=".$newquantity.", purchase_date='".date('Y.m.d H:i:s')."' WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
        mysqli_query($con, $sql);
        $chagedprice = intval($newquantity * $row['product_price'] * 100) / 100;
        $sql="SELECT * FROM kosar WHERE purchase_state=0";
        $result=mysqli_query($con, $sql);
        foreach ($result as $key => $value) {
          $allprice += $value['product_price'] * $value['product_quantity'];
        }
        $allprice = intval($allprice * 100) / 100;
        echo $chagedprice."_".$allprice;
      } 
    } else if ($_POST['kind'] == 'delete') {
      $sql="DELETE FROM kosar WHERE product_model='".$_POST['product_model']."' AND purchase_state=0";
      mysqli_query($con, $sql);
      $sql="SELECT * FROM kosar WHERE purchase_state=0";
      $result=mysqli_query($con, $sql);
      foreach ($result as $key => $value) {
        $allprice += $value['product_price'] * $value['product_quantity'];
      }
      $allprice = intval($allprice * 100) / 100;
      echo $allprice;
    }
  }
?>