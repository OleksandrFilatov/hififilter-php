<?php 
	session_start();
	require ("dbcon.php"); 

    $allprice = 0;
    $alllength = 0;
    if (isset($_SESSION['frontenduser'])) {
        if($_SESSION['frontenduser']['category'] == 1) {
            $sql="SELECT ba_ertek FROM beallitasok WHERE ba_nev='bronz-arres'";
        } else if ($_SESSION['frontenduser']['category'] == 2) {
            $sql="SELECT ba_ertek FROM beallitasok WHERE ba_nev='ezust-arres'";
        } else if ($_SESSION['frontenduser']['category'] == 3) {
            $sql="SELECT ba_ertek FROM beallitasok WHERE ba_nev='arany-arres'";
        }
        $result=mysqli_query($con, $sql);
        $margin=intval(mysqli_fetch_array($result)['ba_ertek']);
        $sql="SELECT ba_ertek FROM beallitasok WHERE ba_nev='eur-arfolyam'";
        $result=mysqli_query($con, $sql);
        $eurorate=intval(mysqli_fetch_array($result)['ba_ertek']);
        $leveltimes = 1 + $margin / 100;
        $taxtimes = [1, 1.27];
        $allrate = $leveltimes * $taxtimes[$_SESSION['frontenduser']['istax']];
        if ($_SESSION['frontenduser']['paymode'] == 1) $allrate *= $eurorate;
        $currencyunitarr = [' €', ' Ft'];
        $currencyunit = $currencyunitarr[$_SESSION['frontenduser']['paymode']];
        $sql="SELECT * FROM kosar WHERE u_id='".$_SESSION['frontenduser']['userid']."' AND purchase_state=0";
        $pResult=mysqli_query($con, $sql);
        foreach ($pResult as $key => $value) {
            $alllength += 1;
            $allprice += $value['product_price'] * $value['product_quantity'];
        }
        $allprice = intval($allprice * 100) / 100;
	}
	
	if (isset($_GET['quit']))
	{
		unset($_SESSION["frontenduser"]);
		header("Location: ".$_GET['continue']);
	}
	else
	if (isset($_POST['submit']))
	{
		$acc=$_POST['email'];
		$pass=md5($_POST['password']);
		require("dbcon.php");

		$sql="SELECT * FROM ugyfelek WHERE uf_email='$acc' AND uf_jelszo='$pass'";
		$result=mysqli_query($con, $sql);
		$row=mysqli_fetch_array($result);

        if ($row!=null)
		{
			if ($row['uf_vevoi_arszint'] == 0) $nemaktiv = true;
			else{
                $_SESSION["frontenduser"]["userid"]=$row['uf_id'];
				$_SESSION["frontenduser"]["email"]=$row['uf_email'];
				$_SESSION["frontenduser"]["name"]=$row['uf_vnev']." ".$row['uf_knev'];
                $_SESSION["frontenduser"]["istax"]=$row['uf_kozossegi_asz'];
                $_SESSION["frontenduser"]["category"]=$row['uf_vevoi_arszint'];
                $_SESSION["frontenduser"]["paymode"]=$row['uf_payment_mode'];
				mysqli_query($con, "UPDATE ugyfelek SET uf_utolso_bejelentkezes='".date('Y.m.d H:i:s')."' WHERE uf_id = ".$row['uf_id']);
				header("Location: ".$_POST['whereareyoufrom']);
				die();
			}
		}
		else
		{
			unset($_SESSION["frontenduser"]);
			if (isset($nemaktiv) && $nemaktiv == true)
				$_SESSION['autherror'] = "Ezt a regisztrációt még nem hagyták jóvá.";
			else
				$_SESSION['autherror'] = "Hibás felhasználónév vagy jelszó.";
			
		}
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>Bejelentkezés – HifiFilter</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i">
    <!-- css -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/owl-carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="vendor/photoswipe/default-skin/default-skin.css">
    <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style.header-spaceship-variant-one.css" media="(min-width: 1200px)">
    <link rel="stylesheet" href="css/style.mobile-header-variant-one.css" media="(max-width: 1199px)">
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
</head>

<body>
    <!-- site -->
    <div class="site">
		<?php 
            require("lib/Api.php");
            require ("header.php");
        ?>
        <!-- site__body -->
        <div class="site__body">
            <div class="block-space block-space--layout--after-header"></div>
            <div class="block">
                <div class="container">
				
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Bejelentkezés</h3>
									<?php if (isset($_SESSION['autherror'])) { ?>
									<p style="color: red; font-weight: bold"><?=$_SESSION['autherror']; unset ($_SESSION['autherror']); ?></p>
									<?php } ?>
									<form action="" method="post">
										<input type="hidden" name="whereareyoufrom" value="index.php">
                                        <div class="form-group">
                                            <label for="signin-email">Email cím</label>
                                            <input id="signin-email" name="email" type="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="signin-password">Jelszó</label>
                                            <input id="signin-password" name="password" type="password" class="form-control">
                                            <small class="form-text text-muted">
                                                <a href="password-reset.php">Elfelejtett jelszó?</a>
                                            </small>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="submit" name="submit" class="btn btn-primary mt-3">Bejelentkezés</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
						
                </div>
            </div>
            <div class="block-space block-space--layout--before-footer"></div>
        </div>
        <!-- site__body / end -->
		<?php require ("footer.php"); ?>
    </div>
    <!-- site / end -->
    <?php require ("mobilemenu.php"); ?>
	<?php require ("additional.php"); ?>
    <!-- scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendor/nouislider/nouislider.min.js"></script>
    <script src="vendor/photoswipe/photoswipe.min.js"></script>
    <script src="vendor/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="vendor/select2/js/select2.min.js"></script>
    <script src="js/number.js"></script>
    <script src="js/main.js"></script>
</body>

</html>