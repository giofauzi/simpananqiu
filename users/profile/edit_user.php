<?php
include "../../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array(); // Inisialisasi array untuk menyimpan pesan kesalahan

    // Ambil data yang dikirim dari permintaan AJAX
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $gender = mysqli_real_escape_string($koneksi, $_POST['gender']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Gantilah query ini dengan yang sesuai untuk mengambil data pengguna yang sesuai.
    $sql_select_user = "SELECT * FROM users WHERE id_user = $id_user";
    $result = $koneksi->query($sql_select_user);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Sekarang Anda memiliki data pengguna yang ingin diubah dalam $user_data
        // Anda bisa mengakses kolom password dan foto dari $user_data saat memeriksa password dan foto.

        // Periksa apakah ada file gambar baru yang diunggah
      if (!empty($_FILES['fileInput']['name'])) {
    $gambarDir = "../../data/img/users/";
    $gambar = $_FILES['fileInput']['name'];
    $gambarTmp = $_FILES['fileInput']['tmp_name'];
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


        // Periksa jika password diisi atau tidak
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Jika password tidak diisi, gunakan password lama
            $hashedPassword = $user_data['password']; // Gunakan password lama yang diambil dari data pengguna
        }

        // Periksa apakah ada input yang kosong
        if (empty($id_user)) {
            $errors[] = "Id User tidak boleh kosong.";
        }
        if (empty($nama_user)) {
            $errors[] = "Nama User tidak boleh kosong.";
        }
        if (empty($username)) {
            $errors[] = "Username tidak boleh kosong.";
        }
        if (empty($gender)) {
            $errors[] = "Jenis Kelamin tidak boleh kosong.";
        }
        if (empty($no_hp)) {
            $errors[] = "No handphone tidak boleh kosong.";
        }
        if (empty($email)) {
            $errors[] = "Email tidak boleh kosong.";
        }

        // Jika ada pesan kesalahan, kirim pesan kesalahan sebagai respons
        if (!empty($errors)) {
            $response = array("status" => "error", "message" => $errors);
            echo json_encode($response);
        } else {
            // Mengambil tanggal dan waktu saat ini dalam format datetime
date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke Indonesia

$currentDateTime = date('Y-m-d H:i:s');
            // Semua input diisi, lanjutkan dengan pembaruan data pengguna dalam database
            $sql = "UPDATE users SET nama_user='$nama_user', username='$username', gender='$gender', no_hp='$no_hp', email='$email', password='$hashedPassword', foto = '$gambarName', tgl_e = '$currentDateTime'  WHERE id_user=$id_user";

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
