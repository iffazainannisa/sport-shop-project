<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html401/loose.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Rekap data Produk</title>
  <!--card-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
  <link rel="stylesheet" href="css/style2.css">
  <style>
  table { 
  width: 750px; 
  border-collapse: collapse; 
  margin:50px auto;
  }

/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
  }

th { 
  background: #3498db; 
  color: white; 
  font-weight: bold; 
  }

td, th { 
  padding: 10px; 
  border: 1px solid #ccc; 
  text-align: left; 
  font-size: 18px;
  }

/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  table { 
      width: 100%; 
  }

  /* Force table to not be like tables anymore */
  table, thead, tbody, th, td, tr { 
    display: block; 
  }
  
  /* Hide table headers (but not display: none;, for accessibility) */
  thead tr { 
    position: absolute;
    top: -9999px;
    left: -9999px;
  }
  
  tr { border: 1px solid #ccc; }
  
  td { 
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee; 
    position: relative;
    padding-left: 50%; 
  }

  td:before { 
    /* Now like a table header */
    position: absolute;
    /* Top/left values mimic padding */
    top: 6px;
    left: 6px;
    width: 45%; 
    padding-right: 10px; 
    white-space: nowrap;
    /* Label the data */
    content: attr(data-column);

    color: #000;
    font-weight: bold;
  }

}
  </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION["idpegawai"]) && !isset($_SESSION["password"])) {
  header("location: view_rekap.php");
}
$id = $_SESSION['idpegawai'];
// connect database
require_once('db_login.php');
$db = new mysqli($db_host, $db_username, $db_password, $db_database);
if ($db->connect_errno) {
  die("Could not connect to the database: <br />" . $db->connect_error);
}
$query = " SELECT * FROM pegawai WHERE idpegawai=" . $id . " ";
// Execute the query
$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error);
} else {
  while ($row = $result->fetch_object()) {
    $id = $row->idpegawai;
    $username = $row->username;
    $nama = $row->nama_lengkap;
    $email = $row->email;
    $password = $row->password;
    $foto = $row->foto;
  }
}
        $query4 = "SELECT sub_kategori.nama as snama, produk.nama_produk as pnama, kategori.nama as knama, kategori.idkategori as idk FROM sub_kategori INNER JOIN kategori on kategori.idkategori=sub_kategori.kategori INNER JOIN produk ON produk.idsub_kategori=sub_kategori.idsub_kategori ORDER BY kategori.idkategori, sub_kategori.idsub_kategori ASC";
        // Execute the query
        $result4 = $db->query($query4);

        $query5 = "SELECT COUNT(sub_kategori.nama) AS csnama FROM sub_kategori INNER JOIN kategori on kategori.idkategori=sub_kategori.kategori INNER JOIN produk ON produk.idsub_kategori=sub_kategori.idsub_kategori GROUP BY kategori.idkategori ORDER BY kategori.idkategori, sub_kategori.idsub_kategori ASC";
        // Execute the query
        $result5 = $db->query($query5);

        $query6 = "SELECT COUNT(produk.nama_produk) AS cspro FROM sub_kategori INNER JOIN kategori on kategori.idkategori=sub_kategori.kategori INNER JOIN produk ON produk.idsub_kategori=sub_kategori.idsub_kategori GROUP BY sub_kategori.idsub_kategori ORDER BY kategori.idkategori, sub_kategori.idsub_kategori ASC";
        // Execute the query
        $result6 = $db->query($query6);
        $result7 = $db->query($query6);
        $result8 = $db->query($query5);

        if (!$result4) {
          die("Could not query the database: <br />" . $db->error);
        } else {
          echo '<table border="1">
            <tr>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Produk</th>
            </tr>';
          $sub = 0;
          $pro = 0;

          $prod = $result7->fetch_all();
          $hsub =  $result8->fetch_all();

          $hitungsub = $result5->fetch_all();
          if ($result5->num_rows > 1) {
            for ($a = 1; $a < count($hitungsub); $a++) {
              $hitungsub[$a][0] = $hsub[$a - 1][0] + $hitungsub[$a - 1][0];
            }
          }
          $hitungpro = $result6->fetch_all();
          if ($result6->num_rows > 1) {
            for ($a = 1; $a < count($hitungpro); $a++) {
              $hitungpro[$a][0] = $prod[$a - 1][0] + $hitungpro[$a - 1][0];
            }
          }

          $i = $hitungsub[0][0];
          $s = $hitungpro[0][0];
          while ($row4 = $result4->fetch_object()) {
            $knama = $row4->knama;
            $snama = $row4->snama;
            $pnama = $row4->pnama;
            $idk = $row4->idk;

            echo '<tr>';
            if ($sub < count($hitungsub)) {
              if (in_array($i, $hitungsub[$sub])) {
                echo '<td rowspan="' . $hsub[$sub][0] . '">' . $knama . '</td>';
                $sub++;
              }
            }
            if ($pro < count($hitungpro)) {
              if (in_array($s, $hitungpro[$pro])) {
                echo '<td rowspan="' . $prod[$pro][0] . '">' . $snama . '</td>';
                $pro++;
              }
            }
            echo '<td>' . $pnama . '</td>';

            $i++;
            $s++;
            echo '</tr>';
          }
          echo "</table>";
        }
        ?>
<script>
    window.print();

</script>
</body>
</html>
