<?php 
	session_start();
	require ("dbcon.php"); 
    if (!isset($_SESSION['frontenduser'])) {
        header("Location: index.php");
        return;
    }
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
                        <h1 class="block-header__title">Bevásárlókocsi</h1>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="container">
                    <div class="cart">
                        <div class="cart__table cart-table">
                            <table class="cart-table__table">
                                <thead class="cart-table__head">
                                    <tr class="cart-table__row">
                                        <th class="cart-table__column cart-table__column--image">KÉP</th>
                                        <th class="cart-table__column cart-table__column--product">TERMÉK</th>
                                        <th class="cart-table__column cart-table__column--price">ÁR</th>
                                        <th class="cart-table__column cart-table__column--quantity">MENNYISÉG</th>
                                        <th class="cart-table__column cart-table__column--total">ÖSSZESEN</th>
                                        <th class="cart-table__column cart-table__column--remove"></th>
                                    </tr>
                                </thead>
                                <tbody class="cart-table__body">
                                    <?php foreach ($pResult as $key => $value) { 
                                        $price = intval($value['product_price']*100)/100;
                                        $partallprice = intval($value['product_price']*$value['product_quantity']*100)/100;
                                    ?>
                                        <tr class="<?php echo str_replace(" ","_", $value['product_model'])." cart-table__row"; ?>">
                                            <td class="cart-table__column cart-table__column--image">
                                                <div class="image image--type--product">
                                                    <a href="product-full.html" class="image__body">
                                                        <img class="image__tag" width="80px" src="<?php echo $value['product_image_url']; ?>" alt="">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="cart-table__column cart-table__column--product">
                                                <a href="" class="cart-table__product-name"><?php echo $value['product_name']." ".$value['product_model']; ?></a>
                                                <!-- <ul class="cart-table__options">
                                                    <li>Color: Yellow</li>
                                                    <li>Material: Aluminium</li>
                                                </ul> -->
                                            </td>
                                            <td class="cart-table__column cart-table__column--price" data-title="Price"><?php if ($currencyunit==" Ft") $p = number_format($price, 0, ".", " "); else $p=$price; echo $p.$currencyunit ?></td>
                                            <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                                                <div class="cart-table__quantity input-number">
                                                    <input class="form-control input-number__input" disabled type="number" min="1" value="<?php echo $value['product_quantity'] ?>">
                                                    <div class="input-number__add" data-pay="<?php echo $_SESSION['frontenduser']['paymode']; ?>" data-price="<?php echo $value['product_price']?>" data-model="<?php echo $value['product_model']?>"></div>
                                                    <div class="input-number__sub" data-pay="<?php echo $_SESSION['frontenduser']['paymode']; ?>" data-price="<?php echo $value['product_price']?>" data-model="<?php echo $value['product_model']?>"></div>
                                                </div>
                                            </td>

                                            <td class="cart-table__column cart-table__column--total" data-title="Total"><?php if ($currencyunit==" Ft") $p = number_format($partallprice, 0, ".", " "); else $p=$partallprice; echo $p.$currencyunit ?></td>
                                            <td class="cart-table__column cart-table__column--remove">
                                                <button type="button" class="cart-table__remove btn btn-sm btn-icon btn-muted" data-model="<?php echo $value['product_model']?>" data-pay="<?php echo $_SESSION['frontenduser']['paymode']; ?> ">
                                                    <svg width="12" height="12">
                                                        <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4C11.2,9.8,11.2,10.4,10.8,10.8z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>   
                                    <?php } ?>
                                </tbody>
                                <tfoot class="cart-table__foot">
                                    <tr>
                                        <td colspan="6">
                                            <div class="cart-table__actions">
                                                <!-- <form class="cart-table__coupon-form form-row">
                                                    <div class="form-group mb-0 col flex-grow-1">
                                                        <input type="text" class="form-control form-control-sm" placeholder="Coupon Code">
                                                    </div>
                                                    <div class="form-group mb-0 col-auto">
                                                        <button type="button" class="btn btn-sm btn-primary">Apply Coupon</button>
                                                    </div>
                                                </form> 
                                                <div class="cart-table__update-button">
                                                    <a class="btn btn-sm btn-primary" href="">Kosár frissítése</a>
                                                </div> -->
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="cart__totals">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Kosár összesítés</h3>
                                    <table class="cart__totals-table">
                                        <thead>
                                            <tr>
                                                <th>Részösszeg</th>
                                                <td class="all_price"><?php if ($currencyunit==" Ft") $p = number_format($allprice, 0, ".", " "); else $p=$allprice; echo $p.$currencyunit; ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Szállítás</th>
                                                <td>
                                                    <?php echo "0.00".$currencyunit; ?>
                                                    <!-- <div>
                                                        <a href="">Calculate shipping</a>
                                                    </div> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Adó</th>
                                                <td><?php echo "0.00".$currencyunit; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Összesen</th>
                                                <td class="all_price"><?php if ($currencyunit==" Ft") $p = number_format($allprice, 0, ".", " "); else $p=$allprice; echo $p.$currencyunit; ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a href="penztar.php" class="btn btn-primary btn-xl btn-block">Pénztár</a>
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
    <script>
        $(".input-number__add").click(function() {
            var obj = this;
            var model = $(obj).attr("data-model");
            var price = $(obj).attr("data-price");
            var paymode = parseInt($(obj).attr("data-pay"));
            var jcurrencyunit = [' €', ' Ft'];
            $.ajax({
                url: 'changecart.php',
                method: 'post',
                data: {
                    kind: 'add',
                    product_model: model
                },
                success: function (msg) {
                    var cnt = parseInt($('.' + model.replace(" ", ("_"))).find('.dropcart__item-quantity').html());
                    $('.' + model.replace(" ", ("_"))).find('.dropcart__item-quantity').html(cnt+1);
                    $(obj).parent().parent().parent().find(".cart-table__column--total").html(msg.split('_')[0]+" Ft");
                    $('.all_price').html(msg.split('_')[1]+jcurrencyunit[paymode]);
                },
            });
        });
        $(".input-number__sub").click(function() {
            var obj = this;
            var model = $(obj).attr("data-model");
            var price = $(obj).attr("data-price");
            var paymode = parseInt($(obj).attr("data-pay"));
            var jcurrencyunit = [' €', ' Ft'];
            $.ajax({
                url: 'changecart.php',
                method: 'post',
                data: {
                    kind: 'sub',
                    product_model: model
                },
                success: function (msg) {
                    if (msg != 'fail') {
                        var cnt = parseInt($('.' + model.replace(" ", ("_"))).find('.dropcart__item-quantity').html());
                        $('.' + model.replace(" ", ("_"))).find('.dropcart__item-quantity').html(cnt-1);
                        $(obj).parent().parent().parent().find(".cart-table__column--total").html(msg.split('_')[0]+" Ft");
                        $('.all_price').html(msg.split('_')[1]+jcurrencyunit[paymode]);
                    }
                },
            });
        });
        $(".cart-table__remove").click(function() {
            var obj = this;
            var model = $(obj).attr("data-model");
            var paymode = parseInt($(obj).attr("data-pay"));
            var jcurrencyunit = [' €', ' Ft'];
            $.ajax({
                url: 'changecart.php',
                method: 'post',
                data: {
                    kind: 'delete',
                    product_model: model
                },
                success: function (msg) {
                    var cnt = parseInt($('.indicator__counter').html());
                    if(cnt > 1) {
                        $('.indicator__counter').html(cnt-1);
                    } else {
                        $('.indicator__counter').remove();
                    }
                    $('.' + model.replace(" ", ("_"))).remove();
                    $('.all_price').html(msg+jcurrencyunit[paymode]);
                },
            });
        });
    </script>
</body>

</html>