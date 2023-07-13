<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		header("Location: login.php");
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
    Rendelés részletei | HifiFilter Admin
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
                <h4 class="card-title"> ####### rendelés részletei</h4>
              </div>
              
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Kosár tartalma</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-shopping">
                    <thead class="">
                      <th class="text-center">
                      </th>
                      <th>
                        Termék megnevezése
                      </th>
                      <th>
                        Cikkszám
                      </th>
                      <th>
                        Nettó egységár
                      </th>
                      <th class="text-right">
                        Mennyiség
                      </th>
                      <th class="text-right">
                        Nettó összeg
                      </th>
                      <th class="text-right">
                        Lehetőségek
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="img-container">
                            <img src="https://hifi-filter.com/img/filtre/SO%2520115.jpg" alt="...">
                          </div>
                        </td>
                        <td class="td-name">
                          <a href="#jacket">4FLEETGUARDLF 4056 - OIL FILTER</a>
                          <br /><small>gencode: 3661200102597</small>
                        </td>
                        <td>
                          1SO 115
                        </td>
                        <td class="text-right">
                          3 390<small> Ft</small>
                        </td>
                        
                        <td  class="text-center"">
                           3 db<br>
                          <div class="btn-group">
                            <button class="btn btn-info btn-sm"> <i class="now-ui-icons ui-1_simple-delete"></i> </button>
                            <button class="btn btn-info btn-sm"> <i class="now-ui-icons ui-1_simple-add"></i> </button>
                          </div>
                        </td>
                        <td class="text-right">
                           10 170<small> Ft</small>
                        </td>

                        <td class="td-actions">
                          <button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-neutral">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                        </td>
                      </tr>
                      
                      <tr>
                        <td colspan="3">
                        </td>
                        <td class="td-total">
                          Termékek nettó értéke:
                        </td>
                        <td class="td-price">
                          10 170<small> Ft</small>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        </td>
                        <td class="td-total">
                          ÁFA:
                        </td>
                        <td class="td-price">
                          2 746<small> Ft</small>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        </td>
                        <td class="td-total">
                          Bruttó végösszeg
                        </td>
                        <td class="td-price">
                          12 916<small> Ft</small>
                        </td>
                      </tr>
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