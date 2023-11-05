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
        $errors[] = "Nama Kategori tidak boleh kosong.";
    }
    if (empty($_POST['id_users'])) {
        $errors[] = "Tidak boleh kosong.";
    }
    if (empty($_POST['transaksi_kategori'])) {
        $errors[] = "Tidak boleh kosong.";
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
        $transaksi = $_POST['transaksi_kategori'];

        // Lakukan proses validasi untuk memeriksa apakah ada kategori dengan nama yang sama dalam jenis transaksi yang sama
       $query = "SELECT id_kategori, transaksi, id_user FROM kategori WHERE nama_kategori = ? AND id_kategori <> ? AND id_user = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sii", $editedCategoryName, $categoryId, $editIdUser);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Kategori dengan nama yang sama sudah ada, kirim pesan kesalahan ke klien
            echo json_encode(['status' => 'error', 'message' => ["Kategori Sudah Ada!"]]);
        } else {
            // Nama kategori unik, lanjutkan dengan UPDATE
            // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
            $statusQuery = "SELECT status FROM users WHERE id_user = '$editIdUser'";
            $statusResult = mysqli_query($koneksi, $statusQuery);
            $statusRow = mysqli_fetch_assoc($statusResult);
            $userStatus = $statusRow['status'];

            // Query untuk menghitung jumlah kategori dengan id_user dan transaksi tertentu
            $kategoriCountQuery = "SELECT COUNT(*) as count FROM kategori WHERE id_user = '$editIdUser' AND transaksi = '$transaksi' AND tgl_b != '0000-00-00 00:00:00'";
            $kategoriCountResult = mysqli_query($koneksi, $kategoriCountQuery);
            $countRow = mysqli_fetch_assoc($kategoriCountResult);
            $kategoriCount = $countRow['count'];

            if ($userStatus == '0') {
                // Jika status pengguna adalah 0 dan jumlah kategori mencapai batasan, tampilkan pesan harus menjadi premium
                if ($kategoriCount >= 5) {
                    echo json_encode(['status' => 'error', 'message' => ["Anda harus upgrade akun ke premium."]]);
                } else {
                    // Nama kategori unik, lanjutkan dengan UPDATE
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE kategori SET id_user = ?, transaksi = ?, nama_kategori = ?, tgl_e = ? WHERE id_kategori = ?";
                    $stmt = mysqli_prepare($koneksi, $query);
                    mysqli_stmt_bind_param($stmt, "isssi", $editIdUser, $transaksi, $editedCategoryName, $currentDateTime, $categoryId);

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
                $query = "UPDATE kategori SET id_user = ?, transaksi = ?, nama_kategori = ?, tgl_e = ? WHERE id_kategori = ?";
                $stmt = mysqli_prepare($koneksi, $query);
               mysqli_stmt_bind_param($stmt, "isssi", $editIdUser, $transaksi, $editedCategoryName, $currentDateTime, $categoryId);

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
