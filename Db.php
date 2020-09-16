<?php
//File : Db.php
//Deskripsi	: menyimpan parameter untuk koneksi ke database
class Db
{
    private $db;

    function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'db_tokool2');
        if ($this->db->connect_errno) {
            die("Could not connect to the database: <br />" . $this->db->connect_error);
        }
    }

    public function query($query)
    {
        // Execute the query
        $result = $this->db->query($query);
        if (!$result) {
            die("Could not query the database: <br />" . $this->db->error);
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->db->query('DELETE FROM kategori WHERE idkategori=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function update($id, $name)
    {
        $result = $this->db->query('UPDATE kategori SET nama="' . $name . '" WHERE idkategori=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function add($item)
    {
        $result = $this->db->query('INSERT INTO kategori (idkategori,nama) VALUES ( "","' . $item . '")');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    //skategori
    public function addSKategori($item, $ksk)
    {
        $result = $this->db->query('INSERT INTO sub_kategori (idsub_kategori,nama,kategori) VALUES ( "","' . $item . '",' . $ksk . ')');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
    public function deleteSKategori($id)
    {
        $result = $this->db->query('DELETE FROM sub_kategori WHERE idsub_kategori=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function updateSKategori($id, $name, $ksk)
    {
        $result = $this->db->query('UPDATE sub_kategori SET nama="' . $name . '", kategori="' . $ksk . '" WHERE idsub_kategori=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    //pegawai
    public function addPegawai($username, $namalengkap, $email, $password, $level)
    {
        $result = $this->db->query('INSERT INTO pegawai (username, nama_lengkap, email, password, level) VALUES ("' . $username . '","' . $namalengkap . '","' . $email . '","' . $password . '","' . $level . '")');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
    public function deletePegawai($id)
    {
        $result = $this->db->query('DELETE FROM pegawai WHERE idpegawai=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function updatePegawai($id, $username, $namalengkap, $email, $password)
    {
        $result = $this->db->query('UPDATE pegawai SET username="' . $username . '",nama_lengkap="' . $namalengkap . '",email="' . $email . '",password="' . $password . '" WHERE idpegawai=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    //produk
    public function addProduk($nama, $deskripsi, $harga, $idsub, $idpeg, $upload_name = 'default.png')
    {
        $result = $this->db->query('INSERT INTO produk (nama_produk,deskripsi,harga,idsub_kategori,idpegawai,file_gambar) VALUES ( "' . $nama . '","' . $deskripsi . '",' . $harga . ',' . $idsub . ',' . $idpeg . ',"' . $upload_name . '")');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
    public function deleteProduk($id, $file)
    {
        $file = 'images/' . $file;
        if (!unlink($file)) {
            echo ("Error deleting $file");
            return false;
        } else {
            $result = $this->db->query('DELETE FROM produk WHERE idproduk=' . $id . '');
            if (!$result) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function updateProduk($id, $name, $deskripsi, $harga, $idsub, $idpeg, $file_name = 'default.png')
    {

        $result = $this->db->query('UPDATE produk SET nama_produk="' . $name . '",deskripsi="' . $deskripsi . '",harga="' . $harga . '",idsub_kategori="' . $idsub . '",idpegawai="' . $idpeg . '",file_gambar="' . $file_name . '" WHERE idproduk=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function updateTProduk($id, $name, $deskripsi, $harga, $idsub, $idpeg)
    {
        $result = $this->db->query('UPDATE produk SET nama_produk="' . $name . '",deskripsi="' . $deskripsi . '",harga="' . $harga . '",idsub_kategori="' . $idsub . '",idpegawai="' . $idpeg . '" WHERE idproduk=' . $id . '');
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
}
