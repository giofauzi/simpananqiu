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
    if (empty($_POST['id_admin'])) {
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
        $editIdAdmin = $_POST['id_admin'];
        $transaksi = $_POST['transaksi_kategori'];

        // Lakukan proses validasi untuk memeriksa apakah ada kategori dengan nama yang sama dalam jenis transaksi yang sama
       $query = "SELECT id_kategori, transaksi, id_admin FROM kategori WHERE nama_kategori = ? AND id_kategori <> ? AND id_admin = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sii", $editedCategoryName, $categoryId, $editIdAdmin);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Kategori dengan nama yang sama sudah ada, kirim pesan kesalahan ke klien
            echo json_encode(['status' => 'error', 'message' => ["Kategori Sudah Ada!"]]);
        } else {
                    // Nama kategori unik, lanjutkan dengan UPDATE
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $query = "UPDATE kategori SET id_admin = ?, transaksi = ?, nama_kategori = ?, tgl_e = ? WHERE id_kategori = ?";
                    $stmt = mysqli_prepare($koneksi, $query);
                    mysqli_stmt_bind_param($stmt, "isssi", $editIdAdmin, $transaksi, $editedCategoryName, $currentDateTime, $categoryId);

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
    
?>
