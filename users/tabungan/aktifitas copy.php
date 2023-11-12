<?php 
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX

$query = "SELECT t.*, u.foto, u.nama_user, ct.*
          FROM tabungan t
          JOIN users u ON t.id_user = u.id_user
          LEFT JOIN catat_tabungan ct ON t.id_tabungan = ct.id_tabungan
          WHERE t.id_user = $id_users
          AND DATE(t.tgl_b) = CURDATE()";

$hasil = mysqli_query($koneksi, $query);
$d = mysqli_fetch_array($hasil);
$id_tabungan = $d['id_tabungan'];

$ActivityData = '';

do {
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
                <span class='description'>Tabungan - " . date('d F Y H.i', strtotime($d['tgl_b'])) . ' WIB' . "</span>
            </div>
            <p>{$keterangan} Data Tabungan {$d['nama_tabungan']}</p>
            <p class='text-bold' style='color:{$color};'> <i class='fas {$icon} mr-1' style='color:{$color}'></i>Rp " . number_format($nilai, 2, ',', '.') . "</p>
        </div>
    ";
} while ($d = mysqli_fetch_assoc($hasil));

header('Content-Type: application/json');
echo json_encode(['ActivityData' => $ActivityData]);
mysqli_close($koneksi);

?>
