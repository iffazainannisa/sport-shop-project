
<?php
// Include our login information
require_once("db_login.php");
$error = "";

// Connect
$db = mysqli_connect($db_host, $db_username, $db_password, $db_database);
if ($db->connect_errno) {
    die("Could not connect to the database: <br />" . $db->connect_error);
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $query = "SELECT * FROM pegawai WHERE username = '$username' AND password = '$password'";
    $result = $db->query($query);

    if ($result) {
        $rows = $result->num_rows;

        if ($rows == 1) {
            $login_result = $result->fetch_object();
            session_start();
            $_SESSION["idpegawai"] = $login_result->idpegawai;
            $_SESSION["password"] = $login_result->password;
            if ($login_result->level == 1) {
                $pegawai = ['id' => $login_result->idpegawai, 'nama' => $login_result->username, 'email' => $login_result->nama_lengkap, 'level' => 1];
                $_SESSION['pegawai'] = $pegawai;
                header("location: admin.php");
            } else if ($login_result->level == 2) {
                header("location: manager.php");
            } else {
                header("location: index.php");
            }
        } else {
            $error = "<div class='alert alert-danger' role='alert'>Maaf Akun Anda Tidak Terdaftar</div>";
            //header("location: index.php");    
        }
    }
}
?>