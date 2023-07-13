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
<html lang="hu" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>Rólunk – HifiFilter</title>
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
        <!-- site__mobile-header -->
        <?php 
            require("lib/Api.php");
            require ("header.php");
        ?>
        <!-- site__body -->
        <div class="site__body">
            <div class="about">
                <div class="about__body">
                    <div class="about__image">
                        <div class="about__image-bg" style="background-image: url('images/about-1903x1903.jpg');"></div>
                        <div class="decor about__image-decor decor--type--bottom">
                            <div class="decor__body">
                                <div class="decor__start"></div>
                                <div class="decor__end"></div>
                                <div class="decor__center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="about__card">
                        <div class="about__card-title">Rólunk</div>
                        <div class="about__card-text">
                        A HIFI FILTER csoport a legszélesebb szűrőkínálatot kínálja Európában akár napi szállítással. A HIFI FILTER mára a kompatibilis szűrők vezető márkanevévé vált. <br> <br> Minden technológiai és emberi erőforrásunkat mozgósítjuk annak biztosítása érdekében, hogy csapataink képzettek, tapasztaltak legyenek és a legjobb tudásuk szerint teljesítsenek.
                        </div>
                        <div class="about__card-author">Jakab József | ügyvezető</div>
                        <div class="about__card-signature">
                            <img src="images/hififilter.png" width="160" alt="">
                        </div>
                    </div>
                    <div class="about__indicators">
                        <div class="about__indicators-body">
                            <div class="about__indicators-item">
                                <div class="about__indicators-item-value">30 000</div>
                                <div class="about__indicators-item-title">féle raktárról elérhető szűrő</div>
                            </div>
                            <div class="about__indicators-item">
                                <div class="about__indicators-item-value">41 000</div>
                                <div class="about__indicators-item-title">m2 raktárkapacitás Európában</div>
                            </div>
                            <div class="about__indicators-item">
                                <div class="about__indicators-item-value">3,5 millió</div>
                                <div class="about__indicators-item-title">szűrő raktáron</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-space block-space--layout--divider-xl"></div>
			<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6" style="text-align: center">
				<!--<h1>Czím</h1>-->
				<h2>A legszélesebb választék a világon</h2>
				<p>Szűréstechnikai szakemberek vagyunk és elsajátítottuk a szűrési folyamatok technológiáit. Egész évben az Ön rendelkezésére állunk annak érdekében, hogy segítsük Önnek a berendezéséhez való megfelelő szűrők kiválasztásában.</p>
				<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4" style="text-align: left">
                <b>Szűrők járművekhez</b>
				<ul>
					<li>építőgépek</li>
					<li>mezőgazdasági gépek</li>
                    <li>buszok-kamionok</li>
					<li>emelőgépek</li>
                    <li>személyautók</li>
				</ul>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4" style="text-align: left">
                <b>Szűrők ipari alkalmazásokhoz</b>
				<ul>
					<li>légtechnika</li>
                    <li>porleválasztás</li>
                    <li>nagynyomású légrendszerek</li>
                    <li>hidraulika</li>
                    <li>folyadékszűrés</li>
                    <li>ipari gépek szűrői</li>
				</ul>
				</div>
                <p></p>
                <h2>Miért érdemes a HIFI FILTER mellett döntenie?</h2>
                <p>Csökkentheti árukészletét, használja tárolókapacitásunkat. Mivel rendkívül nagy választék érhető el polcról a HIFI FILTER kínálatából, ezért Önnek felesleges széles palettát raktáron tartania.<br>Takarítson meg időt és használja ki napi szállítási redszerünket és gyors reakciónkat.<br>Támaszkodjon szakértelmünkre! Elérhető üzletkötő és technikai támogatás, folyamatos minőségellenőrzés.</p>

			</div>
			</div>
            <!--<div class="block block-teammates">
                <div class="container container--max--xl">
                    <div class="block-teammates__title">Professional Team</div>
                    <div class="block-teammates__subtitle">Meet this is our professional team.</div>
                    <div class="block-teammates__list">
                        <div class="owl-carousel">
                            <div class="block-teammates__item teammate">
                                <div class="teammate__avatar">
                                    <img src="images/teammates/teammate1-206x206.jpg" alt="">
                                </div>
                                <div class="teammate__info">
                                    <div class="teammate__name">Michael Russo</div>
                                    <div class="teammate__position">Chief Executive Officer</div>
                                </div>
                            </div>
                            <div class="block-teammates__item teammate">
                                <div class="teammate__avatar">
                                    <img src="images/teammates/teammate2-206x206.jpg" alt="">
                                </div>
                                <div class="teammate__info">
                                    <div class="teammate__name">Samantha Smith</div>
                                    <div class="teammate__position">Account Manager</div>
                                </div>
                            </div>
                            <div class="block-teammates__item teammate">
                                <div class="teammate__avatar">
                                    <img src="images/teammates/teammate3-206x206.jpg" alt="">
                                </div>
                                <div class="teammate__info">
                                    <div class="teammate__name">Anthony Harris</div>
                                    <div class="teammate__position">Finance Director</div>
                                </div>
                            </div>
                            <div class="block-teammates__item teammate">
                                <div class="teammate__avatar">
                                    <img src="images/teammates/teammate4-206x206.jpg" alt="">
                                </div>
                                <div class="teammate__info">
                                    <div class="teammate__name">Katherine Miller</div>
                                    <div class="teammate__position">Marketing Officer</div>
                                </div>
                            </div>
                            <div class="block-teammates__item teammate">
                                <div class="teammate__avatar">
                                    <img src="images/teammates/teammate5-206x206.jpg" alt="">
                                </div>
                                <div class="teammate__info">
                                    <div class="teammate__name">Boris Gilmore</div>
                                    <div class="teammate__position">Engineer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!--<div class="block-space block-space--layout--divider-xl"></div>
            <div class="block block-reviews">
                <div class="container">
                    <div class="block-reviews__title">Testimonials</div>
                    <div class="block-reviews__subtitle">During our work we have accumulated<br>hundreds of positive reviews.</div>
                    <div class="block-reviews__list">
                        <div class="owl-carousel">
                            <div class="block-reviews__item">
                                <div class="block-reviews__item-avatar">
                                    <img src="images/testimonials/testimonial-1-190x190.jpg" alt="">
                                </div>
                                <div class="block-reviews__item-content">
                                    <div class="block-reviews__item-text">This division is not obsolete but has changed. Natural philosophy has split into the various natural sciences, especially astronomy, and cosmology. Moral philosophy has birthed the social sciences, but still includes value theory.</div>
                                    <div class="block-reviews__item-meta">
                                        <div class="block-reviews__item-rating">
                                            <div class="rating">
                                                <div class="rating__body">
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-reviews__item-author">
                                            Jessica Moore, CEO Meblya
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-reviews__item">
                                <div class="block-reviews__item-avatar">
                                    <img src="images/testimonials/testimonial-2-190x190.jpg" alt="">
                                </div>
                                <div class="block-reviews__item-content">
                                    <div class="block-reviews__item-text">Philosophical questions can be grouped into categories. These groupings allow philosophers. The groupings also make philosophy easier for students to approach.</div>
                                    <div class="block-reviews__item-meta">
                                        <div class="block-reviews__item-rating">
                                            <div class="rating">
                                                <div class="rating__body">
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-reviews__item-author">
                                            Pete Bridges, Truck driver
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-reviews__item">
                                <div class="block-reviews__item-avatar">
                                    <img src="images/testimonials/testimonial-3-190x190.jpg" alt="">
                                </div>
                                <div class="block-reviews__item-content">
                                    <div class="block-reviews__item-text">The ideas conceived by a society have profound repercussions on what actions the society performs. Philosophy yields applications such as those in ethics – applied ethics in particular – and political philosophy.</div>
                                    <div class="block-reviews__item-meta">
                                        <div class="block-reviews__item-rating">
                                            <div class="rating">
                                                <div class="rating__body">
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star rating__star--active"></div>
                                                    <div class="rating__star"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-reviews__item-author">
                                            Jeff Kowalski, CEO Stroyka
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
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