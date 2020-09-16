<?php
require_once('Db.php');
$db = new Db();

if (isset($_GET['sub'])) {
  $result = $db->query('SELECT p.idproduk AS id,k.nama AS kategori,p.nama_produk AS produk, sk.idsub_kategori AS idsub, sk.kategori AS idkat, p.file_gambar AS pic, p.deskripsi AS desk, p.harga AS harga FROM produk AS p JOIN sub_kategori AS sk ON p.idsub_kategori = sk.idsub_kategori JOIN kategori as k ON k.idkategori = sk.kategori WHERE sk.idsub_kategori=' . $_GET['sub'] . ' ORDER BY sk.nama');
} else if (isset($_GET['kat'])) {
  $result = $db->query('SELECT p.idproduk AS id,k.nama AS kategori,p.nama_produk AS produk, sk.idsub_kategori AS idsub, sk.kategori AS idkat, p.file_gambar AS pic, p.deskripsi AS desk, p.harga AS harga  FROM produk AS p JOIN sub_kategori AS sk ON p.idsub_kategori = sk.idsub_kategori JOIN kategori as k ON k.idkategori = sk.kategori WHERE k.idkategori=' . $_GET['kat'] . ' ORDER BY sk.nama');
} else if (isset($_GET['search'])) {
  $result = $db->query('SELECT p.idproduk AS id,k.nama AS kategori,p.nama_produk AS produk, sk.idsub_kategori AS idsub, sk.kategori AS idkat, p.file_gambar AS pic, p.deskripsi AS desk, p.harga AS harga  FROM produk AS p JOIN sub_kategori AS sk ON p.idsub_kategori = sk.idsub_kategori JOIN kategori as k ON k.idkategori = sk.kategori WHERE p.nama_produk LIKE "%' . $_GET['search'] . '%" ORDER BY sk.kategori');
} else {
  $result = $db->query('SELECT p.idproduk AS id,k.nama AS kategori,p.nama_produk AS produk, sk.idsub_kategori AS idsub, sk.kategori AS idkat, p.file_gambar AS pic, p.deskripsi AS desk, p.harga AS harga  FROM produk AS p JOIN sub_kategori AS sk ON p.idsub_kategori = sk.idsub_kategori JOIN kategori as k ON k.idkategori = sk.kategori ORDER BY sk.kategori');
}



$result2 = $db->query('SELECT * FROM kategori');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
  <link rel="stylesheet" href="dist/css/bootstrap-submenu.css">
  <script src="dist/js/bootstrap-submenu.js" defer=""></script>
  <script>
    $('data-submenu').submenupicker();
  </script>
  <title>Kelompok 9</title>
  <style type="text/css">
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -6px;
      margin-left: -1px;
      -webkit-border-radius: 0 6px 6px 6px;
      -moz-border-radius: 0 6px 6px;
      border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
      display: block;
    }

    .dropdown-submenu>a:after {
      display: block;
      content: " ";
      float: right;
      width: 0;
      height: 0;
      border-color: transparent;
      border-style: solid;
      border-width: 5px 0 5px 5px;
      border-left-color: #ccc;
      margin-top: 5px;
      margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
      border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
      float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
      left: -100%;
      margin-left: 10px;
      -webkit-border-radius: 6px 0 6px 6px;
      -moz-border-radius: 6px 0 6px 6px;
      border-radius: 6px 0 6px 6px;
    }

    /* Styles for wrapping the search box */

    .main {
      margin-left: 30% !important;
      width: 550px;
      margin: 50px auto;
    }

    /* Bootstrap 4 text input with search icon */

    .has-search .form-control {
      padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
      position: absolute;
      z-index: 2;
      display: block;
      width: 2.375rem;
      height: 2.375rem;
      line-height: 2.375rem;
      text-align: center;
      pointer-events: none;
      color: #aaa;
    }
  </style>
</head>

