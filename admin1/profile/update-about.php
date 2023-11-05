<?php
include "../../koneksi.php";
$id_admin = $_GET['id_admin']; // Terima parameter dari permintaan AJAX

// update-about.php


$query = "SELECT * FROM admin WHERE id_admin = $id_admin";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nama_admin = $row["nama_admin"];
    $username = $row["username"];
    
} else {
    $nama_admin = "Nama Pengguna Tidak Ditemukan";
    $username = "Username Tidak Ditemukan";
   
}

$aboutData = "
<div class='card card-primary'>
    <div class='card-header'>
        <h3 class='card-title'>Tentang Saya</h3>
    </div>
    <div class='card-body'>
        <strong><i class='fas fa-user mr-1'></i> Nama Lengkap</strong>
        <p class='text-muted'>$nama_admin</p>
        <hr>
        <strong><i class='fas fa-user-circle mr-1'></i> Username</strong>
        <p class='text-muted'>$username</p>
        <hr>
    </div>
</div>
";

header('Content-Type: application/json');
echo json_encode(['aboutData' => $aboutData]);
mysqli_close($koneksi);
?>
