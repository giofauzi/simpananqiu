<?php
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if(empty($_POST['id_keuangan'])) {
        echo "Tidak Boleh Kosong";
    } else if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['transaksi_keuangan'])) {
        echo "Transaksi tidak boleh kosong.";
    } else if (empty($_POST['tanggal_waktu_edit'])) {
        echo "Tanggal tidak boleh kosong.";
    } else if (empty($_POST['total_edit'])) {
        echo "Total tidak boleh kosong.";
    } else if (empty($_POST['kategori_edit'])) {
        echo " Kategori tidak boleh kosong.";
    } else if (empty($_POST['aset_edit'])) {
        echo " Aset tidak boleh kosong.";
    } else if (empty($_POST['catatan_edit'])) {
        echo " Catatan tidak boleh kosong.";
    }  else if(empty($_POST['nilai_transaksi'])) {
        echo "Transaksi Tidak Boleh Kosong";
    }  else if(empty($_POST['nilai_kategori'])) {
        echo "Kategori Tidak Boleh Kosong";;
    }
    else {
        // Validasi tipe file yang diizinkan
        $allowedExtensions = ['png', 'jpeg', 'jpg'];
        $fileExtension = strtolower(pathinfo($_FILES['fileInput_ubah']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Hanya gambar yang diizinkan.";
        } else {
            $id_keuangan = mysqli_real_escape_string($koneksi, $_POST['id_keuangan']);
            $nilai_transaksi = mysqli_real_escape_string($koneksi, $_POST['nilai_transaksi']);
            $nilai_kategori = mysqli_real_escape_string($koneksi, $_POST['nilai_kategori']);
            $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
            $transaksi_keuangan = mysqli_real_escape_string($koneksi, $_POST['transaksi_keuangan']);
            $tanggal_waktu = mysqli_real_escape_string($koneksi, $_POST['tanggal_waktu_edit']);
            $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_edit']);
            $aset = mysqli_real_escape_string($koneksi, $_POST['aset_edit']);
            $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori_edit']);
            $total = mysqli_real_escape_string($koneksi, $_POST['total_edit']);
            $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi_ubah']);

            // Gantilah query ini dengan yang sesuai untuk mengambil data pengguna yang sesuai.
            $sql_select_user = "SELECT * FROM users WHERE id_user = $id_user";
            $result = $koneksi->query($sql_select_user);

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();

                // Sekarang Anda memiliki data pengguna yang ingin diubah dalam $user_data
                // Anda bisa mengakses kolom password dan foto dari $user_data saat memeriksa password dan foto.

                // Periksa apakah ada file gambar baru yang diunggah
                if (!empty($_FILES['fileInput_ubah']['name'])) {
                    $gambarDir = "../../data/img/transaksi/";
                    $gambar = $_FILES['fileInput_ubah']['name'];
                    $gambarTmp = $_FILES['fileInput_ubah']['tmp_name'];
                    $gambarName = time() . '_' . $gambar;

                    // Hapus gambar lama jika ada
                    if (!empty($user_data['foto'])) {
                        $oldImage = $gambarDir . $user_data['foto'];
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }

                    move_uploaded_file($gambarTmp, $gambarDir . $gambarName);
                } else {
                    $gambarName = $user_data['foto'];
                }
            }

            // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah keuangan dengan id_user dan nama_keuangan tertentu
            $keuanganCountQuery = "SELECT COUNT(*) as count FROM keuangan WHERE id_user = '$id_user' AND nama_keuangan = '$transaksi_keuangan' AND tgl_b != '0000-00-00 00:00:00'";
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
                       $query = "UPDATE keuangan SET
    id_kategori = '$nilai_kategori',
    id_aset = '$aset',
    nama_keuangan = '$nilai_transaksi',
    total = '$total',
    catatan = '$catatan',
    deskripsi = '$deskripsi',
    tgl_b = '$tanggal_waktu'
WHERE id_keuangan = $id_keuangan";


                        if (mysqli_query($koneksi, $query)) {
                            echo "Data keuangan berhasil ditambahkan.";
                        } else {
                            echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                        }
                    } else {
                        // Lanjutkan dengan query untuk menambahkan data, tetapi gunakan $gambarName untuk deskripsi
                        date_default_timezone_set('Asia/Jakarta');
                        $currentDateTime = date('Y-m-d H:i:s');
                        $query = "UPDATE keuangan SET
    id_kategori = '$nilai_kategori',
    id_aset = '$aset',
    nama_keuangan = '$nilai_transaksi',
    total = '$total',
    catatan = '$catatan',
    deskripsi = '$gambarName',
    tgl_b = '$currentDateTime'
WHERE id_keuangan = $id_keuangan";


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
                    $query = "UPDATE keuangan SET
    id_kategori = '$nilai_kategori',
    id_aset = '$aset',
    nama_keuangan = '$nilai_transaksi',
    total = '$total',
    catatan = '$catatan',
    deskripsi = '$deskripsi',
    tgl_b = '$currentDateTime'
WHERE id_keuangan = $id_keuangan";

                    if (mysqli_query($koneksi, $query)) {
                        echo "Data keuangan berhasil ditambahkan.";
                    } else {
                        echo "Terjadi kesalahan saat menambahkan data keuangan: " . mysqli_error($koneksi);
                    }
                } else {
                    // Lanjutkan dengan query untuk menambahkan data, tetapi gunakan $gambarName untuk deskripsi
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE keuangan SET
    id_kategori = '$nilai_kategori',
    id_aset = '$aset',
    nama_keuangan = '$nilai_transaksi',
    total = '$total',
    catatan = '$catatan',
    deskripsi = '$gambarName',
    tgl_b = '$currentDateTime'
WHERE id_keuangan = $id_keuangan";

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
    // Permintaan bukan dari metode POST
    echo "Permintaan tidak valid.";
}

mysqli_close($koneksi);
?>
