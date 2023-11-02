<?php
// Sesuaikan dengan koneksi database Anda
include "../../koneksi.php";

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['grup'])) {
        echo "Grup tidak boleh kosong.";
    } else if (empty($_POST['nama_aset'])) {
        echo "Nama Aset tidak boleh kosong.";
    } else if (empty($_POST['total_aset'])) {
        echo "Total tidak boleh kosong.";
    } else if (empty($_POST['deskripsi_aset'])) {
        echo "Deskripsi tidak boleh kosong.";
    } else {
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $grup = mysqli_real_escape_string($koneksi, $_POST['grup']);
        $nama_aset = mysqli_real_escape_string($koneksi, $_POST['nama_aset']);
        $total_aset = mysqli_real_escape_string($koneksi, $_POST['total_aset']);
        $deskripsi_aset = mysqli_real_escape_string($koneksi, $_POST['deskripsi_aset']);


         // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
        $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
        $statusResult = mysqli_query($koneksi, $statusQuery);
        $statusRow = mysqli_fetch_assoc($statusResult);
        $userStatus = $statusRow['status'];


         // Query untuk menghitung jumlah aset dengan id_user dan grup tertentu
        $checkQuery = "SELECT COUNT(*) as count FROM aset WHERE id_user = '$id_user' AND grup = '$grup'";
        $asetCountResult = mysqli_query($koneksi, $checkQuery);
        $countRow = mysqli_fetch_assoc($asetCountResult);
        $asetCount = $countRow['count'];


         if ($userStatus == '0') {
    // Jika status pengguna adalah 0 dan jumlah aset mencapai batasan, tampilkan pesan harus menjadi premium
    if ($asetCount >= 5) {
        echo "Anda harus upgrade akun ke premium";
    } else {
        // Query untuk memeriksa apakah nama aset sudah ada dalam database dengan grup yang sesuai
        $checkQuery = "SELECT COUNT(*) as count FROM aset WHERE nama_aset = '$nama_aset' AND grup = '$grup'";
        $checkResult = mysqli_query($koneksi, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $asetCount = $row['count'];
        
        if ($asetCount > 0) {
            echo "Aset Sudah Ada!";
        } else {
            // Lanjutkan dengan query untuk menambahkan data
            date_default_timezone_set('Asia/Jakarta');
            $currentDateTime = date('Y-m-d H:i:s');
            $query = "INSERT INTO aset (id_user, grup, nama_aset, total, deskripsi, tgl_b) VALUES ('$id_user', '$grup', '$nama_aset', '$total_aset', '$deskripsi_aset', '$currentDateTime')";

            if (mysqli_query($koneksi, $query)) {
                echo "Aset berhasil ditambahkan.";
            } else {
                echo "Terjadi kesalahan saat menambahkan aset: " . mysqli_error($koneksi);
            }
        }
    }
} else {
      // Query untuk memeriksa apakah nama aset sudah ada dalam database dengan grup yang sesuai
        $checkQuery = "SELECT COUNT(*) as count FROM aset WHERE nama_aset = '$nama_aset' AND grup = '$grup'";
        $checkResult = mysqli_query($koneksi, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $asetCount = $row['count'];
        
        if ($asetCount > 0) {
            echo "Aset Sudah Ada!";
        } else {
        // Jika status pengguna bukan 0, lanjutkan tanpa memeriksa batasan kategori
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO aset (id_user, grup, nama_aset, total, deskripsi, tgl_b) VALUES ('$id_user', '$grup', '$nama_aset', '$total_aset', '$deskripsi_aset', '$currentDateTime')";

        if (mysqli_query($koneksi, $query)) {
            echo "Aset berhasil ditambahkan.";
        } else {
            echo "Terjadi kesalahan saat menambahkan aset: " . mysqli_error($koneksi);
        }
    }
}
    }

} else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}
// Tutup koneksi database
mysqli_close($koneksi);
?>
