<?php
session_start();
if (!isset($_SESSION['pegawai'])) {
    header("Refresh: 0; url=index.php");
}
require_once('Controller.php');
$controller = new Controller();

require_once('Db.php');
$db = new Db();
$result = $db->query('SELECT * FROM sub_kategori ORDER BY sub_kategori.nama');
$kategori = $db->query('SELECT * FROM kategori');



if (isset($_POST['add'])) {
    if ($_POST['skategori'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['skategori'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Hanya Boleh Berisi Huruf";
    } else if (mysqli_num_rows($db->query('SELECT * FROM sub_kategori WHERE kategori="' . $_POST['idkat'] . '" AND nama="' . $_POST['skategori'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori sudah ada";
    } else if ($_POST['idkat'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Tidak Boleh Kosong";
    } else {
        if ($db->addSKategori($_POST['skategori'], $_POST['idkat'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "added";
            header("Refresh: 0.1; url=view_skategori.php");
        }
    }
}

if (isset($_GET['id'])) {
    if ($db->deleteSKategori($_GET['id'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "deleted";
        header("Refresh: 0.1; url=view_skategori.php");
    }
}

if (isset($_POST['update'])) {
    if ($_POST['name2'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Tidak Boleh Kosong";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name2'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Hanya Boleh Berisi Huruf";
    } else if (mysqli_num_rows($db->query('SELECT * FROM sub_kategori WHERE kategori="' . $_POST['idkat'] . '" AND nama="' . $_POST['name2'] . '"')) != 0) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori sudah ada";
    } else if ($_POST['idkat'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Kategori Tidak Boleh Kosong";
    } else {
        if ($db->updateSKategori($_POST['up_id2'], $_POST['name2'], $_POST['idkat'])) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "updated";
            header("Refresh: 0.1; url=view_skategori.php");
        }
    }
}

if (isset($_SESSION['time']) && (time() - $_SESSION['time']) > 2) {
    unset($_SESSION['alert']);
    unset($_SESSION['time']);
}

$controller->view('header.php');
?>
<div class="main-content pl-3">
    <div class="row pl-3 mr-3">
        <div class="tab_atas col-md-12">
            <h3>Tabel Sub-Kategori</h3>
            <!-- <form class="form-inline mt-3" action="view_skategori.php" method="POST">
                <div class="form-group mb-2">
                    <label for="create" class="sr-only">Add Sub-kategori</label>
                    <input type="text" class="form-control" id="create" name="skategori" placeholder="Add Sub-kategori">
                </div>
                <button type="submit" class="btn btn-primary mb-2" name="add">Add</button>
            </form> -->

            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModalCenter" onclick="<?php $_SESSION['add'] = true; ?>">
                Tambah Sub-Kategori <i class="fas fa-plus-circle"></i>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Sub-Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="view_skategori.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Sub-Kategori</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter sub-kategori name" name="skategori">
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select class="custom-select" id="kategori" name="idkat">
                                        <option selected value="kat">Kategori</option>
                                        <?php
                                        while ($val = $kategori->fetch_assoc()) {
                                            echo '<option value="' . $val['idkategori'] . '">' . $val['nama'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="add">Add</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pl-3 mr-3 mt-3">
        <div class="tab_bawah col-md-12">
            <table class="table table-hover table2 mt-2" id="table3">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Sub-Kategori</th>
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
                            <td><?php echo $db->query('SELECT nama FROM kategori WHERE kategori.idkategori = ' . $data['kategori'] . '')->fetch_assoc()['nama']; ?></td>
                            <td>
                                <button onclick="javascript:view_input_post_skat(<?= $data['idsub_kategori'] ?>);" id="btn_update" data-toggle="modal" data-target="#exampleModalCenter2">
                                    <i class="fas fa-pencil-alt pl-2" style="color: black;" data-toggle="modal" data-target="#exampleModalCenter2"></i>
                                </button>
                                <a href="<?= 'view_skategori.php?id=' . $data['idsub_kategori'] ?>">
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
                            <h5 class="modal-title" id="exampleModalLongTitle">Update Sub-Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">

                            <div class="modal-body">
                                <div class="form-group">
                                    <div id="input_skategori"></div>
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