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
				
                <h2>Regisztráljon viszonteladónak a még nagyobb kedvezményekért!</h2>
                    <p>Regisztrált partnereink hozzáférést kapnak a hatalmas adatbázis minden tartalmához. Kereshetnek keresztreferencia illetve HIFI Filter szám alapján is. A találatok túlnyomó többségénél megtekinthetik a keresett termék méreteit és az adott szűrőtípus vagy szűrőcsoport képét is.<br>
                        Szintén megjelenítésre kerül a méreteken túl a termék saját kedvezményével csökkentett ára, valamint készletinformáció a keresett termék elérhetőségéről.<br>
                        Viszonteladóink személyreszabott kedvezményt kapnak, melynek mértéke függhet az egyszeri vásárlás mértékétől illetve a folyamatos együttműködés mértékétől.</p>

                <h2>A regisztráció menete:</h2>
                <p>Töltse ki a viszonteladói regisztráció űrlapot.<br>
                A leadott adatok alapján, amennyiben megfelel a minimális feltételeknek, elkészítjük és aktiváljuk viszonteladói profilját, amelynek elkészültekor értesítést küldünk a regisztrációnál megadott email címre.<p>

                <p>Viszonteladói regisztráció feltétele, hogy rendelkezzen érvényes vállalkozói adószámmal!</p>
                

			</div>
			</div>
			</div>
            <div class="block-space block-space--layout--after-header"></div>
            <div class="block">
                <div class="container">
				
					<?php /* Mivel felül is be lehet jelentkezni, ez a rész egyelőre kuka. 
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Bejelentkezés</h3>
                                    <form>
                                        <div class="form-group">
                                            <label for="signin-email">Email cím</label>
                                            <input id="signin-email" type="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="signin-password">Jelszó</label>
                                            <input id="signin-password" type="password" class="form-control">
                                            <small class="form-text text-muted">
                                                <a href="">Elfelejtett jelszó?</a>
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <span class="input-check form-check-input">
                                                    <span class="input-check__body">
                                                        <input class="input-check__input" type="checkbox" id="signin-remember">
                                                        <span class="input-check__box"></span>
                                                        <span class="input-check__icon"><svg width="9px" height="7px">
                                                                <path d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z" />
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </span>
                                                <label class="form-check-label" for="signin-remember">Emlékezz rám</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary mt-3">Bejelentkezés</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
				
					
					<div class="row">
					<div class="col-md-12 mt-4">
						<p style="text-align: center">– VAGY –</p>
					</div></div>
					
					*/ ?>
						
					<div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <form action="register-w.php" method="post" onsubmit="return validateForm()">
                                    <h3 id="regisztracio" class="card-title">Regisztráció</h3>
									<div class="row">

									<div class="col-md-4">
										<h5>Személyes adatok</h5>
                                        <div class="form-group">
                                            <label>Email cím</label>
                                            <input type="email" id="reg_email" required name="uf_email" onchange = "usedemail()" class="form-control">
                                        </div>
										<p id="usedemaildisplay"></p>
                                        <div class="form-group">
                                            <label>Jelszó</label>
                                            <input type="password" required name="uf_jelszo" onchange="pwcheck()" id="pw1" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Jelszó újra</label>
                                            <input type="password" required id="pw2" onchange="pwcheck()" class="form-control">
                                        </div>
										<p id="pwcheckresult"></p>
                                        <div class="form-group">
                                            <label>Vezetéknév</label>
                                            <input type="text" required name="uf_vnev" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Keresztnév</label>
                                            <input type="text" required name="uf_knev" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Telefonszám</label>
                                            <input type="text" required name="uf_telefon" class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Fizetési pénznem</label>
                                            <select name="uf_payment_mode" required id="uf_payment_mode" class="form-control">
												<option value="0">EUR</option>
												<option value="1">HUF</option>
											</select>
                                        </div>
                                        <div class="form-group">
										  <div class="form-check">
										  <input class="form-check-input" type="checkbox" value="1" name="uf_maganszemely" id="uf_maganszemely" onchange="valt(1)">
										  <label class="form-check-label" for="uf_maganszemely">
											Magánszemélyként regisztrálok
										  </label>
										</div>
                                        </div>
										<div id="ceges_informaciok">
                                        <div class="form-group">
                                            <label>Cégnév</label>
                                            <input type="text" required name="uf_cegnev" id="uf_cegnev" class="form-control">
                                        </div>
                                        <div class="form-group">
											<label>Adószám típusa</label>
											<div class="form-check">
												<input class="form-check-input" required type="radio" name="adotipus" checked value="adoszam" id="adoszamradio">
												<label class="form-check-label" for="adoszamradio">Adószám</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" required type="radio" name="adotipus" value="kozossegi" id="kozossegiadoszamradio">
												<label class="form-check-label" for="kozossegiadoszamradio">Közösségi adószám</label>
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="signup-confirm">Adószám</label>
                                            <input type="text" required name="uf_adoszam" id="uf_adoszam" class="form-control">
                                        </div>
										</div>
									</div>
									
									<div class="col-md-4">
										<h5>Számlázási adatok</h5>
                                        <div class="form-group">
                                            <label>Ország</label>
                                            <select name="uf_szamlazasi_orszag" required id="uf_szamlazasi_orszag" class="form-control">
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
										
										<div class="form-group">
                                            <label>Irányítószám</label>
                                            <input type="text" name="uf_szamlazasi_irsz" required class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Település</label>
                                            <input type="text" name="uf_szamlazasi_telepules" irequired class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Utca</label>
                                            <input type="text" name="uf_szamlazasi_utca" required class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Házszám, emelet, ajtó</label>
                                            <input type="text" name="uf_szamlazasi_hsz" required class="form-control">
                                        </div>

									</div>
									
									<div class="col-md-4">
   										<h5>Szállítási adatok</h5>
										<div class="form-group">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="1" name="szall_ua" id="szall_ua" onchange="valt(2)">
										  <label class="form-check-label" for="szall_ua">
											Megegyezik a számlázási adatokkal
										  </label>
										</div>
										</div>
										<div id="noneedtoask">
                                        <div class="form-group">
                                            <label>Ország</label>
                                            <select name="uf_szallitasi_orszag" id="uf_szallitasi_orszag" required class="form-control">
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
										
										<div class="form-group">
                                            <label>Irányítószám</label>
                                            <input type="text" name="uf_szallitasi_irsz" id="uf_szallitasi_irsz" required class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Település</label>
                                            <input type="text" name="uf_szallitasi_telepules" id="uf_szallitasi_telepules" required class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Utca</label>
                                            <input type="text"name="uf_szallitasi_utca" id="uf_szallitasi_utca" required class="form-control">
                                        </div>
										<div class="form-group">
                                            <label>Házszám, emelet, ajtó</label>
                                            <input type="text" name="uf_szallitasi_hsz" id="uf_szallitasi_hsz" required class="form-control">
                                        </div>
										</div>

									</div>
								
								
                                </div>
								<div class="row">
								<div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" name="submit" class="btn btn-primary mt-3">Regisztráció</button>
                                        </div>
								</div>
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

