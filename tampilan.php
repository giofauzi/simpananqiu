<?php 
session_start();
include "koneksi.php";

// Tambah Data Kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kontak'])) {
    // Validasi input
    $errors = [];

     if (empty($_POST['nama_orang'])) {
        $errors[] = 'Nama tidak boleh kosong';
    } else {
        $nama_orang = mysqli_real_escape_string($koneksi, $_POST['nama_orang']);
    }

     if (empty($_POST['email_orang'])) {
        $errors[] = 'Email tidak boleh kosong';
    } else {
        $email_orang = mysqli_real_escape_string($koneksi, $_POST['email_orang']);
    }

    if (empty($_POST['judul'])) {
        $errors[] = 'Judul tidak boleh kosong';
    } else {
        $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    }

    if (empty($_POST['pesan'])) {
        $errors[] = 'Pesan Regu tidak boleh kosong';
    } else {
        $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);
    }

   

   if (empty($errors)) {
    // Query untuk insert data ke dalam tabel "area"
   // Mengambil tanggal dan waktu saat ini dalam format datetime
date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke Indonesia

$currentDateTime = date('Y-m-d H:i:s');

$query = "INSERT INTO kontak (nama, email, judul, pesan, tgl_b) VALUES ('$nama_orang', '$email_orang', '$judul', '$pesan', '$currentDateTime')";

// Eksekusi query untuk "area"
if (mysqli_query($koneksi, $query)) {
    // Berhasil ditambahkan
    session_start();
    $_SESSION['success_message'] = 'Terimakasih Atas Pesan Anda, Kami Akan Menghubungi Anda Secepatnya!';
    header("Location: ../simpananqiu/#contact");
    exit();
} else {
    // Terjadi kesalahan saat eksekusi query "area"
    session_start();
    $_SESSION['error_message'] = 'Maaf Server Sedang Error!: ' . mysqli_error($koneksi);
    header("Location: ../simpananqiu/#contact");
    exit();
}
} else {
    // Terdapat error validasi input
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
}

}
// Tambah Subscribe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
    // Validasi input
    $errors = [];

    if (empty($_POST['email'])) {
        $errors[] = 'Email tidak boleh kosong';
    } else {
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);

        // Cek apakah email sudah ada di database
        $query_check_email = "SELECT * FROM subscribe WHERE email = '$email'";
        $result_check_email = mysqli_query($koneksi, $query_check_email);

        if (mysqli_num_rows($result_check_email) > 0) {
         $_SESSION['subscribe_error'] = 'Opps, Email Anda Sudah Terdaftar!';
            header("Location: ../simpananqiu/#footer");
            exit();
        }
    }

    if (empty($errors)) {
        // Query untuk insert data ke dalam tabel "subscribe"
        date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke Indonesia
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO subscribe (email, tgl_b) VALUES ('$email', '$currentDateTime')";

        // Eksekusi query untuk "subscribe"
        if (mysqli_query($koneksi, $query)) {
            // Berhasil ditambahkan
            session_start();
            $_SESSION['success_message'] = 'Terimakasih Atas Subscribe Email Anda Pada Kami';
            header("Location: ../simpananqiu/#footer");
            exit();
        } else {
            // Terjadi kesalahan saat eksekusi query "subscribe"
            session_start();
            $_SESSION['error_message'] = 'Terjadi kesalahan saat menambahkan email: ' . mysqli_error($koneksi);
            header("Location: ../simpananqiu/#footer");
            exit();
        }
    } else {
        // Terdapat error validasi input
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIMPANANQIU</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Sweet Alert Cok -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    #hero {
  width: 100%;
  height: 99.8vh;
  background: #37517e;
}
#footer .footer-newsletter form button {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  border: 0;
  background: none;
  font-size: 16px;
  padding: 0 20px;
  background: #47b2e4;
  color: #fff;
  transition: 0.3s;
  border-radius: 50px;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
}

#footer .footer-newsletter form button:hover {
  background: #209dd8;
}
  </style>

  <!-- =======================================================
  * Template Name: Arsha
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
 


 

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Pencatatan Keuangan Anda</h1>
          <h2>Mudah, Efisiensi, dan Akurat</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#about" class="btn-get-started scrollto">Coba Gratis</a>
            <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Lihat Video</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
 

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>