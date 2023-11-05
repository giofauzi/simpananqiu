<?php
session_start();
// Informasi koneksi database
include '../../koneksi.php';

// Periksa apakah sesi 'user_login'  sudah diinisialisasi
if (!isset($_SESSION['admin_login'])) {
$_SESSION['no_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
    header("Location: ../../../simpananqiu/admin/"); // Ganti dengan halaman login yang sesuai
    exit();
}

// Periksa apakah sesi 'admin_login'  sudah sesuai, misalnya dengan database
$id_admin = $_SESSION['admin_login'];


// Query database untuk memeriksa apakah 'id_admin'
$query = "SELECT * FROM admin WHERE id_admin = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $id_admin,);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    // Jika 'id_admin'  tidak sesuai dengan database, alihkan ke halaman login
   $_SESSION['no_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
    header("Location: ../../../simpananqiu/admin/"); // Ganti dengan halaman login yang sesuai
    exit();
}

// Cek apakah sesi timeout sudah diatur atau belum
if (isset($_SESSION['admin_last_activity'])) {
    // Hitung selisih waktu
    $now = time();
    $admin_last_activity = $_SESSION['admin_last_activity'];
    $timeout_duration = 60 * 60 * 6; // 6 jam 
    if ($now - $admin_last_activity > $timeout_duration) {
        // Matikan sesi
        session_unset();
        session_destroy();

       
        header("Location: ../back_login.php"); // Ganti dengan halaman login yang sesuai
        exit();
    }
}

// Perbarui waktu terakhir aktivitas
$_SESSION['admin_last_activity'] = time();

// Jika sesi valid, Anda dapat melanjutkan dengan kode Anda yang menggunakan $id_admin, dan $admin


$result = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = $id_admin");
$all = mysqli_fetch_array($result);