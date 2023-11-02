<?php 
session_start();
 // Alihkan pengguna ke halaman login
        $_SESSION['belum_login'] = 'Sesi Anda telah kedaluwarsa. Silakan login kembali.';
header("Location: ../../../simpananqiu/login/");
?>