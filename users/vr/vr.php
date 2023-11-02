<?php
session_start(); // Pastikan sesi sudah dimulai

include "../../koneksi.php";

// Tambah Data Verifikasi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    // Validasi input
    $errors = [];

    if (empty($_POST['id_users'])) {
        $errors[] = 'id_users tidak boleh kosong';
    } else {
        $id_users = $_POST['id_users'];
    }

    if (empty($_POST['vr'])) {
        $errors[] = 'vr tidak boleh kosong';
    } else {
        $vr = mysqli_real_escape_string($koneksi, $_POST['vr']);
    }

    // Lakukan hash password
    $hashedPassword = password_hash($vr, PASSWORD_DEFAULT);

    if (empty($errors)) {
        // Query untuk mengupdate data di tabel "users"
        // Mengambil tanggal dan waktu saat ini dalam format datetime
        date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke Indonesia
        $currentDateTime = date('Y-m-d H:i:s');

        $query = "UPDATE users SET tgl_e = '$currentDateTime', vr = '$hashedPassword' WHERE id_user = '$id_users'";

        // Eksekusi query untuk "users"
        if (mysqli_query($koneksi, $query)) {
            $query = "SELECT * FROM users WHERE id_user = ?";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_users);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $st_vr = mysqli_fetch_assoc($result);
            // Berhasil diupdate
            $_SESSION['status_vr'] = $st_vr['vr'];
            header("Location: ../lockscreen.php");
            exit();
        } else {
            // Terjadi kesalahan saat eksekusi query "users"
            $_SESSION['gagal'] = 'Terjadi kesalahan saat mengupdate data di tabel "users": ' . mysqli_error($koneksi);
            header("Location: index.php");
            exit();
        }
    } else {
        // Terdapat error validasi input
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    }
}

// Sweetalert2
?>
<!-- Sweetalert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
