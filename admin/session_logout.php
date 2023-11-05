<?php 
session_start();
 // Alihkan pengguna ke halaman login
        $_SESSION['logout_message'] = 'Logout Berhasil!';
header("Location: ../admin/");
?>