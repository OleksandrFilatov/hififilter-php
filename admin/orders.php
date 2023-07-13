<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
  $currencyunitarr = [' €', ' Ft'];
  $process_state = ['Feldolgozásra vár', 'Jóváhagyott'];
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		header("Location: login.php");
  $sql="SELECT * FROM orders a, ugyfelek b WHERE a.u_id = b.uf_id";
  $result=mysqli_query($con, $sql);
?>


  <!--

=========================================================
* Now UI Dashboard PRO - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard-pro
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Rendelések | HifiFilter Admin
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class=" sidebar-mini ">
  <div class="wrapper ">
    <?php require ("sidebar.php"); ?>
    <div class="main-panel" id="main-panel">
	  <?php require ("navbar.php"); ?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Megrendelések</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th class="text-center">
                        #ID
                      </th>
                      <th>
                        Megrendelő neve
                      </th>
                      <th>
                        Megrendelő címe
                      </th>
                      <th class="text-center">
                        Végösszeg
                      </th>
                      <th class="text-right">
                        Fizetési mód
                      </th>
                      <th class="text-right">
                        Rendelés állapota
                      </th>
                      <th class="text-right">
                        Lehetőségek
                      </th>
                    </thead>
                    <tbody>
                    <?php foreach ($result as $key => $value) { ?>
                      <tr>
                        <td class="text-center">
                          <?php echo $key+1; ?>
                        </td>
                        <td>
                          <b><?php echo $value['uf_vnev']." ".$value['uf_knev']." - ".$value['checkout_full_name']; ?></b><br><?php echo $value['uf_telefon']." || ".$value['uf_email']; ?>
                        </td>
                        <td>
                          <i class="now-ui-icons files_single-copy-04"></i> <?php echo $value['uf_szamlazasi_irsz']." ".$value['uf_szamlazasi_utca'].", ".$value['uf_szamlazasi_hsz']; ?><br>
                          <i class="now-ui-icons shopping_delivery-fast"></i> <?php echo $value['checkout_postcode']." ".$value['checkout_city'].", ".$value['checkout_address']; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $value['checkout_all_price'].$currencyunitarr[$value['uf_payment_mode']]; ?>
                        </td>
                        <td class="text-right">
                          <?php echo $value['checkout_payment_method']; ?>
                        </td>
                        <td class="text-right">
                          <?php echo $process_state[$value['checkout_state']]; ?>
                        </td>
                        <td class="text-right">
                          <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm ">
                            <i class="now-ui-icons travel_info"></i>
                          </button>
                          <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm ">
                            <i class="now-ui-icons ui-1_send"></i>
                          </button>
                          <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm ">
                            <i class="now-ui-icons ui-1_check"></i>
                          </button>
                          <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm ">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require ("footer.php"); ?>
    </div>
  </div>
  
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="assets/js/plugins/sweetalert2.min.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="assets/js/plugins/bootstrap-datetimepicker.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="assets/js/plugins/nouislider.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
</body>

</html>