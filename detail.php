<?php
require_once('Db.php');
$db = new Db();
$id = $_GET['id'];
$result = $db->query('SELECT p.idproduk AS id, k.nama AS kategori, p.nama_produk AS produk, sk.nama AS sub_kategori, p.deskripsi AS deskripsi, p.harga AS harga FROM produk AS p JOIN sub_kategori AS sk ON p.idsub_kategori = sk.idsub_kategori JOIN kategori as k ON k.idkategori = sk.kategori WHERE p.idproduk=' . $id . ' ORDER BY sk.kategori')->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body>
  <nav class="navbar navbar-dark bg-primary w-100 d-flex" style="">
    <div class="container d-flex justify-content-center"> <a class="navbar-brand" href="homepage.php">
        <i class="fa d-inline fa-lg fa-circle-o"></i>
        <b> Kelompok 9</b>
      </a> </div>
  </nav>
  <div class="pt-3">
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-lg-4 col-md-4 w-100">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"> <a href="homepage.php">Home</a> </li>
            <li class="breadcrumb-item active"><a href="homepage.php?kat=<?= $_GET['kat'] ?>"><?= $result['kategori'] ?></a></li>
            <li class="breadcrumb-item active"><a href="homepage.php?sub=<?= $_GET['sub'] ?>"><?= $result['sub_kategori'] ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="pt-3 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4" style=""><img class="img-fluid d-block" src="images/<?= $_GET['pic'] ?>"></div>
        <div class="col-md-8" style="">
          <h1 class=""><?= $result['produk'] ?></h1>
          <h4 class="">Rp<?= number_format($result['harga']) ?>,-</h4>
          <p class=""><?= $result['deskripsi'] ?></p>
        </div>
      </div>
    </div>
  </div>
  <div style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)); background-position: left top; background-size: 100%; background-repeat: repeat;" class="py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <p class="mb-0">© 2019 Kelompok 9</p>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>