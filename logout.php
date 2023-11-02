<?php
session_start();

// Hapus semua data session
session_unset();
session_destroy();

// Tambahkan session "logout_success" untuk memberi tahu index.php bahwa logout berhasil
setcookie('logout_success', "Anda telah berhasil logout.", time() + 60, '/'); // Cookie berlaku selama 1 menit

// Alihkan pengguna ke halaman login
header("Location: login/");
exit();
?>
