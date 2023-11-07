<?php
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
   if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['nama_tabungan'])) {
        echo "Nama Tabungan tidak boleh kosong.";
    } else if (empty($_POST['target_tabungan'])) {
        echo "Target Tabungan tidak boleh kosong.";
    } else if (empty($_POST['rencana_pengisian'])) {
        echo "Rencana Pengisian tidak boleh kosong.";
    } else if (empty($_POST['nominal_pengisian'])) {
        echo "Nominal Pengisian tidak boleh kosong.";
    } else {
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $nama_tabungan = mysqli_real_escape_string($koneksi, $_POST['nama_tabungan']);
        $target_tabungan = mysqli_real_escape_string($koneksi, $_POST['target_tabungan']);
        $rencana_pengisian = mysqli_real_escape_string($koneksi, $_POST['rencana_pengisian']);
        $nominal_pengisian = mysqli_real_escape_string($koneksi, $_POST['nominal_pengisian']);

        // Check if the user has selected both description and image
        if (!empty($_FILES['gambar']['name'])) {
            // Both description and image selected, handle as desired
            $gambarDir = "../../data/img/tabungan/";
            $gambar = $_FILES['gambar']['name'];
            $gambarTmp = $_FILES['gambar']['tmp_name'];
            $gambarName = time() . '_' . $gambar;

            move_uploaded_file($gambarTmp, $gambarDir . $gambarName);

            // Setel gambar ke nama file yang diunggah
            $gambar = $gambarName;
        }  
         // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah tabungan dengan id_user dan nama_tabungan tertentu
            $tabunganCountQuery = "SELECT COUNT(*) as count FROM tabungan WHERE id_user = '$id_user' AND nama_tabungan = '$nama_tabungan' AND tgl_b != '0000-00-00 00:00:00'";
            $tabunganCountResult = mysqli_query($koneksi, $tabunganCountQuery);
            $countRow = mysqli_fetch_assoc($tabunganCountResult);
            $tabunganCount = $countRow['count'];

            if ($userStatus == '1') {
                // Jika status pengguna adalah 0 dan jumlah tabungan mencapai batasan, tampilkan pesan harus menjadi premium
                if ($tabunganCount >= 5 ) {
                    echo "Anda harus upgrade akun ke premium";
                } else {
                   // Lanjutkan dengan query untuk mengubah data
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO tabungan (id_user, nama_tabungan, target, rencana, nominal, gambar, tgl_b) VALUES ('$id_user', '$nama_tabungan', '$target_tabungan', '$rencana_pengisian', '$nominal_pengisian', '$gambar', '$currentDateTime')";

        if (mysqli_query($koneksi, $query)) {
            echo "Data tabungan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
        }
                }
            } else {
               // Lanjutkan dengan query untuk mengubah data
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO tabungan (id_user, nama_tabungan, target, rencana, nominal, gambar, tgl_b) VALUES ('$id_user', '$nama_tabungan', '$target_tabungan', '$rencana_pengisian', '$nominal_pengisian', '$gambar', '$currentDateTime')";

        if (mysqli_query($koneksi, $query)) {
            echo "Data tabungan berhasil diubah.";
        } else {
            echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
        }
            }
    }
} else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}

mysqli_close($koneksi);
?>
