
<?php
// Sesuaikan dengan koneksi database Anda
include "../../koneksi.php";

// Cek apakah permintaan datang dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data yang diterima
    if (empty($_POST['id_user'])) {
        echo "Id User tidak boleh kosong.";
    } else if (empty($_POST['transaksi'])) {
        echo "Transaksi tidak boleh kosong.";
    } else if (empty($_POST['nama_kategori'])) {
        echo "Nama kategori tidak boleh kosong.";
    } else {
        $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
        $transaksi = mysqli_real_escape_string($koneksi, $_POST['transaksi']);
        $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

        // Periksa apakah status pengguna dengan id_user yang sesuai adalah 0
        $statusQuery = "SELECT status FROM users WHERE id_user = '$id_user'";
        $statusResult = mysqli_query($koneksi, $statusQuery);
        $statusRow = mysqli_fetch_assoc($statusResult);
        $userStatus = $statusRow['status'];

        // Query untuk menghitung jumlah kategori dengan id_user dan transaksi tertentu
        $kategoriCountQuery = "SELECT COUNT(*) as count FROM kategori WHERE id_user = '$id_user' AND transaksi = '$transaksi' AND tgl_b != '0000-00-00 00:00:00'";
        $kategoriCountResult = mysqli_query($koneksi, $kategoriCountQuery);
        $countRow = mysqli_fetch_assoc($kategoriCountResult);
        $kategoriCount = $countRow['count'];

    if ($userStatus == '0') {
    // Jika status pengguna adalah 0 dan jumlah kategori mencapai batasan, tampilkan pesan harus menjadi premium
    if ($kategoriCount >= 5) {
        echo "Anda harus upgrade akun ke premium";
    } else {
        // Query untuk memeriksa apakah nama kategori sudah ada dalam database dengan transaksi yang sesuai
        $checkQuery = "SELECT COUNT(*) as count FROM kategori WHERE id_user = '$id_user' AND  nama_kategori = '$nama_kategori' AND transaksi = '$transaksi'";
        $checkResult = mysqli_query($koneksi, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $kategoriCount = $row['count'];
        
        if ($kategoriCount > 0) {
            echo "Kategori Sudah Ada!";
        } else {
            // Lanjutkan dengan query untuk menambahkan data
            date_default_timezone_set('Asia/Jakarta');
            $currentDateTime = date('Y-m-d H:i:s');
            $query = "INSERT INTO kategori (id_user, transaksi, nama_kategori, tgl_b) VALUES ('$id_user', '$transaksi', '$nama_kategori', '$currentDateTime')";

            if (mysqli_query($koneksi, $query)) {
                echo "Kategori berhasil ditambahkan.";
            } else {
                echo "Terjadi kesalahan saat menambahkan kategori: " . mysqli_error($koneksi);
            }
        }
    }
} else {
    // Query untuk memeriksa apakah nama kategori sudah ada dalam database dengan transaksi yang sesuai
    $checkQuery = "SELECT COUNT(*) as count FROM kategori WHERE  id_user = '$id_user' AND nama_kategori = '$nama_kategori' AND transaksi = '$transaksi'";
    $checkResult = mysqli_query($koneksi, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $kategoriCount = $row['count'];
    
    if ($kategoriCount > 0) {
        echo "Kategori Sudah Ada!";
    } else {
        // Jika status pengguna bukan 0, lanjutkan tanpa memeriksa batasan kategori
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO kategori (id_user, transaksi, nama_kategori, tgl_b) VALUES ('$id_user', '$transaksi', '$nama_kategori', '$currentDateTime')";

        if (mysqli_query($koneksi, $query)) {
            echo "Kategori berhasil ditambahkan.";
        } else {
            echo "Terjadi kesalahan saat menambahkan kategori: " . mysqli_error($koneksi);
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
