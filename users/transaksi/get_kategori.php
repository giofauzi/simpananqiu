<?php
// Koneksi ke database (sesuaikan dengan informasi koneksi Anda)
include '../../koneksi.php';

// Periksa jenis transaksi yang dikirim dari permintaan AJAX
if (isset($_GET['transaksi'])) {
  $transaksi = $_GET['transaksi'];
  $id_user = $_GET['id_user'];
  
  // Query database untuk mendapatkan kategori berdasarkan jenis transaksi
  $query = "SELECT id_kategori, nama_kategori FROM kategori WHERE id_user = '$id_user' AND transaksi = '$transaksi'";
  $result = mysqli_query($koneksi, $query);

  $options = '<option value="">Pilih</option>'; // Opsi pertama kosong
  while ($row = mysqli_fetch_array($result)) {
    $options .= '<option value="' . $row['id_kategori'] . '">' . $row['nama_kategori'] . '</option>';
  }

  echo $options;
}
?>
