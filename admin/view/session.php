<?php
session_start();
// Informasi koneksi database
$host = "localhost"; // Ganti dengan host database Anda
$dbname = "simpananqiu"; // Ganti dengan nama database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$koneksi = mysqli_connect($host, $username, $password, $dbname);

// Periksa apakah sesi 'user_login'  sudah diinisialisasi
if (!isset($_SESSION['admin_login'])) {
$_SESSION['belum_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
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
    $_SESSION['belum_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
    header("Location: ../../../simpananqiu/admin/"); // Ganti dengan halaman login yang sesuai
    exit();
}

// Jika sesi valid, Anda dapat melanjutkan dengan kode Anda yang menggunakan $id_admin, dan $admin
// ...

$result = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = $id_admin");
$all = mysqli_fetch_array($result);