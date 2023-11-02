<?php 
session_start();
unset($_SESSION['user_verifikasi']);
unset($_SESSION['verifikasi']);
$_SESSION['gagal_password'] = "Oops, Coba Lagi!";
header("Location: ../login/index.php");
?>