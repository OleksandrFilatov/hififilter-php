<?php 
	session_start();
	require ("dbcon.php"); 
    if (!isset($_SESSION['frontenduser']))
    header("Location: index.php");
		if (isset($_POST['submit']) && isset($_SESSION['frontenduser']))
		{
			$sql="SELECT ba_ertek FROM beallitasok WHERE ba_nev='eur-arfolyam'";
			$result1=mysqli_query($con, $sql);
			$eurorate=intval(mysqli_fetch_array($result1)['ba_ertek']);
			$totalproducts = "";
			$alltotalprice = 0;
			$sql="SELECT * FROM kosar WHERE u_id='".$_SESSION['frontenduser']['userid']."' AND purchase_state=0";
			$result=mysqli_query($con, $sql);
			foreach ($result as $key => $value) {
					$totalproducts = $totalproducts.$value['id']."_";
					$alltotalprice += $value['product_price'] * $value['product_quantity'];
			}
	        $currencyunitarr = [' €', ' Ft'];
			$currencyunit = $currencyunitarr[$_SESSION['frontenduser']['paymode']];

			//$fee = $_SESSION['frontenduser']['paymode'] == 0 ? 2000/$eurorate : 2000;
			$fee = $_POST['shipping_fee'];
			$alltotalprice += $fee;

			$sql = "UPDATE kosar SET purchase_state=1, purchase_date='".date('Y.m.d H:i:s')."' WHERE u_id='".$_SESSION['frontenduser']['userid']."' AND purchase_state=0";
			mysqli_query($con, $sql);

			$sql = "INSERT INTO orders (u_id, checkout_full_name, checkout_country, checkout_postcode, checkout_city, checkout_street_address, checkout_address, checkout_products, checkout_all_price, checkout_payment_method, checkout_date, checkout_state, checkout_shipping_method, checkout_shipping_fee, checkout_currency_unit) 
			
			VALUES
			
			('".$_SESSION['frontenduser']['userid']."', 
			'".$_POST['checkout_full_name']."', 
			'".$_POST['checkout_country']."', 
			'".$_POST['checkout_postcode']."', 
			'".$_POST['checkout_city']."', 
			'".$_POST['checkout_street_address']."', 
			'".$_POST['checkout_address']."', 
			'".$totalproducts."',
			'".$alltotalprice."',
			'".$_POST['checkout_payment_method']."', 
			'".date('Y.m.d H:i:s')."', 0,
			'".$_POST['shipping']."', 
			'".$_POST['shipping_fee']."',
			'".trim($currencyunit)."'
			)";
			
			//  echo $sql;
			
			mysqli_query($con, $sql);
			$inserted_id = $con->insert_id;
		}
    header("Location: order-success.php?id=".$inserted_id);
?>