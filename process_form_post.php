<?php
require_once('Db.php');
$db = new Db();
$result = $db->query("SELECT nama FROM kategori WHERE idkategori=" . $_POST['id'] . "");
echo '<input type="text" class="form-control" id="nama" placeholder="Enter full name" name="up_kategori" value="' . $result->fetch_assoc()['nama'] . '"> <input type="hidden" name="up_id" value="' . $_POST['id'] . '">';
