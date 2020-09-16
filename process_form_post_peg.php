<?php
require_once('Db.php');
$db = new Db();
$result = $db->query("SELECT * FROM pegawai WHERE idpegawai=" . $_POST['id'] . "")->fetch_all()[0];

$cek = '';
$cek2 = '';
$id = $result[0];
$username = $result[1];
$namal = $result[2];
$email = $result[3];
$pass = $result[4];




if ($result[5] == 1) {
    $cek = "checked";
} else {
    $cek2 = "checked";
}

echo '
<div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username2" value="' . $username . '">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter full name" name="name2" value="' . $namal . '">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email2" value="' . $email . '">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="Password1">Password</label>
                                    <input type="password" class="form-control" id="Password1" placeholder="Password" name="password2" value="">
                                </div>
                                <div class="form-group">
                                    <label for="Password2">Password verification</label>
                                    <input type="password" class="form-control" id="Password2" placeholder="Re-type password" name="password22">
                                </div>
                            
                            </div>
                            <input type="hidden" name="up_id2" value="' . $id . '">
';
/* <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="radio2" name="level2" class="custom-control-input" value="1" ' . $cek . '>
                                        <label class="custom-control-label" for="radio2">Manager</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="radio1" name="level2" class="custom-control-input" value="2" ' . $cek2 . '>
                                        <label class="custom-control-label" for="radio1">Admin</label>
                                    </div>
                                </div> */
