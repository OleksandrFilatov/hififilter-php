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
    <title>Elfelejtett jelszó – HifiFilter</title>
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
				
					<?php if (isset($_GET['check'])) { ?>

                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Elfelejtett jelszó</h3>
									<p>Az új jelszó generálásához szükséges teendőket elküldtük e-mailben. Kérjük, ellenőrizze e-mail fiókját és kattintson a benne található linkre a jelszó megváltoztatásához!</p>
                                        <div class="form-group mb-0">
                                            <button type="button" onclick="window.location.href='/'" class="btn btn-primary mt-3">Vissza a főoldalra</button>
                                        </div>
                                </div>
                            </div>
                        </div>
					</div>
					<?php } else if (isset($_GET['done'])) { ?>

                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Elfelejtett jelszó</h3>
									<p>A jelszavát megváltoztattuk. Most már bejelentkezhet.</p>
                                        <div class="form-group mb-0">
                                            <button type="button" onclick="window.location.href='/'" class="btn btn-primary mt-3">Vissza a főoldalra</button>
                                        </div>
                                </div>
                            </div>
                        </div>
					</div>
						 
					<?php } else if (isset($_GET['id']) && isset($_GET['ac'])) { ?>
					
					<?php $r = mysqli_query($con, "SELECT * FROM ugyfelek WHERE uf_id = ".$_GET['id']." AND uf_resetcode = ".$_GET['ac']);
						  if (mysqli_num_rows($r) == 0)
						  {
							  ?>
							  <div class="row">
								<div class="col-md-12 ">
									<div class="card">
										<div class="card-body card-body--padding--2">
											<h3 class="card-title">Elfelejtett jelszó</h3>
											<p>Ez a hivatkozás már nem működik – a jelszócsere már valószínűleg megtörtént.</p>
												<div class="form-group mb-0">
													<button type="button" onclick="window.location.href='/'" class="btn btn-primary mt-3">Vissza a főoldalra</button>
												</div>
										</div>
									</div>
								</div>
							</div>
						  <?php } else { ?>
						  
						<div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Elfelejtett jelszó</h3>
									<p>Írja be új jelszavát kétszer!</p>
									<p id="saysomething" style="color: red; font-weight: bold"></p>
									<form action="password-reset-w.php" method="post" id="pwform">
										<input type="hidden" name="id" value="<?=$_GET['id']; ?>">
										<input type="hidden" name="pwsubmit" value="1">
                                        <div class="form-group">
                                            <label for="pw1">Jelszó</label>
                                            <input id="pw1" autofocus name="pw1" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="pw2">Jelszó újra</label>
                                            <input id="pw2" autofocus name="pw2" type="password" class="form-control">
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="button" onclick="checkpw()" class="btn btn-primary mt-3">A jelszó megváltoztatása</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
						  
						  <?php } ?>
						  
					
					<?php } else { ?>
				
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body card-body--padding--2">
                                    <h3 class="card-title">Elfelejtett jelszó</h3>
									<p>Nem sikerül bejelentkeznie? Írja be az e-mail címét és e-mailben elküldjük az új jelszó generálásához szükséges teendőket!</p>
									<p id="saysomething" style="color: red; font-weight: bold"></p>
									<form action="password-reset-w.php" method="post" id="resetform">
										<input type="hidden" name="resetsubmit" value="1">
                                        <div class="form-group">
                                            <label for="signin-email">Email cím</label>
                                            <input id="signin-email" autofocus name="email" type="email" class="form-control">
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="button" onclick="check()" class="btn btn-primary mt-3">Új jelszó kérése</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
					
					<?php } ?>
						
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

	function checkpw()
	{
		if (document.getElementById("pw1").value != document.getElementById("pw2").value)
			document.getElementById("saysomething").innerHTML = "A jelszavak nem egyeznek.";
		else
			pwform.submit();
	}
	function check()
	{
		url = "mailcheck.php?email="+document.getElementById("signin-email").value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var res = this.responseText.replace("\r\n", "");
			if (res == '0')
			{
				
				document.getElementById("saysomething").innerHTML = "Ez az e-mail cím nincs regisztrálva a rendszerben.";
			}
			else
				resetform.submit();
		}
		};
		xhttp.open("GET", url, true);
		xhttp.send();
	}
	
	$(document).keypress(
	function(event){
    if (event.which == '13') {
      event.preventDefault();
	  check();
    }
	else
	{
		document.getElementById("saysomething").innerHTML = "";
	}
});
</script>