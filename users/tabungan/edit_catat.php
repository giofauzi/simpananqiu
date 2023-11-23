<?php 
include "../../koneksi.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inisialisasi variabel untuk pesan kesalahan
    $errors = [];

    // Periksa apakah semua data yang diperlukan ada
    
    if (empty($_POST['id'])) {
        $errors[] = " ID Tidak boleh kosong.";
    }
    if (empty($_POST['nomor_nominal'])) {
        $errors[] = "Nominal tidak boleh kosong.";
    }
    if (empty($_POST['id_tabungan'])) {
        $errors[] = "Id Tabungan Tidak boleh kosong.";

    }
        // Cek apakah ada pesan kesalahan
    if (!empty($errors)) {
        // Jika ada pesan kesalahan, kirim pesan kesalahan ke klien
        echo json_encode(['status' => 'error', 'message' => $errors]);
    
    } else {
        // Dapatkan data yang dikirimkan dari AJAX
        $id_catat = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_users = mysqli_real_escape_string($koneksi, $_POST['nomor_user']);
$id_tabungan = mysqli_real_escape_string($koneksi, $_POST['id_tabungan']);
$nominal = mysqli_real_escape_string($koneksi, $_POST['nomor_nominal']);
$keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan_catat']);

        

            // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$id_users'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah kategori dengan id_tabungan tertentu
            $CatatCountQuery = "SELECT COUNT(*) as count FROM catat_tabungan WHERE id_tabungan = '$id_tabungan' AND tgl_e != '0000-00-00 00:00:00'";
            $CatatCountResult = mysqli_query($koneksi, $CatatCountQuery);
            $countRow = mysqli_fetch_assoc($CatatCountResult);
            $CatatCount = $countRow['count'];

            // Query untuk mendapatkan target dari tabel tabungan
        $targetQuery = "SELECT target, nominal FROM tabungan WHERE id_tabungan = '$id_tabungan'";
        $targetResult = mysqli_query($koneksi, $targetQuery);
        $targetRow = mysqli_fetch_assoc($targetResult);
        $target_tabungan = $targetRow['target'];
        $nominal_tabungan = $targetRow['nominal'];

      // Hitung total nominal di tabel catat_tabungan tanpa termasuk id_catat yang sedang diubah
$totalNominalQuery = "SELECT SUM(nominal) as total_nominal FROM catat_tabungan WHERE id_tabungan = '$id_tabungan' AND id_catat != '$id_catat'";
$totalNominalResult = mysqli_query($koneksi, $totalNominalQuery);
$totalNominalRow = mysqli_fetch_assoc($totalNominalResult);
$total_nominal = $totalNominalRow['total_nominal'];


// Hitung total nominal baru setelah penambahan
$newTotalNominal = $total_nominal + $nominal;

if ($userStatus == 1) {
    // Pemeriksaan apakah total nominal baru (termasuk data yang akan ditambahkan) melebihi target
    if ($newTotalNominal <= $target_tabungan) {
                // Jika status pengguna adalah 0 dan jumlah kategori mencapai batasan, tampilkan pesan harus menjadi premium
                        if(!empty($keterangan)) {
                            date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query = "UPDATE catat_tabungan SET id_tabungan = ?, nominal = CONCAT('+', ?), keterangan = ?, tgl_e = ? WHERE id_catat = ?";
$stmt = mysqli_prepare($koneksi, $query);

// Ensure $nominal is a positive value
$nominal = abs($nominal);


mysqli_stmt_bind_param($stmt, "isssi", $id_tabungan, $nominal, $keterangan, $currentDateTime, $id_catat);

                     if (mysqli_stmt_execute($stmt)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                         date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query_tabungan_saja = "UPDATE tabungan SET tgl_e = ? WHERE id_tabungan = ?";
$stmt_tabungan = mysqli_prepare($koneksi, $query_tabungan_saja);

// Ensure $nominal is a positive value
$nominal = abs($nominal);


mysqli_stmt_bind_param($stmt_tabungan, "si", $currentDateTime, $id_tabungan);

                        if (mysqli_stmt_execute($stmt_tabungan)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo json_encode(['status' => 'success']);
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                        } else {

                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE catat_tabungan SET id_tabungan = ?, nominal = CONCAT('+', ?), keterangan = ?, tgl_e = ? WHERE id_catat = ?";
$stmt = mysqli_prepare($koneksi, $query);

// Ensure $nominal is a positive value
$nominal = abs($nominal);

// Initialize $keterangan as null
$keterangan = null;

mysqli_stmt_bind_param($stmt, "isssi", $id_tabungan, $nominal, $keterangan, $currentDateTime, $id_catat);

                     if (mysqli_stmt_execute($stmt)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query_tabungan_saja = "UPDATE tabungan SET tgl_e = ? WHERE id_tabungan = ?";
$stmt_tabungan = mysqli_prepare($koneksi, $query_tabungan_saja);

// Ensure $nominal is a positive value
$nominal = abs($nominal);


mysqli_stmt_bind_param($stmt_tabungan, "si", $currentDateTime, $id_tabungan);

                        if (mysqli_stmt_execute($stmt_tabungan)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo json_encode(['status' => 'success']);
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }

                    }
                } else {
                      echo json_encode(['status' => 'MelebihiTarget']);
                }
                    
            } else {
                if ($newTotalNominal <= $target_tabungan) {
                if(!empty($keterangan)) {
                            date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query = "UPDATE catat_tabungan SET id_tabungan = ?, nominal = CONCAT('+', ?), keterangan = ?, tgl_e = ? WHERE id_catat = ?";
$stmt = mysqli_prepare($koneksi, $query);

// Ensure $nominal is a positive value
$nominal = abs($nominal);



mysqli_stmt_bind_param($stmt, "isssi", $id_tabungan, $nominal, $keterangan, $currentDateTime, $id_catat);


                     if (mysqli_stmt_execute($stmt)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query_tabungan_saja = "UPDATE tabungan SET tgl_e = ? WHERE id_tabungan = ?";
$stmt_tabungan = mysqli_prepare($koneksi, $query_tabungan_saja);

// Ensure $nominal is a positive value
$nominal = abs($nominal);


mysqli_stmt_bind_param($stmt_tabungan, "si", $currentDateTime, $id_tabungan);

                        if (mysqli_stmt_execute($stmt_tabungan)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo json_encode(['status' => 'success']);
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                        } else {

                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                   $query = "UPDATE catat_tabungan SET id_tabungan = ?, nominal = CONCAT('+', ?), keterangan = ?, tgl_e = ? WHERE id_catat = ?";
$stmt = mysqli_prepare($koneksi, $query);

// Ensure $nominal is a positive value
$nominal = abs($nominal);

// Initialize $keterangan as null
$keterangan = null;

mysqli_stmt_bind_param($stmt, "isssi", $id_tabungan, $nominal, $keterangan, $currentDateTime, $id_catat);

                     if (mysqli_stmt_execute($stmt)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                  $query_tabungan_saja = "UPDATE tabungan SET tgl_e = ? WHERE id_tabungan = ?";
$stmt_tabungan = mysqli_prepare($koneksi, $query_tabungan_saja);

// Ensure $nominal is a positive value
$nominal = abs($nominal);


mysqli_stmt_bind_param($stmt_tabungan, "si", $currentDateTime, $id_tabungan);

                        if (mysqli_stmt_execute($stmt_tabungan)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo json_encode(['status' => 'success']);
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }

                    }
                     } else {
                     echo json_encode(['status' => 'MelebihiTarget']);
                }

            }
        
    }
} else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}
?>
