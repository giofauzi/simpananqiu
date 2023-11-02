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
    $foto = $row["foto"];
} else {
    $nama_user = "Nama Pengguna Tidak Ditemukan";
    $username = "Username Tidak Ditemukan";
    $gender = "Gender Tidak Ditemukan";
    $no_hp = "No Handphone Tidak Ditemukan";
    $email = "Email Tidak Ditemukan";
}

$aboutData = "
<div class='modal fade' id='gambarModal{$id_users}' tabindex='-1' role='dialog' aria-labelledby='gambarModalLabel{$id_users}' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        
        <h5 class='modal-title' id='gambarModalLabel{$id_users}'>Gambar</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        
      </div>
      <div class='modal-body'>
        <img src='../../data/img/users/{$foto}' alt='Gambar Modal' style='max-width: 100%; height: auto;'>
      </div>
      <div class='modal-footer'>
       <a href='../../data/img/users/{$foto}' download title='Download Gambar' class='btn btn-success'><i class='fas fa-download'></i> Download</a>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
      </div>
    </div>
  </div>
</div>
";

header('Content-Type: application/json');
echo json_encode(['aboutData' => $aboutData]);
mysqli_close($koneksi);
?>
