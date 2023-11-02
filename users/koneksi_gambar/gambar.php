<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX

$query = "SELECT * FROM users WHERE id_user = $id_users";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
  
    $foto = $row['foto']; // Pindahkan pengambilan foto ke dalam blok yang sama
} else {
    $username = "Username Tidak Ditemukan";
    $foto = "Foto Tidak Ditemukan"; // Anda dapat mengganti ini sesuai kebutuhan
}

$aboutGambar = "

    <div class='image'>
        <img class='img-circle elevation-2'
            src='../../data/img/users/{$foto}'
            alt='User profile picture'>
             </div>
        <div class='info'>
            <a href='../profile/profile.php' class='d-block'>$username</a>
        </div>

        
   

";

header('Content-Type: application/json');
echo json_encode(['aboutGambar' => $aboutGambar]);
mysqli_close($koneksi);
?>
