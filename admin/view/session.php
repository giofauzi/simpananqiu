<?php
session_start();
// Informasi koneksi database
$host = "localhost"; // Ganti dengan host database Anda
$dbname = "simpananqiu"; // Ganti dengan nama database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$koneksi = mysqli_connect($host, $username, $password, $dbname);

// Periksa apakah sesi 'user_login' dan 'status_vr' sudah diinisialisasi
if (!isset($_SESSION['user_login']) || !isset($_SESSION['status_vr'])) {
    $_SESSION['belum_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
    header("Location: ../../../simpananqiu/login/"); // Ganti dengan halaman login yang sesuai
    exit();
}

// Periksa apakah sesi 'user_login' dan 'status_vr' sudah sesuai, misalnya dengan database
$id_users = $_SESSION['user_login'];
$status_vr = $_SESSION['status_vr'];

// Query database untuk memeriksa apakah 'id_users' sesuai dengan 'status_vr'
$query = "SELECT * FROM users WHERE id_user = ? AND vr = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "is", $id_users, $status_vr);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    // Jika 'id_users' dan 'status_vr' tidak sesuai dengan database, alihkan ke halaman login
    $_SESSION['belum_login'] = 'Anda belum login, silakan login  terlebih dahulu.';
    header("Location: ../../../simpananqiu/login/"); // Ganti dengan halaman login yang sesuai
    exit();
}

// Jika sesi valid, Anda dapat melanjutkan dengan kode Anda yang menggunakan $id_users, $status_vr, dan $user
// ...

$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = $id_users");
$all = mysqli_fetch_array($result);


