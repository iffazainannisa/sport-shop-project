<?php
session_start();
if (!isset($_SESSION['pegawai'])) {
    header("Refresh: 0; url=index.php");
}
require_once('Controller.php');
$controller = new Controller();
require_once('Db.php');
$db = new Db();
$result = $db->query('SELECT * FROM kategori ORDER BY kategori.nama');
//mysqli_num_rows($sama) >= 1
if (isset($_POST['add'])) {
    if ($_POST['kategori'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['kategori'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Hanya Boleh Berisi Huruf";
    } else if (mysqli_num_rows($db->query('SELECT nama FROM kategori WHERE nama="' . $_POST['kategori'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori sudah ada";
    } else {
        if ($db->add($_POST['kategori'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "added";
            header("Refresh: 0.1; url=view_kategori.php");
        }
    }
}

if (isset($_GET['id'])) {
    if ($db->delete($_GET['id'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "deleted";
        header("Refresh: 0.1; url=view_kategori.php");
    }
}

if (isset($_POST['update'])) {
    if ($_POST['up_kategori'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['up_kategori'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Hanya Boleh Berisi Huruf";
    } else {
        if ($db->update($_POST['up_id'], $_POST['up_kategori'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "updated";
            header("Refresh: 0.1; url=view_kategori.php");
        }
    }
}

if (isset($_SESSION['time']) && (time() - $_SESSION['time']) > 2) {
    unset($_SESSION['alert']);
}
$controller->view('header.php');
?>
<!-- MAIN CONTENT-->
<div class="main-content pl-3">
    <div class="row pl-3 mr-3">
        <div class="tab_atas col-md-12">
            <h3>Tabel Kategori</h3>
            <form class="form-inline mt-3" action="view_kategori.php" method="POST">
                <div class="form-group mb-2">
                    <label for="create" class="sr-only">Add kategori</label>
                    <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Add Kategori">
                </div>
                <button type="submit" class="btn btn-primary mb-2" name="add">Add</button>
            </form>
        </div>
    </div>
    <div class="row pl-3 mr-3 mt-3">
        <div class="tab_bawah col-md-12">
            <table class="table table-hover table2" id="table2">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    while ($data = $result->fetch_assoc()) : ?>
                        <tr>
                            <td scope="row"><?= $i ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td>
                                <button onclick="javascript:view_input_post_kat(<?= $data['idkategori'] ?>);" id="btn_update">
                                    <i class="fas fa-pencil-alt pl-2" style="color: black;" data-toggle="modal" data-target="#exampleModalCenter"></i>
                                </button>
                                <a href="<?= 'view_kategori.php?id=' . $data['idkategori'] ?>">
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
        </div>
    </div>
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

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
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
<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->

<?php
$controller->view('footer.php');
?>