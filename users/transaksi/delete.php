<?php 
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $categoryId = $_POST['id']; // Dapatkan ID keuangan yang akan dihapus

  // Periksa apakah ada deskripsi terkait dengan keuangan yang dihapus
  $query = "SELECT deskripsi FROM keuangan WHERE id_keuangan = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $categoryId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $deskripsi = $row['deskripsi'];

  // Periksa apakah deskripsi berisi gambar (nama file tanpa spasi)
  if (preg_match('/\S+\.(jpg|jpeg|png|gif)/i', $deskripsi)) {
    $deskripsiPath = "../../data/img/transaksi/" . $deskripsi;

    // Periksa apakah file gambar ada dan hapus jika ditemukan
    if (file_exists($deskripsiPath)) {
      unlink($deskripsiPath);
    }
  }

  // Lakukan proses penghapusan data dari database
  $query = "DELETE FROM keuangan WHERE id_keuangan = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $categoryId);

  if (mysqli_stmt_execute($stmt)) {
    // Berhasil menghapus keuangan
    echo 'success'; // Atau berikan respons JSON jika diperlukan
  } else {
    // Gagal menghapus keuangan
    echo 'error'; // Atau berikan respons JSON jika diperlukan
  }
}

?>