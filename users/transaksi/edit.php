<?php
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ubah'])) {
    // Validasi data yang diterima
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $id_keuangan = mysqli_real_escape_string($koneksi, $_POST['id_keuangan']);
        $nilai_transaksi = mysqli_real_escape_string($koneksi, $_POST['nilai_transaksi']);
        $nilai_kategori = mysqli_real_escape_string($koneksi, $_POST['nilai_kategori']);
        $tanggal_waktu = mysqli_real_escape_string($koneksi, $_POST['tanggal_waktu_edit']);
        $total = mysqli_real_escape_string($koneksi, $_POST['total_edit']);
        $aset = mysqli_real_escape_string($koneksi, $_POST['aset_edit']);
        $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_edit']);
        $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi_ubah']);

                $gambarDir = "../../data/img/transaksi/";
                $gambar = $_FILES['fileInput_ubah']['name'];
                $gambarTmp = $_FILES['fileInput_ubah']['tmp_name'];
                $gambarName = time() . '_' . $gambar;

            // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah keuangan dengan id_user dan nama_keuangan tertentu
            $keuanganCountQuery = "SELECT COUNT(*) as count FROM keuangan WHERE id_user = '$id_user' AND nama_keuangan = '$nilai_transaksi' AND tgl_b != '0000-00-00 00:00:00'";
            $keuanganCountResult = mysqli_query($koneksi, $keuanganCountQuery);
            $countRow = mysqli_fetch_assoc($keuanganCountResult);
            $keuanganCount = $countRow['count'];

            if ($userStatus == '0') {
                // Jika status pengguna adalah 0 dan jumlah keuangan mencapai batasan, tampilkan pesan harus menjadi premium
                if ($keuanganCount >= 5) {
                    echo "Anda harus upgrade akun ke premium";
                } else {
                    $gambarPath = "../../data/img/transaksi/" . $gambarName; // Path gambar sesuai dengan data dalam database
                    if (file_exists($gambarPath)) {
                        // Lanjutkan dengan query untuk mengubah data

                        date_default_timezone_set('Asia/Jakarta');
                        $currentDateTime = date('Y-m-d H:i:s');
                        $query = "UPDATE keuangan SET
                            id_user = '$id_user',
                            id_kategori = '$nilai_kategori',
                            id_aset = '$aset',
                            nama_keuangan = '$nilai_transaksi',
                            total = '$total',
                            catatan = '$catatan',
                            deskripsi = '$gambarName',  -- Gunakan $gambarName di sini
                            tgl_e = '$currentDateTime'
                        WHERE id_keuangan = $id_keuangan";

                        if (mysqli_query($koneksi, $query)) {
                            echo "Data keuangan berhasil diubah.";
                        } else {
                            echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
                        }
                    }
                }
            } else {
                $gambarPath = "../../data/img/transaksi/" . $gambarName; // Path gambar sesuai dengan data dalam database
                if (file_exists($gambarPath)) {
                    // Lanjutkan dengan query untuk mengubah data

                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE keuangan SET
                        id_user = '$id_user',
                        id_kategori = '$nilai_kategori',
                        id_aset = '$aset',
                        nama_keuangan = '$nilai_transaksi',
                        total = '$total',
                        catatan = '$catatan',
                        deskripsi = '$gambarName',  -- Gunakan $gambarName di sini
                        tgl_e = '$currentDateTime'
                    WHERE id_keuangan = $id_keuangan";

                    if (mysqli_query($koneksi, $query)) {
                        echo "Data keuangan berhasil diubah.";
                    } else {
                        echo "Terjadi kesalahan saat mengubah data keuangan: " . mysqli_error($koneksi);
                    }
                }
            }
        
    
} else {
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}

?>
