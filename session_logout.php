<?php 
session_start();
 // Alihkan pengguna ke halaman login
        $_SESSION['logout_success'] = 'Logout Berhasil!';
header("Location: login/");
?>