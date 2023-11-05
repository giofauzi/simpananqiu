<?php 
session_start();
 // Alihkan pengguna ke halaman login
        $_SESSION['login_session_out'] = 'Sesi Anda telah kedaluwarsa. Silakan login kembali.';
header("Location: ../admin/");
?>