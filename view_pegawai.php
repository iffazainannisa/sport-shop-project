<?php
session_start();
if (!isset($_SESSION['pegawai'])) {
    header("Refresh: 0; url=index.php");
}
require_once('Controller.php');
$controller = new Controller();
require_once('Db.php');
$db = new Db();
$result = $db->query('SELECT * FROM pegawai ORDER BY pegawai.username');

if (isset($_POST['add'])) {
    if ($_POST['username'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Username Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST['username'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Username Hanya Boleh Berisi Huruf dan Angka";
    } else if (mysqli_num_rows($db->query('SELECT username FROM pegawai WHERE username="' . $_POST['username'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Username sudah ada";
    } else if ($_POST['name'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Hanya Boleh Berisi Huruf";
    } else if (mysqli_num_rows($db->query('SELECT nama_lengkap FROM pegawai WHERE nama_lengkap="' . $_POST['name'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name sudah ada";
    } else if ($_POST['email'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Email Tidak Boleh Kosong";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Email Tidak Valid";
    } else if (mysqli_num_rows($db->query('SELECT email FROM pegawai WHERE email="' . $_POST['email'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Email sudah ada";
    } else if ($_POST['password'] != $_POST['password2']) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Password dan Password Verification Harus Sama";
    } else {
        if ($db->addPegawai($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['level'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "added";
            header("Refresh: 0.1; url=view_pegawai.php");
        }
    }
}

if (isset($_GET['id'])) {
    if ($db->deletePegawai($_GET['id'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "deleted";
        header("Refresh: 0.1; url=view_pegawai.php");
    }
}

if (isset($_POST['update'])) {
    if ($_POST['username2'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Username Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST['username2'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Username Hanya Boleh Berisi Huruf dan Angka";
    } else if ($_POST['name2'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name2'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Hanya Boleh Berisi Huruf";
    } else if ($_POST['email2'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Email Tidak Boleh Kosong";
    } else if (!filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Email Tidak Valid";
    } else if ($_POST['password2'] != $_POST['password22']) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Password dan Password Verification Harus Sama";
    } else {
        if ($db->updatePegawai($_POST['up_id2'], $_POST['username2'], $_POST['name2'], $_POST['email2'], $_POST['password2'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "updated";
            header("Refresh: 0.1; url=view_pegawai.php");
        }
    }
}

if (isset($_SESSION['time']) && (time() - $_SESSION['time']) > 2) {
    unset($_SESSION['alert']);
}

$controller->view('header.php');
?>

<div class="main-content pl-3">

    <div class="row pl-3 mr-3">
        <div class="tab_atas col-md-12">
            <h3>Tabel Pegawai</h3>
            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModalCenter">
                Tambah pegawai <i class="fas fa-user-plus"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="view_pegawai.php" method="POST">

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter full name" name="name">
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="Password1">Password</label>
                                    <input type="password" class="form-control" id="Password1" placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="Password2">Password verification</label>
                                    <input type="password" class="form-control" id="Password2" placeholder="Re-type password" name="password2">
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="radio2" name="level" class="custom-control-input" value="1" checked>
                                    <label class="custom-control-label" for="radio2">Manager</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="radio1" name="level" class="custom-control-input" value="2">
                                    <label class="custom-control-label" for="radio1">Admin</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="add">Add</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pl-3 mr-3 mt-3">
        <div class="tab_bawah col-md-12">
            <table class="table table-hover " id="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Email</th>
                        <th scope="col">Level</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    while ($data = $result->fetch_assoc()) : ?>
                        <tr>
                            <td scope="row"><?= $i ?></td>
                            <td><?= $data['username']; ?></td>
                            <td><?= $data['nama_lengkap']; ?></td>
                            <td><?= $data['email']; ?></td>
                            <td><?= $data['level']; ?></td>
                            <td>
                                <button onclick="javascript:view_input_post_peg(<?= $data['idpegawai'] ?>);" id="btn_update">
                                    <i class="fas fa-pencil-alt pl-2" style="color: black;" data-toggle="modal" data-target="#exampleModalCenter2"></i>
                                </button>
                                <a href="<?= 'view_pegawai.php?id=' . $data['idpegawai'] ?>">
                                    <i class="fas fa-trash ml-4" style="color: red;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    endwhile;
                    ?>
                </tbody>
            </table>

            <?php if (isset($_SESSION['alert'])) : ?>
                <div aria-live="polite" aria-atomic="true" style="position: fixed; min-height: 200px;min-width:300px;top:82%;left:76%;" class="notif">
                    <div class="toast" style="position: absolute; top: 0; right:0;" data-autohide="false">
                        <div class="toast-header">
                            <i class="rounded mr-2 fas fa-bell" style="color:blue;"></i>
                            <strong class="mr-auto">Alert</strong>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <?= $_SESSION['alert'] ?>.
                        </div>
                    </div>
                </div>
            <?php
            endif; ?>

            <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Update Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">

                            <div class="modal-body">
                                <div id="input_kategori"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="update">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$controller->view('footer.php');
?>