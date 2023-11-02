<?php 
  include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $categoryId = $_POST['id']; // Dapatkan ID aset yang akan dihapus

  // Lakukan proses penghapusan data dari database
  
  // Gunakan prepared statement untuk menghindari serangan SQL Injection
  $query = "DELETE FROM aset WHERE id_aset = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $categoryId);

  if (mysqli_stmt_execute($stmt)) {
    // Berhasil menghapus aset
    echo 'success'; // Atau berikan respons JSON jika diperlukan
  } else {
    // Gagal menghapus aset
    echo 'error'; // Atau berikan respons JSON jika diperlukan
  }
}
?>
