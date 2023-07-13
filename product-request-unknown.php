<?php 
	session_start();
	require ("dbcon.php"); 
    if (!isset($_SESSION['frontenduser']))
    header("Location: index.php");
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
        $sql="SELECT * FROM ugyfelek WHERE uf_id='".$_SESSION['frontenduser']['userid']."'";
        $userresult=mysqli_query($con, $sql);
        $user_info=mysqli_fetch_assoc($userresult);
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>HifiFilter</title>
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
       <div class="site__body">
            <div class="block-header block-header--has-breadcrumb block-header--has-title">
                <div class="container">
                    <div class="block-header__body">
                        <nav class="breadcrumb block-header__breadcrumb" aria-label="breadcrumb" style="padding-top: 60px">
                        </nav>
                        <h1 class="block-header__title">Szűrőt keres? Segítünk!</h1>
                    </div>
                </div>
            </div>
            <div class="checkout block">
                <div class="container container--max--xl">
                    <form action="save-req.php" method="post" enctype='multipart/form-data'>
                        <div class="col-8 m-auto">
                            <div class="card mb-lg-0">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Adja meg a termék adatait</h3>
                                    <div class="form-row">
									                    <div class="form-group col-md-6">
                                        <label for="last_name">Vezetéknév</label>
                                        <input required type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user_info['uf_vnev']; ?>">
									                    </div>
									                    <div class="form-group col-md-6">
                                        <label for="first_name">Keresztnév</label>
                                        <input required type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user_info['uf_knev']; ?>">
									                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_address">Email</label>
                                        <input required type="email" class="form-control" name="email_address" value="<?php echo $user_info['uf_email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_num">Telefonszám</label>
                                        <input required type="text" class="form-control" name="phone_num" value="<?php echo $user_info['uf_telefon']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_num">Csatoljon képet a jelenlegi szűrőről</label>
                                        <input type="file" required class="form-control" name="images[]" id="images" multiple>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Leírás</label>
                                        <textarea placeholder="Adja meg a szűrő méreteit, milyen gépjárműbe, eszközbe szeretné beszerelni." name="comment" class="form-control" rows="10"></textarea>
                                    </div>
                                    <input type="hidden" name="product_type" value="2">
                                    <input type="submit" name="submit" class="btn btn-primary btn-xl btn-block" value="Árajánlatot kérek">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="block-space block-space--layout--before-footer"></div>
        </div>
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