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
    } else if (empty($_POST['id'])) {
        echo "Tidak boleh kosong.";
    } else {
        $id_tabungan = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $nama_tabungan = mysqli_real_escape_string($koneksi, $_POST['nama_tabungan']);
        $target_tabungan = mysqli_real_escape_string($koneksi, $_POST['target_tabungan']);
        $rencana_pengisian = mysqli_real_escape_string($koneksi, $_POST['rencana_pengisian']);
        $nominal_pengisian = mysqli_real_escape_string($koneksi, $_POST['nominal_pengisian']);

        // Inisialisasi variabel fileInput
        $fileInput = NULL;

        // Check if the user has selected both description and image
        if (!empty($_FILES['fileInput']['name'])) {
            // Both description and image selected, handle as desired
            $fileInputDir = "../../data/img/tabungan/";
            $fileInput = $_FILES['fileInput']['name'];
            $fileInputTmp = $_FILES['fileInput']['tmp_name'];
            $fileInputName = time() . '_' . $fileInput;

            move_uploaded_file($fileInputTmp, $fileInputDir . $fileInputName);

            // Setel fileInput ke nama file yang diunggah
            $fileInput = $fileInputName;
        }

        // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
        $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
        $statusResult = mysqli_query($koneksi, $statusQuery);
        $statusRow = mysqli_fetch_assoc($statusResult);
        $userStatus = $statusRow['status'];

        // Tambahkan variabel untuk menyimpan nama_tabungan sebelumnya
        
        $nama_tabungan_lama = '';

        // Cek apakah nama_tabungan tidak kosong dan berbeda dengan nama_tabungan_lama
        if (!empty($nama_tabungan) && $nama_tabungan != $nama_tabungan_lama) {
            // Query untuk memeriksa apakah nama_tabungan sudah ada dalam database dengan transaksi yang sesuai
            $checkQuery = "SELECT COUNT(*) as count FROM tabungan WHERE id_user = '$id_user' AND nama_tabungan = '$nama_tabungan'";
            $checkResult = mysqli_query($koneksi, $checkQuery);
            $row = mysqli_fetch_assoc($checkResult);
            $tabunganCount = $row['count'];

            if ($tabunganCount > 0) {
                echo "Tabungan Sudah Ada!";
            } else {
                // Update nama_tabungan_lama dengan nilai baru
                $nama_tabungan_lama = $nama_tabungan;
            }
        } else {
            // Jika nama_tabungan kosong atau sama dengan nama_tabungan_lama, lanjutkan tanpa memeriksa keberadaan dalam database
            $nama_tabungan_lama = $nama_tabungan;
        }

        if ($userStatus == 1) {
            // Jika status pengguna adalah 0 dan jumlah tabungan mencapai batasan, tampilkan pesan harus menjadi premium
            if ($tabunganCount >= 5) {
                echo "Anda harus upgrade akun ke premium";
            } else {
                // Query untuk melanjutkan dengan pembaruan data
                if($nominal_pengisian > $target_tabungan) {
            echo 'Nominal pengisian tidak boleh melebihi target pengisian';
        } else {
            // Lanjutkan dengan query untuk menambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
        $query = "UPDATE tabungan SET 
            nama_tabungan = '$nama_tabungan', 
            target = '$target_tabungan', 
            rencana = '$rencana_pengisian', 
            nominal = '$nominal_pengisian', 
            tgl_b = '$currentDateTime'";

        // Hanya tambahkan kolom gambar jika ada gambar yang diunggah
        if (!empty($fileInput)) {
            // Hapus gambar lama jika ada
            $queryCekGambar = "SELECT gambar FROM tabungan WHERE id_tabungan = $id_tabungan";
            $resultCekGambar = mysqli_query($koneksi, $queryCekGambar);

            if ($resultCekGambar && mysqli_num_rows($resultCekGambar) > 0) {
                $rowCekGambar = mysqli_fetch_assoc($resultCekGambar);
                $gambarLama = $rowCekGambar['gambar'];

                if (!empty($gambarLama) && file_exists("../../data/img/tabungan/$gambarLama")) {
                    unlink("../../data/img/tabungan/$gambarLama");
                }
            }

            // Setel gambar ke nama file yang diunggah
            $query .= ", gambar = '$fileInput'";
        }

        $query .= " WHERE id_tabungan = '$id_tabungan'";


                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil ditambah.";
                } else {
                    echo "Terjadi kesalahan saat menambah data tabungan: " . mysqli_error($koneksi);
                }
        }
            }
        } else {
            // Query untuk melanjutkan dengan pembaruan data
           if($nominal_pengisian > $target_tabungan) {
            echo 'Nominal pengisian tidak boleh melebihi target pengisian';
        } else {
            // Lanjutkan dengan query untuk menambah data
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                
                // Gabungkan query untuk menghindari duplikasi
        $query = "UPDATE tabungan SET 
            nama_tabungan = '$nama_tabungan', 
            target = '$target_tabungan', 
            rencana = '$rencana_pengisian', 
            nominal = '$nominal_pengisian', 
            tgl_b = '$currentDateTime'";

        // Hanya tambahkan kolom gambar jika ada gambar yang diunggah
        if (!empty($fileInput)) {
            // Hapus gambar lama jika ada
            $queryCekGambar = "SELECT gambar FROM tabungan WHERE id_tabungan = $id_tabungan";
            $resultCekGambar = mysqli_query($koneksi, $queryCekGambar);

            if ($resultCekGambar && mysqli_num_rows($resultCekGambar) > 0) {
                $rowCekGambar = mysqli_fetch_assoc($resultCekGambar);
                $gambarLama = $rowCekGambar['gambar'];

                if (!empty($gambarLama) && file_exists("../../data/img/tabungan/$gambarLama")) {
                    unlink("../../data/img/tabungan/$gambarLama");
                }
            }

            // Setel gambar ke nama file yang diunggah
            $query .= ", gambar = '$fileInput'";
        }

        $query .= " WHERE id_tabungan = '$id_tabungan'";


                if (mysqli_query($koneksi, $query)) {
                    echo "Data tabungan berhasil ditambah.";
                } else {
                    echo "Terjadi kesalahan saat menambah data tabungan: " . mysqli_error($koneksi);
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
