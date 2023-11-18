<?php
include "../../koneksi.php";
$id_tabungan = $_GET['id_tabungan']; // Terima parameter dari permintaan AJAX

$query = "SELECT * FROM catat_tabungan WHERE id_tabungan = $id_tabungan ORDER BY id_catat DESC";
$result = mysqli_query($koneksi, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Ubah nilai tgl_b menjadi tanggal saat ini menggunakan date()
    $row['tgl_b'] = date('d F Y H.i', strtotime($row['tgl_b'])); // Sesuaikan format tanggal yang Anda inginkan

    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['getData' => $data]);

mysqli_close($koneksi);
?>
