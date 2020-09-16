<?php
require_once('Db.php');
$db = new Db();
$id = $_POST['id'];
$result = $db->query("SELECT * FROM produk WHERE idproduk=" . $id . "")->fetch_all();
$kategori = $db->query('SELECT * FROM kategori');
$sKategori = $db->query('SELECT * FROM sub_kategori');
// echo '<input type="text" class="form-control" id="nama" placeholder="Enter full name" name="up_kategori" value="' . $result->fetch_assoc()['nama'] . '"> <input type="hidden" name="up_id" value="' . $_POST['id'] . '">';


$opsikat = '';
$kat = '';

while ($val = $kategori->fetch_assoc()) {
    if ($val['idkategori'] != $result[0][3]) {
        $opsikat = $opsikat . '<option value="' . $val['idkategori'] . '">' . $val['nama'] . '</option>';
    } else {
        $kat = $val['nama'];
    }
}


$opsiskat = '';
$skat = '';

while ($val = $sKategori->fetch_assoc()) {
    if ($val['idsub_kategori'] != $result[0][4]) {
        $opsiskat = $opsiskat . '<option value="' . $val['idsub_kategori'] . '">' . $val['nama'] . '</option>';
    } else {
        $skat = $val['nama'];
    }
}



$nama = $result[0][1];
$desk = $result[0][2];
$harga = $result[0][3];
$idsub = $result[0][4];
$idpeg = $result[0][6];
$file = $result[0][5];





echo '
<div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter product name" name="nama_produk" value="' . $nama . '">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi" >' . $desk . '</textarea>
                                </div>
                                <div class="form-group">
                                            <label for="kategori">Harga</label>
                                            <input type="number" class="form-control" id="nama" placeholder="Enter product price" name="harga" value="' . $harga . '">
                                        </div>
                                <div class="form-group">
                                <label for="kategori">Sub-Kategori</label>
                                    <select class="custom-select" name="idsub">
                                        <option selected value="' . $idsub . '">' . $skat . '</option>
                                        ' . $opsiskat . '
                                    </select>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="userfile">
                                    <label class="custom-file-label" for="file">' . $file . '</label>
                                </div>
                                <div class="form-group">
                                    <img src="images/' . $file . '" alt="' . $file . '" width="200" height="200">
                                </div>
                            <input type="hidden" name="up_id" value="' . $id . '">
                            <input type="hidden" name="old_file" value="' . $file . '">


';
