<?php 
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_tabungan = $_POST['id']; // Dapatkan ID tabungan yang akan dihapus

  // Periksa apakah ada gambar terkait dengan tabungan yang dihapus
  $query = "SELECT gambar FROM tabungan WHERE id_tabungan = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $id_tabungan);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $gambar = $row['gambar'];

  // Periksa apakah gambar berisi gambar (nama file tanpa spasi)
  if (preg_match('/\S+\.(jpg|jpeg|png|gif)/i', $gambar)) {
    $gambarPath = "../../data/img/tabungan/" . $gambar;

    // Periksa apakah file gambar ada dan hapus jika ditemukan
    if (file_exists($gambarPath)) {
      unlink($gambarPath);
    }
  }

  // Lakukan proses penghapusan data dari tabel tabungan
  $queryDeleteTabungan = "DELETE FROM tabungan WHERE id_tabungan = ?";
  $stmtDeleteTabungan = mysqli_prepare($koneksi, $queryDeleteTabungan);
  mysqli_stmt_bind_param($stmtDeleteTabungan, "i", $id_tabungan);

  // Lakukan proses penghapusan data dari tabel catat_tabungan
  $queryDeleteCatatTabungan = "DELETE FROM catat_tabungan WHERE id_tabungan = ?";
  $stmtDeleteCatatTabungan = mysqli_prepare($koneksi, $queryDeleteCatatTabungan);
  mysqli_stmt_bind_param($stmtDeleteCatatTabungan, "i", $id_tabungan);

  // Eksekusi query penghapusan tabungan
  if (mysqli_stmt_execute($stmtDeleteTabungan) && mysqli_stmt_execute($stmtDeleteCatatTabungan)) {
    echo 'success'; // Atau berikan respons JSON jika diperlukan
  } else {
    // Gagal menghapus tabungan atau catat_tabungan
    echo 'error'; // Atau berikan respons JSON jika diperlukan
  }

  // Tutup statement
  mysqli_stmt_close($stmtDeleteTabungan);
  mysqli_stmt_close($stmtDeleteCatatTabungan);
  mysqli_close($koneksi);
}
?>
