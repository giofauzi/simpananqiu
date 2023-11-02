<?php
// Mulai atau lanjutkan sesi
session_start();

include "../../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array(); // Inisialisasi array untuk menyimpan pesan kesalahan

    // Ambil data yang dikirim dari permintaan AJAX
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $vr = mysqli_real_escape_string($koneksi, $_POST['vr']);

    // Gantilah query ini dengan yang sesuai untuk mengambil data pengguna yang sesuai.
    $sql_select_user = "SELECT * FROM users WHERE id_user = $id_user";
    $result = $koneksi->query($sql_select_user);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Sekarang Anda memiliki data pengguna yang ingin diubah dalam $user_data
        // Anda bisa mengakses kolom vr dari $user_data saat memeriksa vr.

        // Setel sesi status_vr berdasarkan data yang diperoleh
        $_SESSION['status_vr'] = $user_data['vr'];

        // Periksa jika vr diisi atau tidak
        if (!empty($vr)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Jika vr tidak diisi, gunakan vr lama
            $hashedPassword = $user_data['vr']; // Gunakan vr lama yang diambil dari data pengguna
        }

        // Periksa apakah ada input yang kosong
        if (empty($id_user)) {
            $errors[] = "Id User tidak boleh kosong.";
        }
        if (empty($vr)) {
            $errors[] = "Verifikasi tidak boleh kosong.";
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
            $sql = "UPDATE users SET tgl_e = '$currentDateTime', vr='$hashedPassword' WHERE id_user=$id_user";

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
