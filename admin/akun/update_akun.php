<?php
// Sesuaikan dengan koneksi database Anda
include "../../koneksi.php";

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['status'])) {
        echo "status tidak boleh kosong.";
    } else {
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $status = mysqli_real_escape_string($koneksi, $_POST['status']);
            // Lanjutkan dengan query untuk menambahkan data
            date_default_timezone_set('Asia/Jakarta');
            $currentDateTime = date('Y-m-d H:i:s');
            $query = "UPDATE users SET status = '$status' WHERE id_user = '$id_user'";

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