<body>
  <!--?php 

  <nav class="navbar navbar-dark bg-primary w-100 d-flex"-->
  <div class="container d-flex justify-content-center"> <a class="navbar-brand" href="homepage.php">
      <i class="fa d-inline fa-lg fa-circle-o"></i>
      <b> Kelompok 9</b>
    </a> </div>
  <div class="text-center text-md-right py-2" style="background-image: url(&quot;https://images.pexels.com/photos/669578/pexels-photo-669578.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=3&amp;h=750&amp;w=1260&quot;); background-position: right bottom; background-size: cover; background-repeat: repeat; background-attachment: fixed;">
    <div class="container">
      <div class="row" style="">
        <div class="p-5 mx-auto mx-md-0 ml-md-auto col-10 col-md-12" style="">
          <h3 class="display-3 text-center text-white">Mau Cari Apa?</h3>
          <p class="mb-3 lead text-center text-white">Cari berbagai produk pilihan disini</p>
          <div class="form-group">
            <div class="input-group px-5">
              <form action="homepage.php" method="GET">
                <div class="main ">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search this blog" name="search">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit" style="background-color:#12BBAD;">
                        <i class=" fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <form class=" form-inline" style="">
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="py-0 pt-4" style="">
    <div class="container">
      <div class="row">
        <div class="col-md-12 pb-2">
          <h3 class="text-center display-5 w-100">Semua Produk<br></h3>
        </div>
      </div>
      <div class="row">
        <div class=" d-flex justify-content-center mx-auto">
          <div class="btn-group px-5">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Pilih Kategori & Subkategori</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li>
                <a class="dropdown-item" tabindex="-1" href="homepage.php">Show All</a>
              </li>
              <?php while ($val = $result2->fetch_assoc()) : ?>
                <li class="dropdown-submenu">
                  <a class="dropdown-item" tabindex="-1" href="homepage.php?kat=<?= $val['idkategori'] ?>"><?= $val['nama'] ?></a>
                  <ul class="dropdown-menu">
                    <?php
                      $result3 = $db->query('SELECT sk.nama AS sub, sk.idsub_kategori AS idsub FROM sub_kategori AS sk WHERE sk.kategori=' . $val['idkategori'] . '');
                      while ($val2 = $result3->fetch_assoc()) :
                        ?>
                      <li class="dropdown-item"><a href="homepage.php?sub=<?= $val2['idsub'] ?>"><?= $val2['sub'] ?></a></li>
                    <?php endwhile; ?>
                  </ul>
                </li>
              <?php endwhile; ?>
            </ul>
            <div class="dropdown-menu"> <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
      </div>
      <div class="row">
        <div class="container">
        </div>
      </div>
    </div>
    <div class="py-0 pt-3 pb-5" style="">
      <div class="container">
        <div class="row">
          <?php if ($result->num_rows != 0) : ?>
            <?php while ($val = $result->fetch_assoc()) : ?>
              <div class="col-md-4 mb-3">
                <div class="card"> <img class="card-img-top" src="images/<?= $val['pic'] ?>" alt="Card image cap">
                  <div class="card-body">
                    <h4 class="card-title"><a href="detail.php?id=<?= $val['id'] ?>&sub=<?= $val['idsub'] ?>&kat=<?= $val['idkat'] ?>&pic=<?= $val['pic'] ?>"><?= $val['produk'] ?></a></h4>
                    <h5 class="">Rp<?= number_format($val['harga']) ?>,-</h5>
                    <p class=""><?= substr($val['desk'], 0, 50) ?>...</p>
                    <a href="detail.php?id=<?= $val['id'] ?>&sub=<?= $val['idsub'] ?>&kat=<?= $val['idkat'] ?>&pic=<?= $val['pic'] ?>" class="btn btn-primary">Cek Detail</a>
                  </div>
                </div>
              </div>
            <?php
              endwhile;
            else : ?>
            <h3 class="col-md-12 py-5" style="text-align:center;">
              Maaf, tidak ditemukan hasil
            </h3>
          <?php
          endif;
          ?>

        </div>
      </div>
    </div>
    <div style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.2));	background-position: top left;	background-size: 100%;	background-repeat: repeat;" class="py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p class="mb-0">© 2019 Kelompok 9</p>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" style=""></script>
  </div>
</body>

</html>