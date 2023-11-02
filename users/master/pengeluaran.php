<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Ambil id_users dari permintaan AJAX
$transaksi = $_GET['transaksi']; // Ambil transaksi dari permintaan AJAX
 // Koneksi ke database atau sumber data
   

$result = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_user = $id_users AND transaksi = '$transaksi'");

while ($d = mysqli_fetch_array($result)) {
  echo '<div class="col-md-4">';
  echo '  <div class="card mb-4">';
  echo '    <div class="card-body clickable">';
  echo '      <h5 class="card-title text-bold mb-2">Nama Kategori</h5>';
  echo '      <p class="card-text nama_kategori_pengeluaran" data-id="' . $d['id_kategori'] . '">' . $d['nama_kategori'] . '</p>';
  echo '      <p class="card-text id_user_pengeluaran" style="display:none;">' . $d['id_user'] . '</p>';
  echo '      <p class="card-text transaksi_pengeluaran" style="display:none;">' . $d['transaksi'] . '</p>';
  echo '      <a href="#" class="btn btn-warning edit-pengeluaran"><i class="fa fa-pen"></i></a>';
  echo '     <a href="#" class="btn btn-danger delete-pengeluaran" data-id="' . $d['id_kategori'] . '"><i class="fa fa-trash"></i></a>
';
  echo '    </div>';
  echo '  </div>';
  echo '</div>';
}

?>
