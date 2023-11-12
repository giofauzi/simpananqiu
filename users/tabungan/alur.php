<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX
$id_tabungan = $_GET['id_tabungan']; // Terima parameter dari permintaan AJAX
$tipe_alur = isset($_GET['tipe_alur']) ? $_GET['tipe_alur'] : 'pilih'; // Terima parameter tipe_alur


switch ($tipe_alur) {
    case "tambah":
$query = "SELECT t.*, u.foto, u.nama_user, ct.*
          FROM tabungan t
          JOIN users u ON t.id_user = u.id_user
          LEFT JOIN catat_tabungan ct ON t.id_tabungan = ct.id_tabungan
          WHERE t.id_tabungan = $id_tabungan AND u.id_user = $id_users
          AND ct.tgl_b";

$result = mysqli_query($koneksi, $query);

$AlurData = ''; // Inisialisasi variabel AlurData

if ($result) {
    $groupedData = array();

    while ($d = mysqli_fetch_assoc($result)) {
        // Pisahkan tanda dan nilai
        $tanda = substr($d['nominal'], 0, 1); // Ambil karakter pertama (tanda)
        $nilai = (int) substr($d['nominal'], 1); // Ambil nilai setelah karakter pertama

        // Tentukan keterangan berdasarkan tanda
        $keterangan = ($tanda === '+') ? 'Tambah' : 'Kurangi';
        $color = ($tanda === '+') ? 'green' : 'red';
        $icon = ($tanda === '+') ? 'fa-arrow-up' : 'fa-arrow-down';

        $tgl_b_formatted = date('d M. Y', strtotime($d['tgl_b']));

        // Group data by date
        $groupedData[$tgl_b_formatted][] = "
        <i class='fas fa-clock bg-gray'></i>
            <div class='timeline-item mb-3'>
                <span class='time'><i class='far fa-clock'></i> " . date('H:i', strtotime($d['tgl_b'])) . "</span>
                <h3 class='timeline-header'><a href='#'>{$d['nama_user']}</a> {$keterangan} Data Tabungan {$d['nama_tabungan']}</h3>
                <div class='timeline-body'>
                    <p class='text-bold' style='color:{$color};'><i class='fas {$icon} mr-1' style='color:{$color}'></i>Rp " . number_format($nilai, 2, ',', '.') . "</p>
                </div>
            </div>
            
        ";
    }

    // Generate HTML for each date
    foreach ($groupedData as $date => $entries) {
        $AlurData .= "
        
            <div class='timeline timeline-inverse'>
                    <div class='time-label'>
                <span class='time bg-danger'>$date</span>
                 </div>
                 
                    <div>
                " . implode('', $entries) . "
            </div>
        ";
    }

    if (empty($groupedData)) {
        $AlurData = "Tidak ada data yang sesuai dengan kriteria.";
    }
} else {
    $AlurData = "Terjadi kesalahan dalam mengambil data: " . mysqli_error($koneksi);
}

break;

case "ubah":

    $query = "SELECT t.*, u.foto, u.nama_user, ct.*
          FROM tabungan t
          JOIN users u ON t.id_user = u.id_user
          LEFT JOIN catat_tabungan ct ON t.id_tabungan = ct.id_tabungan
          WHERE t.id_tabungan = $id_tabungan AND u.id_user = $id_users
          AND ct.tgl_e";

$result = mysqli_query($koneksi, $query);

$AlurData = ''; // Inisialisasi variabel AlurData

if ($result) {
    $groupedData = array();

    while ($d = mysqli_fetch_assoc($result)) {
        // Pisahkan tanda dan nilai
        $tanda = substr($d['nominal'], 0, 1); // Ambil karakter pertama (tanda)
        $nilai = (int) substr($d['nominal'], 1); // Ambil nilai setelah karakter pertama

        // Tentukan keterangan berdasarkan tanda
        $keterangan = ($tanda === '+') ? 'Mengubah' : 'Mengubah';
        $color = ($tanda === '+') ? 'green' : 'red';
        $icon = ($tanda === '+') ? 'fa-arrow-up' : 'fa-arrow-down';

        $tgl_b_formatted = date('d M. Y', strtotime($d['tgl_e']));

        // Group data by date
        $groupedData[$tgl_b_formatted][] = "
        <i class='fas fa-clock bg-gray'></i>
            <div class='timeline-item mb-3'>
                <span class='time'><i class='far fa-clock'></i> " . date('H:i', strtotime($d['tgl_e'])) . "</span>
                <h3 class='timeline-header'><a href='#'>{$d['nama_user']}</a> {$keterangan} Data Tabungan {$d['nama_tabungan']}</h3>
                <div class='timeline-body'>
                    <p class='text-bold' style='color:{$color};'><i class='fas {$icon} mr-1' style='color:{$color}'></i>Rp " . number_format($nilai, 2, ',', '.') . "</p>
                </div>
            </div>
            
        ";
    }

    // Generate HTML for each date
    foreach ($groupedData as $date => $entries) {
        $AlurData .= "
        
            <div class='timeline timeline-inverse'>
                    <div class='time-label'>
                <span class='time bg-danger'>$date</span>
                 </div>
                 
                    <div>
                " . implode('', $entries) . "
            </div>
        ";
    }

    if (empty($groupedData)) {
        $AlurData = "Tidak ada data yang sesuai dengan kriteria.";
    }
} else {
    $AlurData = "Terjadi kesalahan dalam mengambil data: " . mysqli_error($koneksi);
}
    break;

    case "pilih":
         $AlurData = "Silahkan pilih tipe yang ingin ditampilkan.";
         break;

    default:
        // Handle jika grup tidak dikenali
        echo "Grup tidak valid.";

}

header('Content-Type: application/json');
echo json_encode(['AlurData' => $AlurData]);
mysqli_close($koneksi);
?>
