<?php 
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_keuangan'])) {
        echo "Tidak Boleh Kosong";
    } else if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['nilai_transaksi'])) {
        echo "Transaksi tidak boleh kosong.";
    } else if (empty($_POST['tanggal_waktu_edit'])) {
        echo "Tanggal tidak boleh kosong.";
    } else if (empty($_POST['total_edit'])) {
        echo "Total tidak boleh kosong.";
    } else if (empty($_POST['nilai_kategori'])) {
        echo "Kategori tidak boleh kosong.";
    } else if (empty($_POST['aset_edit'])) {
        echo "Aset tidak boleh kosong.";
    } else if (empty($_POST['catatan_edit'])) {
        echo "Catatan tidak boleh kosong.";
    } else {
        $id_keuangan = mysqli_real_escape_string($koneksi, $_POST['id_keuangan']);
        $nilai_transaksi = mysqli_real_escape_string($koneksi, $_POST['nilai_transaksi']);
        $nilai_kategori = mysqli_real_escape_string($koneksi, $_POST['nilai_kategori']);
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $tanggal_waktu = mysqli_real_escape_string($koneksi, $_POST['tanggal_waktu_edit']);
        $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_edit']);
        $aset = mysqli_real_escape_string($koneksi, $_POST['aset_edit']);
        $total = mysqli_real_escape_string($koneksi, $_POST['total_edit']);
        $deskripsi = "";

        // Periksa apakah pengguna memilih untuk mengganti deskripsi menjadi gambar
        if (!empty($_FILES['fileInput_ubah']['name'])) {
            $gambarDir = "../../data/img/transaksi/";
            $gambar = $_FILES['fileInput_ubah']['name'];
            $gambarTmp = $_FILES['fileInput_ubah']['tmp_name'];
            $gambarName = time() . '_' . $gambar;

            move_uploaded_file($gambarTmp, $gambarDir . $gambarName);

            // Setel deskripsi ke nama file yang diunggah
            $deskripsi = $gambarName;
        } else if (!empty($_POST['deskripsi_ubah'])) {
            // Jika pengguna memasukkan deskripsi, gunakan deskripsi tersebut
            $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi_ubah']);
        }
if (empty($_POST['deskripsi_ubah']) && empty($_FILES['fileInput_ubah']['name'])) {
    echo "Harap pilih satu, deskripsi atau gambar.";
} else {
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
            deskripsi = '$deskripsi',
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

mysqli_close($koneksi);

?>