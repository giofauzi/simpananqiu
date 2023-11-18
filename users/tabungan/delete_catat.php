<?php 
  include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $TabunganID = $_POST['id']; // Dapatkan ID catat tabungan yang akan dihapus

  // Lakukan proses penghapusan data dari database
  
  // Gunakan prepared statement untuk menghindari serangan SQL Injection
  $query = "DELETE FROM catat_tabungan WHERE id_catat = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $TabunganID);

  if (mysqli_stmt_execute($stmt)) {
    // Berhasil menghapus catat tabungan
    echo 'success'; // Atau berikan respons JSON jika diperlukan
  } else {
    // Gagal menghapus catat tabungan
    echo 'error'; // Atau berikan respons JSON jika diperlukan
  }
}
?>
