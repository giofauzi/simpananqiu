
<?php
// Sesuaikan dengan koneksi database Anda
include "../../koneksi.php";

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_admin'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['transaksi'])) {
        echo "Transaksi tidak boleh kosong.";
    } else if (empty($_POST['nama_kategori'])) {
        echo "Nama kategori tidak boleh kosong.";
    } else {
        $id_admin = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
        $transaksi = mysqli_real_escape_string($koneksi, $_POST['transaksi']);
        $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

            // Lanjutkan dengan query untuk menambahkan data
            date_default_timezone_set('Asia/Jakarta');
            $currentDateTime = date('Y-m-d H:i:s');
            $query = "INSERT INTO kategori (id_admin, transaksi, nama_kategori, tgl_b) VALUES ('$id_admin', '$transaksi', '$nama_kategori', '$currentDateTime')";

            if (mysqli_query($koneksi, $query)) {
                echo "Kategori berhasil ditambahkan.";
            } else {
                echo "Terjadi kesalahan saat menambahkan kategori: " . mysqli_error($koneksi);
            }
        }
    }
 else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}


// Tutup koneksi database
mysqli_close($koneksi);
?>
