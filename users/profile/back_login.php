<?php 
session_start();
 // Alihkan pengguna ke halaman login
        $_SESSION['delete-account'] = 'Sampai Jumpa Kembali!';
header("Location: ../../../simpananqiu/login/");
?>