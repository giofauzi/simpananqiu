<?php
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_user'])) {
        echo "Tidak boleh kosong.";
    } else if (empty($_POST['tipe'])) {
        echo "Tipe tidak boleh kosong.";
    } else if (empty($_POST['nominal'])) {
        echo "Nominal tidak boleh kosong.";
    }  else {
        $id_tabungan = mysqli_real_escape_string($koneksi, $_POST['id_tabungan']);
        $estimasi = mysqli_real_escape_string($koneksi, $_POST['estimasi']);
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $tipe = mysqli_real_escape_string($koneksi, $_POST['tipe']);
        $nominal = mysqli_real_escape_string($koneksi, $_POST['nominal']);
        $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
        
        // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
        $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
        $statusResult = mysqli_query($koneksi, $statusQuery);
        $statusRow = mysqli_fetch_assoc($statusResult);
        $userStatus = $statusRow['status'];

        // Query untuk menghitung jumlah catat tabungan dengan id_user  tertentu
        $tabunganCountQuery = "SELECT COUNT(*) as count FROM catat_tabungan WHERE id_tabungan = '$id_tabungan' AND tgl_b != '0000-00-00 00:00:00'";
        $tabunganCountResult = mysqli_query($koneksi, $tabunganCountQuery);
        $countRow = mysqli_fetch_assoc($tabunganCountResult);
        $tabunganCount = $countRow['count'];

        if ($userStatus == '1') {
            // Jika status pengguna adalah 0 dan jumlah tabungan mencapai batasan, tampilkan pesan harus menjadi premium
            if ($tabunganCount >= $estimasi ) {
                echo "Anda harus upgrade akun ke premium";
            } else {
                 
    
    if ($tipe === 'tambah') {
        if (!empty($keterangan)) {
        // Lanjutkan dengan query untuk tambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '+$nominal', '$keterangan','$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            } else {
                 date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '+$nominal', NULL,'$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            }
    } else if($tipe === 'kurangi') {
                if (!empty($keterangan)) {
        // Lanjutkan dengan query untuk tambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '-$nominal', '$keterangan','$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            } else {
                 date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '-$nominal', NULL,'$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            }
            }
        }
        } else {
            if ($tipe === 'tambah') {
        if (!empty($keterangan)) {
        // Lanjutkan dengan query untuk tambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '+$nominal', '$keterangan','$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            } else {
                 date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '+$nominal', NULL,'$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            }
    } else if($tipe === 'kurangi') {
                if (!empty($keterangan)) {
        // Lanjutkan dengan query untuk tambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '-$nominal', '$keterangan','$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
                }
            } else {
                 date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
                $query = "INSERT INTO catat_tabungan (id_tabungan, nominal, keterangan, tgl_b) VALUES ('$id_tabungan', '-$nominal', NULL,'$currentDateTime')";

                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil diubah.";
                } else {
                    echo "Terjadi kesalahan saat mengubah data tabungan: " . mysqli_error($koneksi);
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
