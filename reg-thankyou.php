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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>Regisztráció – HifiFilter</title>
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
            <div class="block-space block-space--layout--spaceship-ledge-height"></div>
            <div class="block order-success">
                <div class="container">
                    <div class="order-success__body">
                        <div class="order-success__header">
                            <div class="order-success__icon">
                                <svg width="100" height="100">
                                    <path d="M50,100C22.4,100,0,77.6,0,50S22.4,0,50,0s50,22.4,50,50S77.6,100,50,100z M50,2C23.5,2,2,23.5,2,50
        s21.5,48,48,48s48-21.5,48-48S76.5,2,50,2z M44.2,71L22.3,49.1l1.4-1.4l21.2,21.2l34.4-34.4l1.4,1.4L45.6,71
        C45.2,71.4,44.6,71.4,44.2,71z" />
                                </svg>
                            </div>
                            <h1 class="order-success__title">Köszönjük!</h1>
                            <div class="order-success__subtitle">Regisztrációját megkaptuk. Jelenleg még nem tud belépni, egy munkatársunk hamarosan jóváhagyja regisztrációját, amelyről emailben értesítjük.</div>
                            <div class="order-success__actions">
                                <a href="/" class="btn btn-sm btn-secondary">Vissza a kezdőlapra!</a>
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