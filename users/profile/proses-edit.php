<?php
// Include file koneksi ke database
include "../../koneksi.php";

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan melalui AJAX
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_users = $_POST['id_users'];

    // Lakukan validasi data jika diperlukan

    // Lakukan pembaruan data dalam database
    $query = "UPDATE users SET
              nama_user = '$nama_user',
              username = '$username',
              gender = '$gender',
              no_hp = '$no_hp',
              email = '$email',
              password = '$password' 
              WHERE id_user = $id_users"; // Ganti dengan kondisi yang sesuai

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Berhasil memperbarui data
        echo json_encode(['status' => 'success']);
    } else {
        // Gagal memperbarui data
        echo json_encode(['status' => 'error']);
    }
} else {
    // Permintaan bukan dari metode POST
    echo json_encode(['status' => 'error']);
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
