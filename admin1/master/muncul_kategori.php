<?php
include "../../koneksi.php";

$id_admin = $_GET['id_admin']; // Ambil id_admin dari permintaan AJAX
$transaksi = $_GET['transaksi']; // Ambil grup dari permintaan AJAX

switch ($transaksi) {
    case "Pemasukan":
        // Kode untuk menampilkan aset dengan grup "Pemasukan"
        $result = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_admin = $id_admin AND transaksi = '$transaksi'");

        while ($d = mysqli_fetch_array($result)) {
            echo '<div class="col-md-4">';
            echo '  <div class="card mb-4">';
            echo '    <div class="card-body clickable">';
            echo '      <h5 class="card-title text-bold mb-2">Nama Kategori</h5>';
            echo '      <p class="card-text nama_kategori" data-id="' . $d['id_kategori'] . '">' . $d['nama_kategori'] . '</p>';
            echo '      <p class="card-text id_admin" style="display:none;">' . $d['id_admin'] . '</p>';
            echo '      <p class="card-text transaksi" style="display:none;">' . $d['transaksi'] . '</p>';
            echo '      <a href="#" class="btn btn-warning edit-category"><i class="fa fa-pen"></i></a>';
            echo '     <a href="#" class="btn btn-danger delete-category" data-id="' . $d['id_kategori'] . '"><i class="fa fa-trash"></i></a>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
        break;

    case "Pengeluaran":
        // Kode untuk menampilkan aset dengan grup "Pengeluaran"
        $result = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_admin = $id_admin AND transaksi = '$transaksi'");

        while ($d = mysqli_fetch_array($result)) {
            echo '<div class="col-md-4">';
            echo '  <div class="card mb-4">';
            echo '    <div class="card-body clickable">';
            echo '      <h5 class="card-title text-bold mb-2">Nama Kategori</h5>';
            echo '      <p class="card-text nama_kategori" data-id="' . $d['id_kategori'] . '">' . $d['nama_kategori'] . '</p>';
            echo '      <p class="card-text id_admin" style="display:none;">' . $d['id_admin'] . '</p>';
            echo '      <p class="card-text transaksi" style="display:none;">' . $d['transaksi'] . '</p>';
            echo '      <a href="#" class="btn btn-warning edit-category"><i class="fa fa-pen"></i></a>';
            echo '     <a href="#" class="btn btn-danger delete-category" data-id="' . $d['id_kategori'] . '"><i class="fa fa-trash"></i></a>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
        break;

    default:
        // Handle jika grup tidak dikenali
        echo "Grup tidak valid.";
}
?>
