<?php
include "../../koneksi.php";

$id_tabungan = $_GET['id_tabungan']; // Ambil id_tabungan dari permintaan AJAX


        // Kode untuk menampilkan aset dengan grup "Pemasukan"
        $result = mysqli_query($koneksi, "SELECT * FROM catat_tabungan WHERE id_tabungan = $id_tabungan ORDER BY id_catat DESC");
        while ($d = mysqli_fetch_array($result)) {
            echo '<div class="col-md-4">';
echo '  <div class="card mb-4">';
echo '    <div class="card-body d-flex flex-column">';
echo '      <div>';
echo '        <h5 class="card-title text-bold mb-2">Tambah</h5>';
echo '        <p class="card-text" style="color:green;"><i class="fas fa-arrow-up"></i> ' . number_format($d['nominal'], 2, '.', ',') . '</p>';
echo '        <p class="card-text nominal" style="display:none;">' . abs($d['nominal']) . '</p>';
echo '        <p class="card-text nomor" style="margin-top:-10px;" data-id="' . $d['id_catat'] . '"></p>';
if ($d['keterangan'] === NULL) {
    echo '        <p class="card-text" style="margin-top:-10px;">Tidak ada keterangan</p>';
} else {
    echo '        <p class="card-text keterangan" style="margin-top:-10px;">' . $d['keterangan'] . '</p>';
}
echo '        <p class="card-text id_tabungan" style="display:none;">' . $d['id_tabungan'] . '</p>';
echo '      </div>';
echo '      <div class="mt-auto ml-auto">';
echo '        <a href="#" class="btn btn-warning edit-catat"><i class="fa fa-pen"></i></a>';
echo '        <a href="#" class="btn btn-danger delete-catat" data-id="' . $d['id_catat'] . '"><i class="fa fa-trash"></i></a>';
echo '      </div>';
echo '    </div>';
echo '  </div>';
echo '</div>';


        }
       
        
?>
