<?php
include "../../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array(); // Inisialisasi array untuk menyimpan pesan kesalahan

    // Ambil data yang dikirim dari permintaan AJAX
    $id_admin = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
    $nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Gantilah query ini dengan yang sesuai untuk mengambil data pengguna yang sesuai.
    $sql_select_admin = "SELECT * FROM admin WHERE id_admin = $id_admin";
    $result = $koneksi->query($sql_select_admin);

    if ($result->num_rows > 0) {
        $admin_data = $result->fetch_assoc();

        // Periksa jika password diisi atau tidak
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Jika password tidak diisi, gunakan password lama
            $hashedPassword = $admin_data['password']; // Gunakan password lama yang diambil dari data pengguna
        }

        // Periksa apakah ada input yang kosong
        if (empty($id_admin)) {
            $errors[] = "Id admin tidak boleh kosong.";
        }
        if (empty($nama_admin)) {
            $errors[] = "Nama admin tidak boleh kosong.";
        }
        if (empty($username)) {
            $errors[] = "Username tidak boleh kosong.";
        }

        // Jika ada pesan kesalahan, kirim pesan kesalahan sebagai respons
        if (!empty($errors)) {
            $response = array("status" => "error", "message" => $errors);
            echo json_encode($response);
        } else {
        
            $sql = "UPDATE admin SET nama_admin='$nama_admin', username='$username', password='$hashedPassword' WHERE id_admin=$id_admin";

            if ($koneksi->query($sql) === TRUE) {
                $response = array("status" => "success");
            } else {
                $response = array("status" => "error", "message" => $koneksi->error);
            }

            echo json_encode($response);

            // Tutup koneksi ke database
            $koneksi->close();
        }
    }
}
?>