<script>
	function valt(mode)
	{
		if (mode == 1)
		{
			if (document.getElementById("uf_maganszemely").checked)
				document.getElementById("ceges_informaciok").style.display = "none";
			else
				document.getElementById("ceges_informaciok").style.display = "block";
			document.getElementById("uf_cegnev").required = 
			document.getElementById("adoszamradio").required =
			document.getElementById("kozossegiadoszamradio").required =
			document.getElementById("uf_adoszam").required = !document.getElementById("uf_maganszemely").checked;
		}
		else
		if (mode == 2)
		{
			if (!document.getElementById("szall_ua").checked)
				document.getElementById("noneedtoask").style.display = "block";
			else
				document.getElementById("noneedtoask").style.display = "none";
			document.getElementById("uf_szallitasi_orszag").required = 
			document.getElementById("uf_szallitasi_irsz").required = 
			document.getElementById("uf_szallitasi_telepules").required =
			document.getElementById("uf_szallitasi_utca").required =
			document.getElementById("uf_szallitasi_hsz").required = !document.getElementById("szall_ua").checked;
		}
	}
	
	function pwcheck()
	{
		var r = true;
		if (document.getElementById("pw1").value == document.getElementById("pw2").value)
		{
			document.getElementById("pwcheckresult").style.color = "green";
			document.getElementById("pwcheckresult").innerHTML = "&#10004; A megadott jelszavak megegyeznek.";
		}
		else
		{
			document.getElementById("pwcheckresult").style.color = "red";
			document.getElementById("pwcheckresult").innerHTML = "&#10006; A megadott jelszavak nem egyeznek.";
			r = false;
		}
		return r;
	}
	
	function usedemail()
	{
		var r = false;
		if (document.getElementById("reg_email").value != "")
		{		
			url = "mailcheck.php?email="+document.getElementById("reg_email").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var res = this.responseText.replace("\r\n", "");
				if (res == '0')
				{
					document.getElementById("usedemaildisplay").style.color = "green";
					document.getElementById("usedemaildisplay").innerHTML = "&#10004; Ez az e-mail cím regisztálható";
					r = true;
				}
				else
				{
					document.getElementById("usedemaildisplay").style.color = "red";
					document.getElementById("usedemaildisplay").innerHTML = "&#10006; Ezzel az e-mail címmel már történt regisztráció.";					
				}
			}
			};
			xhttp.open("GET", url, true);
			xhttp.send();
		}
		
		return r;
		
	}
	
	function validateForm()
	{
		var r = pwcheck();
		if (r) 
		{
			if (document.getElementById("pw1").value.length<8) 
			{
				r = false;
				alert ("A jelszónak legalább 8 karakter hosszúnak kell lennie.");
			}

			if (r) 
			{
				if (document.getElementById("usedemaildisplay").style.color == "red")
				{
					alert ("Ezzel az e-mail címmel már regisztráltak a rendszerbe.");
					r = false;
				}
			}			
		}
		return r;
	}
</script>