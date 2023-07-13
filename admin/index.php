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
    Vezérlőpult | HifiFilter Admin
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
      <div class="panel-header panel-header-lg">
        <canvas id="bigDashboardChart"></canvas>
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="statistics">
                      <div class="info">
                        <div class="icon icon-primary">
                          <i class="now-ui-icons ui-2_chat-round"></i>
                        </div>
                        <h3 class="info-title">859</h3>
                        <h6 class="stats-title">Messages</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="statistics">
                      <div class="info">
                        <div class="icon icon-success">
                          <i class="now-ui-icons business_money-coins"></i>
                        </div>
                        <h3 class="info-title"><small>$</small>3,521</h3>
                        <h6 class="stats-title">Today Revenue</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="statistics">
                      <div class="info">
                        <div class="icon icon-info">
                          <i class="now-ui-icons users_single-02"></i>
                        </div>
                        <h3 class="info-title">562</h3>
                        <h6 class="stats-title">Customers</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="statistics">
                      <div class="info">
                        <div class="icon icon-danger">
                          <i class="now-ui-icons objects_support-17"></i>
                        </div>
                        <h3 class="info-title">353</h3>
                        <h6 class="stats-title">Support Requests</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Active Users</h5>
                <h2 class="card-title">34,252</h2>
                <div class="dropdown">
                  <button type="button" class="btn btn-round btn-icon dropdown-toggle btn-outline-default no-caret" data-toggle="dropdown">
                    <i class="now-ui-icons loader_gear"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="activeUsers"></canvas>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/US.png">
                          </div>
                        </td>
                        <td>USA</td>
                        <td class="text-right">
                          2.920
                        </td>
                        <td class="text-right">
                          53.23%
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/DE.png">
                          </div>
                        </td>
                        <td>Germany</td>
                        <td class="text-right">
                          1.300
                        </td>
                        <td class="text-right">
                          20.43%
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/AU.png">
                          </div>
                        </td>
                        <td>Australia</td>
                        <td class="text-right">
                          760
                        </td>
                        <td class="text-right">
                          10.35%
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/GB.png">
                          </div>
                        </td>
                        <td>United Kingdom</td>
                        <td class="text-right">
                          690
                        </td>
                        <td class="text-right">
                          7.87%
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/RO.png">
                          </div>
                        </td>
                        <td>Romania</td>
                        <td class="text-right">
                          600
                        </td>
                        <td class="text-right">
                          5.94%
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="flag">
                            <img src="assets/img/BR.png">
                          </div>
                        </td>
                        <td>Brasil</td>
                        <td class="text-right">
                          550
                        </td>
                        <td class="text-right">
                          4.34%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Summer Email Campaign</h5>
                <h2 class="card-title">55,300</h2>
                <div class="dropdown">
                  <button type="button" class="btn btn-round dropdown-toggle btn-outline-default btn-icon no-caret" data-toggle="dropdown">
                    <i class="now-ui-icons loader_gear"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="emailsCampaignChart"></canvas>
                </div>
                <div class="card-progress">
                  <div class="progress-container">
                    <span class="progress-badge">Delivery Rate</span>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                        <span class="progress-value">90%</span>
                      </div>
                    </div>
                  </div>
                  <div class="progress-container progress-success">
                    <span class="progress-badge">Open Rate</span>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        <span class="progress-value">60%</span>
                      </div>
                    </div>
                  </div>
                  <div class="progress-container progress-info">
                    <span class="progress-badge">Click Rate</span>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 12%;">
                        <span class="progress-value">12%</span>
                      </div>
                    </div>
                  </div>
                  <div class="progress-container progress-warning">
                    <span class="progress-badge">Hard Bounce</span>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
                        <span class="progress-value">5%</span>
                      </div>
                    </div>
                  </div>
                  <div class="progress-container progress-danger">
                    <span class="progress-badge">Spam Report</span>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0.11%;">
                        <span class="progress-value">0.11%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Active Countries</h5>
                <h2 class="card-title">105</h2>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="activeCountries"></canvas>
                </div>
                <div id="worldMap" class="map"></div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="now-ui-icons ui-2_time-alarm"></i> Last 7 days
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Best Selling Products</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-shopping">
                    <thead class="">
                      <th class="text-center">
                      </th>
                      <th>
                        Product
                      </th>
                      <th>
                        Color
                      </th>
                      <th>
                        Size
                      </th>
                      <th class="text-right">
                        Price
                      </th>
                      <th class="text-right">
                        Qty
                      </th>
                      <th class="text-right">
                        Amount
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="img-container">
                            <img src="assets/img/saint-laurent.jpg" alt="...">
                          </div>
                        </td>
                        <td class="td-name">
                          <a href="#jacket">Suede Biker Jacket</a>
                          <br /><small>by Saint Laurent</small>
                        </td>
                        <td>
                          Black
                        </td>
                        <td>
                          M
                        </td>
                        <td class="td-number">
                          <small>€</small>3,390
                        </td>
                        <td class="td-number">
                          1
                        </td>
                        <td class="td-number">
                          <small>€</small>549
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="img-container">
                            <img src="assets/img/balmain.jpg" alt="...">
                          </div>
                        </td>
                        <td class="td-name">
                          <a href="#pants">Jersey T-Shirt</a>
                          <br /><small>by Balmain</small>
                        </td>
                        <td>
                          Black
                        </td>
                        <td>
                          M
                        </td>
                        <td class="td-number">
                          <small>€</small>499
                        </td>
                        <td class="td-number">
                          2
                        </td>
                        <td class="td-number">
                          <small>€</small>998
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="img-container">
                            <img src="assets/img/prada.jpg" alt="...">
                          </div>
                        </td>
                        <td class="td-name">
                          <a href="#nothing">Slim-Fit Swim Short</a>
                          <br /><small>by Prada</small>
                        </td>
                        <td>
                          Red
                        </td>
                        <td>
                          M
                        </td>
                        <td class="td-number">
                          <small>€</small>200
                        </td>
                        <td class="td-number">
                          1
                        </td>
                        <td class="td-number">
                          <small>€</small>799
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5">
                        </td>
                        <td class="td-total">
                          Total
                        </td>
                        <td class="td-price">
                          <small>€</small>2,346
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
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

      demo.initVectorMap();

    });
  </script>
</body>

</html>