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
		
		if ($user_info['uf_szallitas_ua']==1) $type = "szamlazasi"; else $type="szallitasi";
		
		$ui_nev = $user_info['uf_vnev']." ".$user_info['uf_knev'];
		$ui_orszag = $user_info["uf_".$type."_orszag"];
		$ui_irsz = $user_info["uf_".$type."_irsz"];
		$ui_telepules = $user_info["uf_".$type."_telepules"];
		$ui_utca = $user_info["uf_".$type."_utca"];
		$ui_hsz = $user_info["uf_".$type."_hsz"];
        $fee_arr = [2000 / $eurorate, 2000];
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
                            <!-- <ol class="breadcrumb__list">
                                <li class="breadcrumb__spaceship-safe-area" role="presentation"></li>
                                <li class="breadcrumb__item breadcrumb__item--parent breadcrumb__item--first">
                                    <a href="index.html" class="breadcrumb__item-link">Home</a>
                                </li>
                                <li class="breadcrumb__item breadcrumb__item--parent">
                                    <a href="" class="breadcrumb__item-link">Breadcrumb</a>
                                </li>
                                <li class="breadcrumb__item breadcrumb__item--current breadcrumb__item--last" aria-current="page">
                                    <span class="breadcrumb__item-link">Current Page</span>
                                </li>
                                <li class="breadcrumb__title-safe-area" role="presentation"></li>
                            </ol> -->
                        </nav>
                        <h1 class="block-header__title">Pénztár</h1>
                    </div>
                </div>
            </div>
            <div class="checkout block">
                <div class="container container--max--xl">
                    <form action="save-order.php" method="post" class="row">
                        <div class="col-12 col-lg-6 col-xl-7">
                            <div class="card mb-lg-0">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Szállítási információk</h3>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="checkout-last-name">Név</label>
                                            <input required type="text" class="form-control" name="checkout_full_name" id="checkout-full-name" value="<?=$ui_nev; ?>" placeholder="Név" name="szallitasi_nev">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout-country">Ország</label>
                                        <select name="checkout_country" class="form-control form-control-select2" value="<?=$ui_orszag; ?>" name="szallitasi_orszag">
                                            <option value="Magyarország">Magyarország</option>
                                            <option value="Ausztria">Ausztria</option>
                                            <option value="Szlovákia">Szlovákia</option>
                                            <option value="Ukrajna">Ukrajna</option>
                                            <option value="Románia">Románia</option>
                                            <option value="Szerbia">Szerbia</option>
                                            <option value="Horvátország">Horvátország</option>
                                            <option value="Szlovénia">Szlovénia</option>
                                            <option value="Németország">Németország</option>
                                        </select>
                                    </div>
                                    <div class="form-row">
									 <div class="form-group col-md-6">
                                        <label for="checkout-postcode">Irányítószám</label>
                                        <input required type="text" class="form-control" name="checkout_postcode" value="<?=$ui_irsz; ?>">
									 </div>
									 <div class="form-group col-md-6">
                                        <label for="checkout-city">Település</label>
                                        <input required type="text" class="form-control" name="checkout_city" value="<?=$ui_telepules; ?>">
									 </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout-street-address">Utca</label>
                                        <input required type="text" class="form-control" name="checkout_street_address" placeholder="Utca" value="<?=$ui_utca; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout-address">Házszám, emelet, ajtó stb. </label>
                                        <input required type="text" class="form-control" name="checkout_address" value="<?=$ui_hsz; ?>">
                                    </div>
									<input type="hidden" id="shipping_fee" name="shipping_fee" value=<?=$fee_arr[$_SESSION['frontenduser']['paymode']] ?>>
                                    <!-- <div class="form-group">
                                        <div class="form-check">
                                            <span class="input-check form-check-input">
                                                <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox" name="checkout-create-account">
                                                    <span class="input-check__box"></span>
                                                    <span class="input-check__icon"><svg width="9px" height="7px">
                                                            <path d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                            <label class="form-check-label" for="checkout-create-account">Hozzon létre egy fiókot?</label>
                                        </div>
                                    </div> -->
									<div class="form-group">
                                        <label for="checkout-comment">Rendelési megjegyzések <span class="text-muted">(Választható)</span></label>
                                        <textarea name="checkout-comment" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
                            <div class="card mb-0">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Rendelés részletei</h3>
                                    <table class="checkout__totals">
                                        <thead class="checkout__totals-header">
                                            <tr>
                                                <th>Termék</th>
                                                <th>Összeg</th>
                                            </tr>
                                        </thead>
                                        <tbody class="checkout__totals-products">
                                            <?php foreach ($pResult as $key => $value) { ?>
                                                <?php $price = intval($value['product_price']*100)/100; ?>
                                                <tr>
                                                    <td><?php echo $value['product_name']." ".$value['product_model']." × ".$value['product_quantity']; ?></td>
                                                    <td><?php if ($currencyunit==" Ft") $p = number_format($price, 0, ".", " "); else $p=$price; echo $p.$currencyunit; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tbody class="checkout__totals-subtotals">
                                            <tr>
                                                <th>Részösszeg</th>
                                                <th><?php if ($currencyunit==" Ft") $p = number_format($allprice, 0, ".", " "); else $p=$allprice; echo $p.$currencyunit; ?></th>
                                            </tr>
                                        </tbody>
                                        <tbody class="checkout__totals-subtotals">
											<tr><th style="padding-left: 0; text-align: left;"><h4>Szállítási mód</h4></th></tr>
                                            <tr>
                                                <th><label><input type="radio" onclick="countTotal(<?=$allprice?>, <?=number_format($fee_arr[$_SESSION['frontenduser']['paymode']], 2, ".", "")?>, '<?=$currencyunit?>')" name="shipping" value="Delivery service" checked> Futárszolgálat</label></th>
                                                <td><?php if ($currencyunit==" Ft") $p = number_format($fee_arr[$_SESSION['frontenduser']['paymode']], 0, ".", " "); else $p=number_format($fee_arr[$_SESSION['frontenduser']['paymode']], 2, ".", " "); echo $p.$currencyunit; ?></td>
                                            </tr>
                                            <tr>
                                                <th><label><input type="radio" onclick="countTotal(<?=$allprice?>, 0, '<?=$currencyunit?>')" name="shipping" value="Personal receipt"> Személyes átvétel</label></th>
                                                <td><?php echo "0".$currencyunit; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="checkout__totals-footer">
                                            <tr>
                                                <th>Összesen</th>
                                                <td><b style="font-size: 16px"><span id="fulltotal"><?php if ($currencyunit==" Ft") $p = number_format($allprice+$fee_arr[$_SESSION['frontenduser']['paymode']], 0, ".", " "); else $p=number_format($allprice+$fee_arr[$_SESSION['frontenduser']['paymode']], 2, ".", " "); echo $p.$currencyunit; ?>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="checkout__payment-methods payment-methods">
                                        <ul class="payment-methods__list">
                                            <li class="payment-methods__item payment-methods__item--active">
                                                <label class="payment-methods__item-header">
                                                    <span class="payment-methods__item-radio input-radio">
                                                        <span class="input-radio__body">
                                                            <input required class="input-radio__input" name="checkout_payment_method" value="Cash on delivery" type="radio" checked>
                                                            <span class="input-radio__circle"></span>
                                                        </span>
                                                    </span>
                                                    <span class="payment-methods__item-title">Közvetlen banki átutalás</span>
                                                </label>
                                                <div class="payment-methods__item-container">
                                                    <div class="payment-methods__item-details text-muted">
                                                    A rendelés végösszegét az alábbi számlaszámra utalhatja át: 11704007-22036984 (OTP Bank). Kérjük a megrendelés azonosítóját a közlemény rovatba beírni. Rendelését csak az utalás beérkezését követően dolgozzuk fel.
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- <li class="payment-methods__item">
                                                <label class="payment-methods__item-header">
                                                    <span class="payment-methods__item-radio input-radio">
                                                        <span class="input-radio__body">
                                                            <input class="input-radio__input" name="checkout_payment_method" type="radio">
                                                            <span class="input-radio__circle"></span>
                                                        </span>
                                                    </span>
                                                    <span class="payment-methods__item-title">Ellenőrizze a kifizetéseket</span>
                                                </label>
                                                <div class="payment-methods__item-container">
                                                    <div class="payment-methods__item-details text-muted">
                                                        Kérjük, küldjön csekket az üzlet neve, áruház utca, áruház dropcart__item-image image image--type--product, áruház állam / megye, áruház irányítószáma címre.
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="payment-methods__item">
                                                <label class="payment-methods__item-header">
                                                    <span class="payment-methods__item-radio input-radio">
                                                        <span class="input-radio__body">
                                                            <input class="input-radio__input" name="checkout_payment_method" type="radio">
                                                            <span class="input-radio__circle"></span>
                                                        </span>
                                                    </span>
                                                    <span class="payment-methods__item-title">Utánvétes fizetés</span>
                                                </label>
                                                <div class="payment-methods__item-container">
                                                    <div class="payment-methods__item-details text-muted">
                                                        Fizessen készpénzzel szállításkor.
                                                    </div>
                                                </div>
                                            </li> -->
                                            <li class="payment-methods__item">
                                                <label class="payment-methods__item-header">
                                                    <span class="payment-methods__item-radio input-radio">
                                                        <span class="input-radio__body">
                                                            <input required class="input-radio__input" name="checkout_payment_method" value="Paylike on delivery" type="radio">
                                                            <span class="input-radio__circle"></span>
                                                        </span>
                                                    </span>
                                                    <span class="payment-methods__item-title">Paylike</span>
                                                </label>
                                                <div class="payment-methods__item-container">
                                                    <div class="payment-methods__item-details text-muted">
                                                    Fizessen biztonságosan bankkártyával.
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="checkout__agree form-group">
                                        <div class="form-check">
                                            <span class="input-check form-check-input">
                                                <span class="input-check__body">
                                                    <input class="input-check__input" required type="checkbox" name="checkout-terms">
                                                    <span class="input-check__box"></span>
                                                    <span class="input-check__icon"><svg width="9px" height="7px">
                                                            <path d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                            <label class="form-check-label" for="checkout-terms">
                                                Elolvastam és elfogadom a weboldal feltételeit</a>
                                            </label>
                                        </div>
                                    </div>
                                    <?php if ($allprice > 0) { ?>
                                        <input type="submit" name="submit" class="btn btn-primary btn-xl btn-block" value="Rendelés">
                                    <?php } else { ?>
                                        <input type="submit" name="submit" disabled class="btn btn-primary btn-xl btn-block" value="Rendelés">
                                    <?php } ?>
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

<script>
	function countTotal(a, b, currency)
	{
		var t = parseFloat(a)+parseFloat(b);
		var ft = String(t.toFixed(2));
		document.getElementById("fulltotal").innerHTML = ft+currency;
		document.getElementById("shipping_fee").value = b;
	}
</script>