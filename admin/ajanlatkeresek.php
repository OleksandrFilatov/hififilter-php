<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
  $process_state = ['Feldolgozás alatt', 'Feldolgozva'];
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		header("Location: login.php");
  $sql="SELECT * FROM reqproduct";
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
                <h4 class="card-title"> Árajánlatkérések</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th class="text-center">
                        #ID
                      </th>
                      <th>
                        Ügyfél
                      </th>
                      <th>
                        Árajánlatkérés időpontja
                      </th>
                      <th class="text-center">
                        Termék cikkszáma / képe
                      </th>
                      <th class="text-center">
                        Megjegyzés
                      </th>
                      <th class="text-right">
                        Státusz
                      </th>
                      <th class="text-right">
                        Lehetőségek
                      </th>
                    </thead>
                    <tbody>
                      <?php foreach ($result as $key => $value) { ?>
                      <tr id="fullrow_<?=$value['rq_id']; ?>">
                        <td class="text-center">
                          <?php echo $key+1; ?>
                        </td>
                        <td>
                          <?php echo $value['rq_last_name']." ".$value['rq_first_name']; ?><br><?php echo $value['rq_email']; ?><br><?php echo $value['rq_telefon']; ?>
                        </td>
                        <td>
                          <?php echo $value['rq_date']; ?>
                        </td>
                        <td class="text-center" style="max-width: 400px">
                          <?php $urls = explode(", ", $value['rq_images']); if($value['rq_type'] == '1') { echo $value['rq_article_num']; } else { foreach($urls as $key => $url) { ?>
                            <img class="mb-1" height="80px" src="<?php echo "upload/".$url ?>" alt="">
                          <?php }} ?>
                        </td>
                        <td class="text-left" style="width: 300px">
                          <?php echo $value['rq_comment']; ?>
                        </td>
                        <td class="text-right" id="state_<?=$value['rq_id'];?>">
                          <?php echo $process_state[$value['rq_state']]; ?>
                        </td>
                        <td class="text-right">
						<?php /*
                          <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm ">
                            <i class="now-ui-icons travel_info"></i>
                          </button>
                          <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm ">
                            <i class="now-ui-icons ui-1_send"></i>
                          </button> */ ?>
                          <button type="button" title="Státusz váltás" onclick="changestate(<?=$value['rq_id']; ?>)" rel="tooltip" class="btn btn-success btn-icon btn-sm ">
                            <i class="now-ui-icons ui-1_check"></i>
                          </button>
                          <button type="button" title="Törlés" rel="tooltip" onclick="if (confirm('Biztosan törölni szeretné?')) delreq(<?=$value['rq_id']; ?>)" class="btn btn-danger btn-icon btn-sm ">
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
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
</body>

</html>

<script>

	var allapotok = ['Feldolgozás alatt', 'Feldolgozva'];

	function changestate(id)
	{
	url = "changereqstate.php?id="+id;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
				var res=this.responseText;
				document.getElementById('state_'+id).innerHTML = allapotok[parseInt(this.responseText)];				
		}
		};
	  xhttp.open("GET", url, true);
	  xhttp.send();
	}
	
	function delreq(id)
	{
	url = "delreq.php?id="+id;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("fullrow_"+id).style.display="none";
		}
		};
	  xhttp.open("GET", url, true);
	  xhttp.send();
	}
</script>