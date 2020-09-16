<?php
session_start();
if (!isset($_SESSION['pegawai'])) {
    header("Refresh: 0; url=index.php");
}
require_once('Controller.php');
$controller = new Controller();
require_once('Db.php');
$db = new Db();
$result = $db->query('SELECT * FROM produk JOIN pegawai ON pegawai.idpegawai = produk.idpegawai ORDER BY produk.last_update DESC');
$kategori = $db->query('SELECT * FROM kategori');
$sKategori = $db->query('SELECT * FROM sub_kategori');


if (isset($_POST['add'])) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $target_dir = "images/";
    $upload_name = substr(str_shuffle($permitted_chars), 0, 6) . '_' . basename($_FILES['userfile']['name']);
    $target_file = $target_dir . $upload_name;
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    $allowed_type = array("jpg", "png", "jpeg", "gif");

    if ($_POST['name'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Tidak Boleh Kosong";
    } else if ($_POST['deskripsi'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Deskripsi Tidak Boleh Kosong";
    } else if ($_POST['harga'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Harga Tidak Boleh Kosong";
    } else if ($_POST['idsub'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Tidak Boleh Kosong";
    } else if ($_FILES['userfile']['error'] > 0) {
        echo 'Problem: ';
        switch ($_FILES['userfile']['error']) {
            case 1:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'File format not supported';
                break;
            case 2:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'File exceeded max_file_size';
                break;
            case 3:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'File only partially uploaded';
                break;
            case 4:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'No file uploaded';
                break;
            case 6:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'Cannot upload file: No temp directory specified';
                break;
            case 7:
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'Upload failed: Cannot write to disk';
                break;
                exit;
        }
    } else if ($_FILES['userfile']['size'] > 10000000) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sorry, your file is too large";
        die;
    } else if (!in_array($file_type, $allowed_type)) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        die;
    } else if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
            return false;
        } else {
            if ($db->addProduk($_POST['name'], $_POST['deskripsi'], $_POST['harga'], $_POST['idsub'], $_SESSION['pegawai']['id'], $upload_name)) {
                $_SESSION['time'] = time();
                $_SESSION['alert'] = "added";
                header("Refresh: 0.1; url=view_produk.php");
            } else {
                $_SESSION['time'] = time();
                $_SESSION['alert'] = 'error uploading';
            }
        }
    } else {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = 'error uploading';
    }
}

if (isset($_GET['id']) && isset($_GET['file'])) {
    if ($db->deleteProduk($_GET['id'], $_GET['file'])) {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "deleted";
        header("Refresh: 0.1; url=view_produk.php");
    }
}

if (isset($_POST['update'])) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $target_dir = "images/";
    $upload_name = substr(str_shuffle($permitted_chars), 0, 6) . '_' . basename($_FILES['userfile']['name']);
    $target_file = $target_dir . $upload_name;
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    $allowed_type = array("jpg", "png", "jpeg", "gif");
    $old_file = 'images/' . $_POST['old_file'];

    if ($_POST['nama_produk'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Name Tidak Boleh Kosong";
    } else if ($_POST['deskripsi'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Deskripsi Tidak Boleh Kosong";
    } else if ($_POST['harga'] == '') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Harga Tidak Boleh Kosong";
    } else if ($_POST['idsub'] == 'sub') {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "Sub-Kategori Tidak Boleh Kosong";
    } else if (isset($_FILES['userfile'])) {
        if ($_FILES['userfile']['error'] > 0) {
            echo 'Problem: ';
            switch ($_FILES['userfile']['error']) {
                case 1:
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = 'File format not supported';
                    break;
                case 2:
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = 'File exceeded max_file_ size';
                    break;
                case 3:
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = 'File only partially uploaded';
                    break;
                case 4:
                    if ($db->updateTProduk($_POST['up_id'], $_POST['nama_produk'], $_POST['deskripsi'], $_POST['harga'], $_POST['idsub'], $_SESSION['pegawai']['id'])) {
                        $_SESSION['time'] = time();
                        $_SESSION['alert'] = "product has been updated";
                        header("Refresh: 0.1; url=view_produk.php");
                    } else {
                        $_SESSION['time'] = time();
                        $_SESSION['alert'] = "error uploading";
                        header("Refresh: 0.1; url=view_produk.php");
                    }
                    break;
                case 6:
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = 'Cannot upload file: No temp directory specified';
                    break;
                case 7:
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = 'Upload failed: Cannot write to disk';
                    break;
                    exit;
            }
        } else if ($_FILES['userfile']['size'] > 10000000) {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "Sorry, your file is too large";
        } else if (!in_array($file_type, $allowed_type)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else if (is_uploaded_file($_FILES['userfile']['tmp_name']) && unlink($old_file)) {
            if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
                $_SESSION['time'] = time();
                $_SESSION['alert'] = "error uploading";
                header("Refresh: 0.1; url=view_produk.php");
            } else {
                if ($db->updateProduk($_POST['up_id'], $_POST['nama_produk'], $_POST['deskripsi'], $_POST['harga'], $_POST['idsub'], $_SESSION['pegawai']['id'], $upload_name)) {
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = "product has been updated";
                    header("Refresh: 0.1; url=view_produk.php");
                } else {
                    $_SESSION['time'] = time();
                    $_SESSION['alert'] = "error uploading";
                    header("Refresh: 0.1; url=view_produk.php");
                }
            }
        } else {
            $_SESSION['time'] = time();
            $_SESSION['alert'] = "error uploading";
        }
    } else {
        $_SESSION['time'] = time();
        $_SESSION['alert'] = "error uploading";
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
                    <h3>Tabel Produk</h3>

                    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModalCenter" onclick="<?php $_SESSION['add'] = true; ?>">
                        Tambah produk <i class="fas fa-plus-circle"></i>
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="view_produk.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" placeholder="Enter product name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi">Enter description</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="kategori">Harga</label>
                                            <input type="number" class="form-control" id="nama" placeholder="Enter product price" name="harga">
                                        </div>
                                        <div class="form-group">
                                            <label for="sub">Sub-kateggori</label>
                                            <select class="custom-select" id="sub" name="idsub">
                                                <option selected value="sub">Sub-Kategori</option>
                                                <?php
                                                while ($val = $sKategori->fetch_assoc()) {
                                                    echo '<option value="' . $val['idsub_kategori'] . '">' . $val['nama'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="userfile">
                                            <label class="custom-file-label" for="file">Choose image</label>
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

                    <table class="table table-hover mt-2" id="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Last-Update</th>
                                <th scope="col">Peng-Update</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            while ($data = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td scope="row"><?= $i ?></td>
                                    <td><?= $data['nama_produk'] ?></td>

                                    <td><?= 'Rp' . number_format($data['harga']) . ',-' ?></td>

                                    <td><?= '<img src="images/' . $data['file_gambar'] . '" alt="' . $data['file_gambar'] . '" width="50" height="50">'  ?></td>
                                    <td><?= $data['last_update'] ?></td>
                                    <td><?= $data['username'] ?></td>
                                    <td>
                                        <button onclick="javascript:view_input_post_pro(<?= $data['idproduk'] ?>);" id="btn_update">
                                            <i class="fas fa-pencil-alt pl-2" style="color: black;" data-toggle="modal" data-target="#exampleModalCenter2"></i>
                                        </button>
                                        <a href="<?= 'view_produk.php?id=' . $data['idproduk'] . '&file=' . $data['file_gambar'] ?>">
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
                                    <h5 class="modal-title" id="exampleModalLongTitle">Update Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="view_produk.php" method="POST" enctype="multipart/form-data">
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