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
            $CatatCountQuery = "SELECT COUNT(*) as count FROM catat_tabungan WHERE id_tabungan = '$id_tabungan' AND tgl_b != '0000-00-00 00:00:00'";
            $CatatCountResult = mysqli_query($koneksi, $CatatCountQuery);
            $countRow = mysqli_fetch_assoc($CatatCountResult);
            $CatatCount = $countRow['count'];

            if ($userStatus == 1) {
                // Jika status pengguna adalah 0 dan jumlah kategori mencapai batasan, tampilkan pesan harus menjadi premium
            
                        if(!empty($keterangan)) {
                            date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                     $query = "UPDATE catat_tabungan SET id_tabungan = '$id_tabungan', nominal = '+$nominal', keterangan = '$keterangan', tgl_e = '$currentDateTime' WHERE id_catat = '$id_catat'";
                      if (mysqli_query($koneksi, $query)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo "Data keuangan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
        }
                        } else {

                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                     $query = "UPDATE catat_tabungan SET id_tabungan = '$id_tabungan', nominal = '+$nominal', keterangan = NULL, tgl_e = '$currentDateTime' WHERE id_catat = '$id_catat'";
                      if (mysqli_query($koneksi, $query)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo "Data keuangan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
        }

                    }
                    
            } else {
                 if(!empty($keterangan)) {
                            date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE catat_tabungan SET id_tabungan = '$id_tabungan', nominal = '+$nominal', keterangan = '$keterangan', tgl_e = '$currentDateTime' WHERE id_catat = '$id_catat'";
                      if (mysqli_query($koneksi, $query)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo "Data keuangan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
        }
                        } else {

                        date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                       $query = "UPDATE catat_tabungan SET id_tabungan = '$id_tabungan', nominal = '+$nominal', keterangan = NULL, tgl_e = '$currentDateTime' WHERE id_catat = '$id_catat'";
                      if (mysqli_query($koneksi, $query)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                         echo "Data keuangan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
        }

                    }
            }
        
    }
} else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}
?>
