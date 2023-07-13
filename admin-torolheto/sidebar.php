<?php
$array = explode('/', $_SERVER['REQUEST_URI']);
$url = end($array); 
?>
<div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="index.php" class="simple-text logo-normal">
          <img width="60%" src="../assets/images/gencologo_white.png" style="margin: 0 auto; display: block">
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li <?php if ($url=='index.php') echo 'class="active"'; ?>>
            <a href="index.php">
              <i class="now-ui-icons design_app"></i>
              <p>Vezérlőpult</p>
            </a>
          </li>
          <li <?php if ($url=='ugyfelek.php') echo 'class="active"'; ?>>
            <a href="ugyfelek.php">
              <i class="now-ui-icons users_single-02"></i>
              <p>Ügyfelek</p>
            </a>
          </li>
          <li <?php if ($url=='szolgaltatasok.php') echo 'class="active"'; ?>>
            <a href="szolgaltatasok.php">
              <i class="now-ui-icons location_world"></i>
              <p>Szolgáltatások</p>
            </a>
          </li>
          <li <?php if ($url=='arkepzes.php') echo 'class="active"'; ?>>
            <a href="arkepzes.php">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Árképzés</p>
            </a>
          </li>
		  
		  <li><a data-toggle="collapse" href="#penzugyekOldalak" >
                        
						<i class="now-ui-icons business_chart-bar-32"></i>
						<p>Pénzügyek <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse " id="penzugyekOldalak">
                        <ul class="nav">
                           <li <?php if ($url=='szamlazas.php?mode=0') echo 'class="active"'; ?>>
							<a href="szamlazas.php?mode=0">
							<p>Számlázandó tételek</p>
							</a>
							</li>
                           <li <?php if ($url=='szamlazas.php?mode=1') echo 'class="active"'; ?>>
							<a href="szamlazas.php?mode=1">
							<p>Számlázott tételek</p>
							</a>
							</li>
                      </ul>
                  </div>
              </li>
		  </li>
          <li <?php if ($url=='csomagok.php') echo 'class="active"'; ?>>
            <a href="csomagok.php">
              <i class="now-ui-icons location_map-big"></i>
              <p>Csomagok</p>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Feladatok</p>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="now-ui-icons education_atom"></i>
              <p>Beszállítói információk</p>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Árajánlatok</p>
            </a>
          </li>
          
          <li class="active-pro">
            <a href="#">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Backend version 1.0541</p>
            </a>
          </li>
        </ul>
      </div>
    </div>