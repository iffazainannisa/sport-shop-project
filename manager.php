<?php
	session_start();
	if (!isset($_SESSION["idpegawai"]) && !isset($_SESSION["password"])) {
    	header("location: index.php");
	}
	$id=$_SESSION['idpegawai'];
  // connect database
  require_once('db_login.php');
  $db = new mysqli($db_host, $db_username, $db_password, $db_database); 
  if ($db->connect_errno){
    die ("Could not connect to the database: <br />". $db->connect_error);
  }
  $query = " SELECT * FROM pegawai WHERE idpegawai=".$id." ";
	  // Execute the query
  $result = $db->query( $query );
	  if (!$result){
	    die ("Could not query the database: <br />". $db->error);
	  }else{
	      while ($row = $result->fetch_object()){
	      $id = $row->idpegawai;
	      $username = $row->username;
	      $nama = $row->nama_lengkap;
	      $email = $row->email;
	      $password = $row->password;
	      $foto = $row->foto;
	      }
	  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Manager Menu</title>
<!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>.id</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Tokool</b>.id</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/<?php echo $foto; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $nama; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="images/<?php echo $foto; ?>" class="img-circle" alt="User Image">

                <p>
                  Manager
                  <small><?php echo $nama; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="edit_profile.php" class="btn btn-default btn-flat">Edit Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat" name="logout" value="Logout">Log out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="images/<?php echo $foto; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $nama; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">LIHAT PRODUK</li>
        <?php
        	$query2 = " SELECT * FROM kategori";
  			// Execute the query
  			$result2 = $db->query( $query2 );
  			if (!$result2){
    			die ("Could not query the database: <br />". $db->error);
  			}else{
      			while ($row2 = $result2->fetch_object()){
      				echo '<li class="treeview">
          			<a href="#">
            		<i class="fas fa-football-ball"></i><span> ' .$row2->nama.'</span>';
            		echo '<span class="pull-right-container">
              		<i class="fas fa-chevron-circle-down"></i>
            		</span>
          			</a>';
          			echo '<ul class="treeview-menu">';
      				$query3 = " SELECT * FROM sub_kategori WHERE kategori=".$row2->idkategori;
  					// Execute the query
  					$result3 = $db->query( $query3 );
  					if (!$result3){
    					die ("Could not query the database: <br />". $db->error);
  					}else{
      					while ($row3 = $result3->fetch_object()){
            				echo'<li><a href="view_produk2.php?subid='.$row3->idsub_kategori.'">';
            				echo '<i class="fas fa-basketball-ball"></i> '. $row3->nama.'</a></li>';
      					}
  					}
          			echo '</ul>';
  					echo "</li>";
      			}
  			}        
        ?>
        <li class="header">REKAP PRODUK</li>
        <li>
        	<a href="view_rekap.php">
        		<i class="fa fa-book"></i> <span>Documentation</span>
        	</a>
        </li>
        <li class="header">GRAFIK PRODUK</li>
        <li>
          <a href="view_chart.php">
            <i class="fas fa-chart-bar"> </i>
            <span>Charts</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
    </section>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

  <!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/chart.js/Chart.js"></script>
<script src="css/fontawesome/js/all.js"></script>
</body>
</html>
<?php
	$db->close();
?>