<?php 
include '../../koneksi.php'; 

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_user_p'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['nama_keuangan_p'])) {
        echo "Nama Keuangan tidak boleh kosong.";
    } else if (empty($_POST['tanggal_waktu_p'])) {
        echo "Tanggal tidak boleh kosong.";
    } else if (empty($_POST['total_p'])) {
        echo "Total tidak boleh kosong.";
    } else if (empty($_POST['kategori_p'])) {
        echo "Kategori tidak boleh kosong.";
    } else if (empty($_POST['aset_p'])) {
        echo "Aset tidak boleh kosong.";
    } else if (empty($_POST['catatan_p'])) {
        echo "Catatan tidak boleh kosong.";
    } else {
       
                // File diunggah, lanjutkan dengan pemrosesan file
                $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user_p']);
                $nama_keuangan = mysqli_real_escape_string($koneksi, $_POST['nama_keuangan_p']);
                $tanggal_waktu = mysqli_real_escape_string($koneksi, $_POST['tanggal_waktu_p']);
                $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_p']);
                $aset = mysqli_real_escape_string($koneksi, $_POST['aset_p']);
                $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori_p']);
                $total = mysqli_real_escape_string($koneksi, $_POST['total_p']);
                $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi_p']);
    
                 // Selanjutnya, cek apakah pengguna memasukkan deskripsi atau mengunggah gambar.
    if (empty($_POST['deskripsi_p']) && empty($_FILES['fileInput_p']['name'])) {
        // Jika keduanya kosong, berikan pesan kesalahan.
        echo "Harap masukkan deskripsi atau unggah gambar.";
    } else {
        // Validasi tipe file jika ada file yang diunggah
        if (!empty($_FILES['fileInput_p']['name'])) {
            $allowedExtensions = ['png', 'jpeg', 'jpg'];
            $fileExtension = strtolower(pathinfo($_FILES['fileInput_p']['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                // Jika tipe file tidak sesuai, berikan pesan kesalahan.
                echo "Hanya gambar yang diizinkan.";
            } else {
                // Simpan gambar yang diunggah
                $gambarDir = "../../data/img/transaksi/";
                $gambarName = time() . '_' . $_FILES['fileInput_p']['name'];
                $gambarPath = $gambarDir . $gambarName;

                // Pindahkan file yang diunggah ke direktori yang ditentukan
                move_uploaded_file($_FILES['fileInput_p']['tmp_name'], $gambarPath);
            }
        }

        // Tentukan nilai untuk $deskripsi
        $deskripsi = !empty($_POST['deskripsi_p']) ? mysqli_real_escape_string($koneksi, $_POST['deskripsi_p']) : $gambarName;
  // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah keuangan dengan id_user dan transaksi tertentu
            $keuanganCountQuery = "SELECT COUNT(*) as count FROM keuangan WHERE id_user = '$id_user' AND nama_keuangan = '$nama_keuangan' AND tgl_b != '0000-00-00 00:00:00'";
            $keuanganCountResult = mysqli_query($koneksi, $keuanganCountQuery);
            $countRow = mysqli_fetch_assoc($keuanganCountResult);
            $keuanganCount = $countRow['count'];

            if ($userStatus == '0') {
                // Jika status pengguna adalah 0 dan jumlah keuangan mencapai batasan, tampilkan pesan harus menjadi premium
                if ($keuanganCount >= 5) {
                    echo "Anda harus upgrade akun ke premium";
                } else {
                    if (!empty($deskripsi)) {
                        // Lanjutkan dengan query untuk menambahkan data
                        date_default_timezone_set('Asia/Jakarta');
                        $currentDateTime = date('Y-m-d H:i:s');
                        $query = "INSERT INTO keuangan (id_user, id_kategori, id_aset, nama_keuangan, total, catatan, deskripsi, tgl_b) VALUES ('$id_user', '$kategori',  '$aset', '$nama_keuangan', '$total', '$catatan', '$deskripsi', '$currentDateTime')";

                        if (mysqli_query($koneksi, $query)) {
                            echo "Data keuangan berhasil ditambahkan.";
                        } else {
                            echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                        }
                    } else {
                        // Lanjutkan dengan query untuk menambahkan data, tetapi gunakan $gambarName untuk deskripsi
                        date_default_timezone_set('Asia/Jakarta');
                        $currentDateTime = date('Y-m-d H:i:s');
                        $query = "INSERT INTO keuangan (id_user, id_kategori, id_aset, nama_keuangan, total, catatan, deskripsi, tgl_b) VALUES ('$id_user', '$kategori',  '$aset', '$nama_keuangan', '$total', '$catatan', '$gambarName', '$currentDateTime')";

                        if (mysqli_query($koneksi, $query)) {
                            echo "Data keuangan berhasil ditambahkan.";
                        } else {
                            echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                        }
                    }
                }
            } else {
                if (!empty($deskripsi)) {
                    // Lanjutkan dengan query untuk menambahkan data
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "INSERT INTO keuangan (id_user, id_kategori, id_aset, nama_keuangan, total, catatan, deskripsi, tgl_b) VALUES ('$id_user', '$kategori',  '$aset', '$nama_keuangan', '$total', '$catatan', '$deskripsi', '$currentDateTime')";

                    if (mysqli_query($koneksi, $query)) {
                        echo "Data keuangan berhasil ditambahkan.";
                    } else {
                        echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                    }
                } else {
                    // Lanjutkan dengan query untuk menambahkan data, tetapi gunakan $gambarName untuk deskripsi
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "INSERT INTO keuangan (id_user, id_kategori, id_aset, nama_keuangan, total, catatan, deskripsi, tgl_b) VALUES ('$id_user', '$kategori',  '$aset', '$nama_keuangan', '$total', '$catatan', '$gambarName', '$currentDateTime')";

                    if (mysqli_query($koneksi, $query)) {
                        echo "Data keuangan berhasil ditambahkan.";
                    } else {
                        echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                    }
                }
            }
    }
}
} else {
    echo "Permintaan tidak valid.";
}
?>
