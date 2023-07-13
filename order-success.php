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

				$productid = urlencode($_GET['id']);
				$sql="SELECT * FROM orders WHERE id='".$productid."'";
				$orderresult=mysqli_query($con, $sql);
        $order_info=mysqli_fetch_assoc($orderresult);

				$p_ids = explode("_", $order_info['checkout_products']);
				array_pop($p_ids);
				$str_ids = "";
				foreach($p_ids as $key => $val) {
					if($key == count($p_ids) - 1) {
						$str_ids .= $val;
					} else {
						$str_ids .= $val.",";
					}
				}
				$sql = "SELECT * FROM kosar WHERE id IN (".$str_ids.")";
				$result1 = mysqli_query($con, $sql);
				$order_total = 0;
				$fee_arr = [2000 / $eurorate, 2000];
				foreach($result1 as $key => $val) {
					$order_total += $val['product_price'] * $val['product_quantity'];
				}
				$alltotal = $order_total + $order_info['checkout_shipping_fee'];
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
            <div class="block-space block-space--layout--spaceship-ledge-height"></div>
            <div class="block order-success">
                <div class="container">
                    <div class="order-success__body">
                        <div class="order-success__header">
                            <div class="order-success__icon">
                                <svg width="100" height="100">
                                    <path d="M50,100C22.4,100,0,77.6,0,50S22.4,0,50,0s50,22.4,50,50S77.6,100,50,100z M50,2C23.5,2,2,23.5,2,50        s21.5,48,48,48s48-21.5,48-48S76.5,2,50,2z M44.2,71L22.3,49.1l1.4-1.4l21.2,21.2l34.4-34.4l1.4,1.4L45.6,71        C45.2,71.4,44.6,71.4,44.2,71z" />
                                </svg>
                            </div>
                            <h1 class="order-success__title">Köszönjük!</h1>
                            <div class="order-success__subtitle">Rendelését sikeresen leadta!</div>
                            <div class="order-success__actions">
                                <a href="index.php" class="btn btn-sm btn-secondary">Vissza a kezdőlapra!</a>
                            </div>
                        </div>
                        <div class="card order-success__meta">
                            <ul class="order-success__meta-list">
                                <li class="order-success__meta-item">
                                    <span class="order-success__meta-title">Rendelésszám:</span>
                                    <span class="order-success__meta-value"><?php echo "#".$productid; ?></span>
                                </li>
                                <li class="order-success__meta-item">
                                    <span class="order-success__meta-title">Rendelés dátuma:</span>
                                    <span class="order-success__meta-value"><?php echo $order_info['checkout_date']; ?></span>
                                </li>
                                <li class="order-success__meta-item">
                                    <span class="order-success__meta-title">Végösszeg:</span>
                                    <span class="order-success__meta-value"><?php echo number_format($alltotal, 0, "", " ").$currencyunit; ?></span>
                                </li>
                                <li class="order-success__meta-item">
                                    <span class="order-success__meta-title">Fizetési mód:</span>
                                    <span class="order-success__meta-value"><?php echo $order_info['checkout_payment_method']; ?></span>
                                </li>
                            </ul>
                        </div>
                        <div class="card">
                            <div class="order-list">
                                <table>
                                    <thead class="order-list__header">
                                        <tr>
                                            <th class="order-list__column-label" colspan="2">Termék megnevezése</th>
                                            <th class="order-list__column-quantity">Mennyiség</th>
                                            <th class="order-list__column-total">Összeg</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-list__products">
                                    <?php foreach($result1 as $key => $val) { ?>
                                        <tr>
                                            <td class="order-list__column-image">
                                                <div class="image image--type--product">
                                                    <a href="product-full.html" class="image__body">
                                                        <img class="image__tag" src="<?php echo $val['product_image_url']; ?>" alt="">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="order-list__column-product">
                                                <a href="product-full.html"><?php echo $val['product_name']; ?></a>
                                                <div class="order-list__options">
                                                    <ul class="order-list__options-list">
                                                        <li class="order-list__options-item">
                                                            <span class="order-list__options-label">
                                                                ID:
                                                            </span>
                                                            <span class="order-list__options-value">
                                                                <?php echo $val['product_model']; ?>
                                                            </span>
                                                        </li>
                                                        <li class="order-list__options-item">
                                                            <span class="order-list__options-label">
                                                            
                                                            </span>
                                                            <span class="order-list__options-value">
                                                                
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="order-list__column-quantity" data-title="Quantity:">
                                                <?php echo number_format($val['product_quantity'], 0, "", " "); ?>
                                            </td>
                                            <td class="order-list__column-total">
                                                <?php echo number_format($val['product_quantity']*$val['product_price'], 0, "", " ").$currencyunit; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tbody class="order-list__subtotals">
                                        <tr>
                                            <th class="order-list__column-label" colspan="3">Részösszeg</th>
                                            <td class="order-list__column-total"><?php if ($currencyunit==" Ft") $p = number_format($order_total, 0, ".", " "); else $p=number_format($order_total, 2, ".", " "); echo $p.$currencyunit; ?></td>
                                        </tr>
										<?php if ($order_info['checkout_shipping_method']=="Delivery service") { ?>
                                        <tr>
                                            <th class="order-list__column-label" colspan="3">Futárszolgálat</th>
                                            <td class="order-list__column-total"><?php if ($currencyunit==" Ft") $p = number_format($fee_arr[$_SESSION['frontenduser']['paymode']], 0, ".", " "); else $p=number_format($fee_arr[$_SESSION['frontenduser']['paymode']], 2, ".", " "); echo $p.$currencyunit; ?></td>
                                        </tr>
										<?php } else if ($order_info['checkout_shipping_method']=="Personal receipt") { ?>
                                        <tr>
                                            <th class="order-list__column-label" colspan="3">Személyes átvétel</th>
                                            <td class="order-list__column-total"><?php echo "0".$currencyunit; ?></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                    <tfoot class="order-list__footer">
                                        <tr>
                                            <th class="order-list__column-label" colspan="3">Végösszeg</th>
                                            <td class="order-list__column-total"><?php if ($currencyunit==" Ft") $p = number_format($alltotal, 0, ".", " "); else $p=number_format($alltotal, 2, ".", " "); echo $p.$currencyunit; ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="order-success__addresses">
                            <div class="order-success__address card address-card">
                                <div class="address-card__badge tag-badge tag-badge--theme">
                                    Szállítási cím
                                </div>
                                <div class="address-card__body">
                                    <div class="address-card__name"><?php echo $order_info['checkout_full_name']; ?></div>
                                    <div class="address-card__row">
                                       <?php echo $order_info['checkout_country']; ?><br>
                                       <?php echo $order_info['checkout_city']; ?><br>
                                       <?php echo $order_info['checkout_address']; ?>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Telefonszám</div>
                                        <div class="address-card__row-content"><?php echo $user_info['uf_telefon']; ?></div>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Email</div>
                                        <div class="address-card__row-content"><?php echo $user_info['uf_email']; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-success__address card address-card">
                                <div class="address-card__badge tag-badge tag-badge--theme">
                                    Számlázási adatok
                                </div>
                                <div class="address-card__body">
                                    <div class="address-card__name"><?php echo $user_info['uf_vnev']." ".$user_info['uf_knev']; ?></div>
                                    <div class="address-card__row">
                                        <?php echo $user_info['uf_szamlazasi_orszag']; ?><br>
                                        <?php echo $user_info['uf_szamlazasi_telepules']; ?><br>
                                        <?php echo $user_info['uf_szamlazasi_hsz']; ?>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Telefonszám</div>
                                        <div class="address-card__row-content"><?php echo $user_info['uf_telefon']; ?></div>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Email</div>
                                        <div class="address-card__row-content"><?php echo $user_info['uf_email']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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