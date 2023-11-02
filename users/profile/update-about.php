<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX

// update-about.php


$query = "SELECT * FROM users WHERE id_user = $id_users";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nama_user = $row["nama_user"];
    $username = $row["username"];
    $gender = $row["gender"];
    $no_hp = $row["no_hp"];
    $email = $row["email"];
} else {
    $nama_user = "Nama Pengguna Tidak Ditemukan";
    $username = "Username Tidak Ditemukan";
    $gender = "Gender Tidak Ditemukan";
    $no_hp = "No Handphone Tidak Ditemukan";
    $email = "Email Tidak Ditemukan";
}

$aboutData = "
<div class='card card-primary'>
    <div class='card-header'>
        <h3 class='card-title'>Tentang Saya</h3>
    </div>
    <div class='card-body'>
        <strong><i class='fas fa-user mr-1'></i> Nama Lengkap</strong>
        <p class='text-muted'>$nama_user</p>
        <hr>
        <strong><i class='fas fa-user-circle mr-1'></i> Username</strong>
        <p class='text-muted'>$username</p>
        <hr>
        <strong><i class='fas fa-venus-mars mr-1'></i> Jenis Kelamin</strong>
        <p class='text-muted'>" . ($gender === 'Laki-Laki' ? "<span class='tag tag-danger'>Laki - Laki</span>" : "<span class='tag tag-danger'>Perempuan</span>") . "</p>
        <hr>
        <strong><i class='fas fa-phone mr-1'></i> No Handphone</strong>
        <p class='text-muted'>$no_hp</p>
        <hr>
        <strong><i class='fas fa-envelope mr-1'></i> Email</strong>
        <p class='text-muted'>$email</p>
    </div>
</div>
";

header('Content-Type: application/json');
echo json_encode(['aboutData' => $aboutData]);
mysqli_close($koneksi);
?>
