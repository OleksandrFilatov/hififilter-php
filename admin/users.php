<?php 
	session_start();
	date_default_timezone_set('Europe/Budapest');
	require("dbcon.php");
	if (!isset($_SESSION['user']) || !$_SESSION['user']['admin'])
		header("Location: login.php");
  $sql1="SELECT * FROM ugyfelek ORDER BY uf_id DESC";
  $sql2 = "select * from ugyfelek where uf_id NOT IN (
	  select u_id from kosar where purchase_state = 1 and DATEDIFF(NOW(), purchase_date) < 366 GROUP BY u_id) ORDER BY uf_id DESC";
  $result1=mysqli_query($con, $sql1);
  $result2=mysqli_query($con, $sql2);
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
    Felhasználók | HifiFilter Admin
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
                <h4 class="card-title"> Felhasználók</h4>
              </div>
              <div class="card-body">
              <button class="btn btn-primary btn-sm statebutton2">365 napja nem vásárolt</button>
              <button class="btn btn-primary btn-sm statebutton1" style="margin-left: 20px; background: #37ab37;">Összes ügyfél megjelenítése</button>
                <div class="table-responsive">
                  <table class="table state1" style="display: inline-table">
                    <thead class="text-primary">
                      <th>
                        Regisztrált
                      </th>
                      <th>
                        Név
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Árszint
                      </th>
                      <th>
                        Pénznem
                      </th>
                      <th>
                        Értesítés <i class="now-ui-icons travel_info" style="font-size: 13px; font-weight: bold; color: #2CA8FF; cursor: pointer" onclick="Swal.fire('Értesítés','Ha beállítottuk a megfelelő árszintet, a felhasználó egy alkalommal értesíthető arról, hogy jóváhagyták regisztrációját. A gomb csak akkor aktív, ha elfogadtunk vagy visszavontunk egy regisztrációt és megnyomásával a megfelelő tartalmú e-mail küldhető ki.<br><br>A felhasználó csak az állapotáról (jóváhagyott/nem jóváhagyott) kap értesítést, az árszintjéről nem.'); "></i>
                      </th>
                      <th>
                        Utolsó vásárlás
                      </th>
                      <th>
                        Auto törlés <i class="now-ui-icons travel_info" style="font-size: 13px; font-weight: bold; color: #2CA8FF; cursor: pointer" onclick="Swal.fire('Automatikus törlés','A lehetőséget bejelölve a rendszer az utolsó vásárlástól számított 3 hónapon belül törli a felhasználót, de előtte 30 nappal e-mailben értesíti a törlésről.'); "></i>
                      </th>
					            <th></th>
                    </thead>
                    <tbody>
                      <?php foreach ($result1 as $key => $row) { ?>
                        <tr>
                          <td>
                            <?=date('Y.m.d H:i:s', strtotime($row['uf_reg_ido'])); ?>
                          </td>
                          <td>
                            <?=$row['uf_vnev']." ".$row['uf_knev']; ?>
                          </td>
                          <td>
                            <?=$row['uf_email']; ?>
                          </td>
                          <td>
                            <select class="btn btn-outline-default" title="Állapot" tabindex="-98" id="client_state_<?=$row['uf_id']; ?>" onchange="saveClientData(<?=$row['uf_id']; ?>);">
                              <option value="0" <?php if ($row['uf_vevoi_arszint']==0) echo 'selected'; ?>>Nem jóváhagyott</option>
                              <option value="1" <?php if ($row['uf_vevoi_arszint']==1) echo 'selected'; ?>>Bronz</option>
                              <option value="2" <?php if ($row['uf_vevoi_arszint']==2) echo 'selected'; ?>>Ezüst</option>
                              <option value="3" <?php if ($row['uf_vevoi_arszint']==3) echo 'selected'; ?>>Arany</option>
                              <option value="4" <?php if ($row['uf_vevoi_arszint']==4) echo 'selected'; ?>>Platina</option>
                            </select>
                          </td>
                          <td>
                            <select class="btn btn-outline-default" title="Fizetés" tabindex="-98" id="pay_state_<?=$row['uf_id']; ?>" onchange="savepayData(<?=$row['uf_id']; ?>);">
                              <option value="0" <?php if ($row['uf_payment_mode']==0) echo 'selected'; ?>>EUR(€)</option>
                              <option value="1" <?php if ($row['uf_payment_mode']==1) echo 'selected'; ?>>HUF(Ft)</option>
                            </select>
                          </td>
                          <td>
                            <button class="btn btn-primary btn-round btn-icon" <?php if (!$row['uf_gomb_aktiv']) echo 'disabled'; ?> >
                            <i class="now-ui-icons ui-1_send"></i>
                            </button>
                          </td>
                          <td>
                            Később... 
                          </td>
                          <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" <?php if ($row['uf_autotorles']) echo 'checked'; ?> >
                            <span class="form-check-sign"></span>
                            </label>
                          </div>
                          </td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm " title="Felhasználó részletes adatai">
                              <i class="now-ui-icons users_single-02"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " title="Felhasználó törlése">
                              <i class="now-ui-icons ui-1_simple-remove"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <table class="table state2" style="display: none">
                    <thead class="text-primary">
                      <th>
                        Regisztrált
                      </th>
                      <th>
                        Név
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Állapot / Árszint
                      </th>
                      <th>
                        Fizetés / Mód
                      </th>
                      <th>
                        Értesítés <i class="now-ui-icons travel_info" style="font-size: 13px; font-weight: bold; color: #2CA8FF; cursor: pointer" onclick="Swal.fire('Értesítés','Ha beállítottuk a megfelelő árszintet, a felhasználó egy alkalommal értesíthető arról, hogy jóváhagyták regisztrációját. A gomb csak akkor aktív, ha elfogadtunk vagy visszavontunk egy regisztrációt és megnyomásával a megfelelő tartalmú e-mail küldhető ki.<br><br>A felhasználó csak az állapotáról (jóváhagyott/nem jóváhagyott) kap értesítést, az árszintjéről nem.'); "></i>
                      </th>
                      <th>
                        Utolsó vásárlás
                      </th>
                      <th>
                        Auto törlés <i class="now-ui-icons travel_info" style="font-size: 13px; font-weight: bold; color: #2CA8FF; cursor: pointer" onclick="Swal.fire('Automatikus törlés','A lehetőséget bejelölve a rendszer az utolsó vásárlástól számított 3 hónapon belül törli a felhasználót, de előtte 30 nappal e-mailben értesíti a törlésről.'); "></i>
                      </th>
					            <th></th>
                    </thead>
                    <tbody>
                      <?php foreach ($result2 as $key => $row) { ?>
                        <tr>
                          <td>
                            <?=date('Y.m.d H:i:s', strtotime($row['uf_reg_ido'])); ?>
                          </td>
                          <td>
                            <?=$row['uf_vnev']." ".$row['uf_knev']; ?>
                          </td>
                          <td>
                            <?=$row['uf_email']; ?>
                          </td>
                          <td>
                            <select class="btn btn-outline-default" title="Állapot" tabindex="-98" id="client_state2_<?=$row['uf_id']; ?>" onchange="saveClient2Data(<?=$row['uf_id']; ?>);">
                              <option value="0" <?php if ($row['uf_vevoi_arszint']==0) echo 'selected'; ?>>Nem jóváhagyott</option>
                              <option value="1" <?php if ($row['uf_vevoi_arszint']==1) echo 'selected'; ?>>Bronz</option>
                              <option value="2" <?php if ($row['uf_vevoi_arszint']==2) echo 'selected'; ?>>Ezüst</option>
                              <option value="3" <?php if ($row['uf_vevoi_arszint']==3) echo 'selected'; ?>>Arany</option>
                              <option value="4" <?php if ($row['uf_vevoi_arszint']==4) echo 'selected'; ?>>Platina</option>
                            </select>
                          </td>
                          <td>
                            <select class="btn btn-outline-default" title="Fizetés" tabindex="-98" id="pay_state2_<?=$row['uf_id']; ?>" onchange="savepay2Data(<?=$row['uf_id']; ?>);">
                              <option value="0" <?php if ($row['uf_payment_mode']==0) echo 'selected'; ?>>EUR(€)</option>
                              <option value="1" <?php if ($row['uf_payment_mode']==1) echo 'selected'; ?>>HUF(Ft)</option>
                            </select>
                          </td>
                          <td>
                            <button class="btn btn-primary btn-round btn-icon" <?php if (!$row['uf_gomb_aktiv']) echo 'disabled'; ?>>
                            <i class="now-ui-icons ui-1_send"></i>
                            </button>
                          </td>
                          <td>
                            Később... 
                          </td>
                          <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" <?php if ($row['uf_autotorles']) echo 'checked'; ?> >
                            <span class="form-check-sign"></span>
                            </label>
                          </div>
                          </td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm " title="Felhasználó részletes adatai">
                              <i class="now-ui-icons users_single-02"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " title="Felhasználó törlése">
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

<script>
  $('.statebutton1').click(function(){
    $('.state1').css("display", "inline-table");
    $('.state2').css("display", "none");
  })
  $('.statebutton2').click(function(){
    $('.state2').css("display", "inline-table");
    $('.state1').css("display", "none");
  })
	function saveClientData(id)
	{
    $.ajax({
        url: 'saveclientdata.php',
        method: 'post',
        data: {
            id: id,
            state: $('#client_state_'+id).val(),
            type: "1"
        },
        success: function (msg) {
          if (msg == 'success')
              alert('Sikeresen megváltozott!');
              Swal.fire('Értesítés','Sikeresen megváltozott!');
        },
    });
	}

  function saveClient2Data(id)
	{
    $.ajax({
        url: 'saveclientdata.php',
        method: 'post',
        data: {
            id: id,
            state: $('#client_state2_'+id).val(),
            type: "1"
        },
        success: function (msg) {
          if (msg == 'success')
              alert('Sikeresen megváltozott!');
              Swal.fire('Értesítés','Sikeresen megváltozott!');
        },
    });
	}

  function savepayData(id)
	{
    $.ajax({
        url: 'saveclientdata.php',
        method: 'post',
        data: {
            id: id,
            state: $('#pay_state_'+id).val(),
            type: '2'
        },
        success: function (msg) {
          if (msg == 'success')
              alert('Sikeresen megváltozott!');
              Swal.fire('Értesítés','Sikeresen megváltozott!');
        },
    });
	}

  function savepay2Data(id)
	{
    $.ajax({
        url: 'saveclientdata.php',
        method: 'post',
        data: {
            id: id,
            state: $('#pay_state2_'+id).val(),
            type: '2'
        },
        success: function (msg) {
          if (msg == 'success')
              alert('Sikeresen megváltozott!');
              Swal.fire('Értesítés','Sikeresen megváltozott!');
        },
    });
	}

</script>