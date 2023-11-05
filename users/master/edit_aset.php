<?php 
include "../../koneksi.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inisialisasi variabel untuk pesan kesalahan
    $errors = [];

    // Periksa apakah semua data yang diperlukan ada
    if (empty($_POST['id'])) {
        $errors[] = "Id Kategori tidak boleh kosong.";
    }
    if (empty($_POST['nama'])) {
        $errors[] = "Nama Aset tidak boleh kosong.";
    }
    if (empty($_POST['id_users'])) {
        $errors[] = "id Tidak boleh kosong.";
    }
    if (empty($_POST['total_aset'])) {
        $errors[] = "total Tidak boleh kosong.";
    }
    if (empty($_POST['grup_aset'])) {
        $errors[] = " grup Tidak boleh kosong.";
    }
     if (empty($_POST['deskripsi_aset'])) {
        $errors[] = " desTidak boleh kosong.";
    }

    // Cek apakah ada pesan kesalahan
    if (!empty($errors)) {
        // Jika ada pesan kesalahan, kirim pesan kesalahan ke klien
        echo json_encode(['status' => 'error', 'message' => $errors]);
    } else {
        // Dapatkan data yang dikirimkan dari AJAX
        $categoryId = $_POST['id'];
        $editedCategoryName = $_POST['nama'];
        $editIdUser = $_POST['id_users'];
        $grup = $_POST['grup_aset'];
        $total = $_POST['total_aset'];
        $deskripsi = $_POST['deskripsi_aset'];

        // Lakukan proses validasi untuk memeriksa apakah ada aset dengan nama yang sama dalam jenis transaksi yang sama
        $query = "SELECT id_aset, grup, id_user FROM aset WHERE nama_aset = ? AND id_aset <> ? AND id_user = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sii", $editedCategoryName, $categoryId, $editIdUser);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // aset dengan nama yang sama sudah ada, kirim pesan kesalahan ke klien
            echo json_encode(['status' => 'error', 'message' => ["Aset Sudah Digunakan."]]);
        } else {
            // Nama aset unik, lanjutkan dengan UPDATE
            // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$editIdUser'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah aset dengan id_user dan grup tertentu
            $asetCountQuery = "SELECT COUNT(*) as count FROM aset WHERE id_user = '$editIdUser' AND grup = '$grup' AND tgl_b != '0000-00-00 00:00:00'";
            $asetCountResult = mysqli_query($koneksi, $asetCountQuery);
            $countRow = mysqli_fetch_assoc($asetCountResult);
            $asetCount = $countRow['count'];

            if ($userStatus == '0') {
                // Jika status pengguna adalah 0 dan jumlah aset mencapai batasan, tampilkan pesan harus menjadi premium
                if ($asetCount >= 5) {
                    echo json_encode(['status' => 'error', 'message' => ["Anda harus upgrade akun ke premium."]]);
                } else {
                    // Nama aset unik, lanjutkan dengan UPDATE
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE aset SET id_user = ?, grup = ?, nama_aset = ?, total = ?, deskripsi = ?, tgl_e = ? WHERE id_aset = ?";
                    $stmt = mysqli_prepare($koneksi, $query);
                    mysqli_stmt_bind_param($stmt, "isssssi", $editIdUser, $grup, $editedCategoryName, $total, $deskripsi, $currentDateTime, $categoryId);

                    if (mysqli_stmt_execute($stmt)) {
                        // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                        echo json_encode(['status' => 'success']);
                    } else {
                        // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                        echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                    }
                }
            } else {
                // Jika status pengguna bukan 0, lanjutkan tanpa memeriksa batasan kategori
                // Nama kategori unik, lanjutkan dengan UPDATE
                date_default_timezone_set('Asia/Jakarta');
                $currentDateTime = date('Y-m-d H:i:s');
                $query = "UPDATE aset SET id_user = ?, grup = ?, nama_aset = ?, total = ?, deskripsi = ?, tgl_e = ? WHERE id_aset = ?";
                $stmt = mysqli_prepare($koneksi, $query);
              mysqli_stmt_bind_param($stmt, "isssssi", $editIdUser, $grup, $editedCategoryName, $total, $deskripsi, $currentDateTime, $categoryId);

                if (mysqli_stmt_execute($stmt)) {
                    // Berhasil menyimpan perubahan, kirim respons sukses ke klien
                    echo json_encode(['status' => 'success']);
                } else {
                    // Gagal menyimpan perubahan, kirim pesan kesalahan ke klien
                    echo json_encode(['status' => 'error', 'message' => ["Gagal menyimpan perubahan."]]);
                }
            }
        }
    }
}
?>
