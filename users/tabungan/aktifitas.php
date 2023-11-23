<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX
$id_tabungan = $_GET['id_tabungan']; // Terima parameter dari permintaan AJAX
$tipe_aktifitas = isset($_GET['tipe_aktifitas']) ? $_GET['tipe_aktifitas'] : 'pilih'; // Terima parameter tipe_aktifitas



switch ($tipe_aktifitas) {
    case "tambah":
$query = "SELECT t.*, u.foto, u.nama_user, ct.*
          FROM tabungan t
          JOIN users u ON t.id_user = u.id_user
          LEFT JOIN catat_tabungan ct ON t.id_tabungan = ct.id_tabungan
          WHERE t.id_tabungan = $id_tabungan AND u.id_user = $id_users
          AND DATE(ct.tgl_b) = CURDATE() ORDER BY ct.id_catat DESC";

$result = mysqli_query($koneksi, $query);

$ActivityData = ''; // Inisialisasi variabel ActivityData

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($d = mysqli_fetch_assoc($result)) {
            // Pisahkan tanda dan nilai
    $tanda = substr($d['nominal_backup'], 0, 1); // Ambil karakter pertama (tanda)
    $nilai = (int) substr($d['nominal_backup'], 1); // Ambil nilai setelah karakter pertama

    // Tentukan keterangan berdasarkan tanda
    $keterangan = ($tanda === '+') ? 'Tambah' : 'Kurangi';
    $color = ($tanda === '+') ? 'green' : 'red';
    $icon = ($tanda === '+') ? 'fa-arrow-up' : 'fa-arrow-down';

    $ActivityData .= "
        <div class='post'>
            <div class='user-block'>
                <img class='img-circle img-bordered-sm' src='../../data/img/users/{$d['foto']}' alt='user image'>
                <span class='username'>
                    <a href='#'>{$d['nama_user']}</a>
                </span>
                <span class='description'>Tabungan - " . date('d F Y H.i', strtotime($d['tgl_b'])) . ' WIB' . "</span>
            </div>
            <p>{$keterangan} Data Tabungan {$d['nama_tabungan']}</p>
            <p class='text-bold' style='color:{$color};'> <i class='fas {$icon} mr-1' style='color:{$color}'></i>Rp " . number_format($nilai, 2, ',', '.') . "</p>
        </div>
    ";
        }
    } else {
        $ActivityData = "Tidak ada data yang sesuai dengan kriteria.";
    }
} else {
    $ActivityData = "Terjadi kesalahan dalam mengambil data.";
}
break;

    case "ubah":
         $query = "SELECT t.*, u.foto, u.nama_user, ct.*
          FROM tabungan t
          JOIN users u ON t.id_user = u.id_user
          LEFT JOIN catat_tabungan ct ON t.id_tabungan = ct.id_tabungan
          WHERE t.id_tabungan = $id_tabungan AND u.id_user = $id_users
          AND DATE(ct.tgl_e) = CURDATE()";

$result = mysqli_query($koneksi, $query);

$ActivityData = ''; // Inisialisasi variabel ActivityData

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($d = mysqli_fetch_assoc($result)) {
            // Pisahkan tanda dan nilai
    $tanda = substr($d['nominal'], 0, 1); // Ambil karakter pertama (tanda)
    $nilai = (int) substr($d['nominal'], 1); // Ambil nilai setelah karakter pertama

    // Tentukan keterangan berdasarkan tanda
    $keterangan = ($tanda === '+') ? 'Tambah' : 'Kurangi';
    $color = ($tanda === '+') ? 'green' : 'red';
    $icon = ($tanda === '+') ? 'fa-arrow-up' : 'fa-arrow-down';

    $ActivityData .= "
        <div class='post'>
            <div class='user-block'>
                <img class='img-circle img-bordered-sm' src='../../data/img/users/{$d['foto']}' alt='user image'>
                <span class='username'>
                    <a href='#'>{$d['nama_user']}</a>
                </span>
                <span class='description'>Tabungan - " . date('d F Y H.i', strtotime($d['tgl_e'])) . ' WIB' . "</span>
            </div>
            <p>Ubah Data Tabungan {$d['nama_tabungan']}</p>
            <p> Dari Tambah Data Tangal  " . date('d F Y H.i', strtotime($d['tgl_b'])) . ' WIB' . "
            <p class='text-bold' style='color:{$color};'> <i class='fas {$icon} mr-1' style='color:{$color}'></i>Rp " . number_format($nilai, 2, ',', '.') . "</p>
        </div>
    ";
        }
    } else {
        $ActivityData = "Tidak ada data yang sesuai dengan kriteria.";
    }
} else {
    $ActivityData = "Terjadi kesalahan dalam mengambil data.";
}
         break;

         case "pilih":
         $ActivityData = "Silahkan pilih tipe yang ingin ditampilkan.";
         break;

    default:
        // Handle jika grup tidak dikenali
        echo "Grup tidak valid.";
    }

header('Content-Type: application/json');
echo json_encode(['ActivityData' => $ActivityData]);
mysqli_close($koneksi);
?>
