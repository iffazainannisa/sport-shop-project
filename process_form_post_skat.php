<?php
require_once('Db.php');
$db = new Db();
$result = $db->query("SELECT * FROM sub_kategori WHERE idsub_kategori= " . $_POST['id'] . "")->fetch_all()[0];
$kategori = $db->query('SELECT * FROM kategori');

// echo '<input type="text" class="form-control" id="nama" placeholder="Enter full name" name="up_skategori" value="' . $result->fetch_assoc()['nama'] . '"> <select type="hidden" name="up_id" value="' . $_POST['id'] . '"> <input type="hidden" name="up_id" value="' . $_POST['id'] . '">';
$opsikat = '';
$kat = '';

while ($val = $kategori->fetch_assoc()) {
    if ($val['idkategori'] != $result[2]) {
        $opsikat = $opsikat . '<option value="' . $val['idkategori'] . '">' . $val['nama'] . '</option>';
    } else {
        $kat = $val['nama'];
    }
}
$id = $result[0];
$nama = $result[1];
$ksk = $result[2];

echo '<div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter full name" name="name2" value="' . $nama . '">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" name="idkat">
                                        <option selected value="' . $ksk . '">' . $kat . '</option>
                                        ' . $opsikat . '
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="up_id2" value="' . $id . '">

';
