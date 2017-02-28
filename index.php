<?
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>

<html>
<head>
  <title>Rumah dijual</title>
  <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/home.css">
  <script type="text/javascript" href="lib/bootstrap/js/bootstrap.min.js.js"></script>
  <script type="text/javascript" src="lib/jquery.js"></script>
  <script type="text/javascript" src="js/home.js"></script>
</head>

<body>
  <!-- <div id="navmenu">
  <span id="title">RumahDijual.com</span>
  <span class="glyphicon glyphicon-search menu-button"></span>
</div> -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Rumah Dijual</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li>
        <form class="navbar-form" role="search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Kabupaten..." name="q">
            <div class="input-group-btn" >
              <button class="btn btn-default" type="button" onclick="searchPage()"><i class="glyphicon glyphicon-search" style="padding-top: 3px; padding-bottom: 3px;"></i></button>
            </div>
          </div>
        </form>
      </li>
      <?
      if (isset($_SESSION['user_id'])) {
        echo '<li><div class="menu-button" onclick="addData()"><span class="glyphicon glyphicon-plus"></span> Tambah Data</div></li>
        <li><div class="menu-button" onclick="logout()"><span class="glyphicon glyphicon-log-out"></span> Keluar</div></li>';
      } else {
        echo '<li><div class="menu-button" onclick="loginPage()"><span class="glyphicon glyphicon-log-in"></span> Masuk</div></li>';
      }
      ?>
    </ul>
  </div>
</nav>
<div id="detail"></div>
<div id="map"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyBGkZNDZAFnMFJJ-q9JnDXxGBVLSJ5GSag&callback=houseMap&libraries=places"></script>
</body>
</html>
