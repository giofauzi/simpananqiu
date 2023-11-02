<?php
include "../../koneksi.php";
$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX

$query = "SELECT k.*, u.foto, u.nama_user
          FROM kategori k
          JOIN users u ON k.id_user = u.id_user
          WHERE k.id_user = $id_users
          AND DATE(k.tgl_b) = CURDATE()";

$result = mysqli_query($koneksi, $query);

$ActivityData = ''; // Inisialisasi variabel ActivityData

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ActivityData .= "
                <div class='post'>
                    <div class='user-block'>
                        <img class='img-circle img-bordered-sm' src='../../data/img/users/{$row['foto']}' alt='user image'>
                        <span class='username'>
                            <a href='#'>{$row['nama_user']}</a>
                        </span>
                        <span class='description'>Kategori - " . date('d F Y H.i', strtotime($row['tgl_b'])) . ' WIB' . "</span>
                    </div>
                    <p>Tambah Data Kategori {$row['transaksi']}</p>
                    <p class='text-bold'>{$row['nama_kategori']}</p>
                </div>
            ";
        }
    } else {
        $ActivityData = "Tidak ada data yang sesuai dengan kriteria.";
    }
} else {
    $ActivityData = "Terjadi kesalahan dalam mengambil data.";
}

header('Content-Type: application/json');
echo json_encode(['ActivityData' => $ActivityData]);
mysqli_close($koneksi);
?>
