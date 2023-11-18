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
  <link href="assets/img/favicon.jpeg" rel="icon">
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
  <!-- Dibawah ini untuk hasil input dari kontak  -->
<?php
if (isset($_SESSION['success_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['success_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 5000'; //Ini 5 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['success_message']); // Hapus pesan dari session
}
?>

<!-- Untuk notifikasi error -->
<?php
if (isset($_SESSION['error_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['error_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 5000'; //Ini 5 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['error_message']); // Hapus pesan dari session
}
?>

<!-- Untuk Email jika sudah subscribe -->
<?php
if (isset($_SESSION['subscribe_error'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['subscribe_error'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 5000'; //Ini 5 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['subscribe_error']); // Hapus pesan dari session
}
?>


  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.html">SimpananQiu</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Beranda</a></li>
          <li><a class="nav-link scrollto" href="#about">Tentang</a></li>
          <li><a class="nav-link scrollto" href="#services">Layanan</a></li>
          <!-- <li><a class="nav-link   scrollto" href="#portfolio">Portfolio</a></li> -->
          <li><a class="nav-link scrollto" href="#team">Tim</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
          <li><a class="nav-link scrollto" href="#contact">Kontak</a></li>
          <li><a class="getstarted scrollto" href="#pricing">Mulai</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Pencatatan Keuangan Anda</h1>
          <h2>Mudah, Efisiensi, dan Akurat</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="login/" class="btn-get-started scrollto">Coba Gratis</a>
            <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Lihat Video</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Clients Section ======= -->
    <!-- <section id="clients" class="clients section-bg">
      <div class="container">

        <div class="row" data-aos="zoom-in">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
          </div>

        </div>

      </div> -->
    </section>
    <!-- End Cliens Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Tentang Kami</h2>
        </div>

        <div class="row content">
  <div class="col-lg-6">
    <p>
      SimpananQiu dapat digunakan di mana saja, kapan saja, dan oleh siapa saja. Inilah beberapa kelebihannya:
    </p>
    <ul>
      <li><i class="ri-check-double-line"></i> Memudahkan pencatatan keuangan, termasuk pendapatan dan pengeluaran</li>
      <li><i class="ri-check-double-line"></i> Menyediakan fitur untuk menabung</li>
      <li><i class="ri-check-double-line"></i> Menghadirkan fitur pencatatan laporan keuangan Anda</li>
    </ul>
  </div>
  <div class="col-lg-6 pt-4 pt-lg-0">
    <p>
      SimpananQiu membantu meminimalkan risiko kesalahan akibat perhitungan yang salah. Sistem kami menggunakan perhitungan otomatis dengan rumus lengkap, sehingga Anda tidak perlu melakukan perhitungan manual.
    </p>
    <a href="#why-us" class="btn-learn-more">Pelajari Lebih Lanjut</a>
  </div>
</div>


      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
      <div class="container-fluid" data-aos="fade-up">

       <div class="row">
  <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
    <div class="content">
      <h3>Mengapa Menggunakan <strong>SimpananQiu?</strong></h3>
      <p>
        Mencatat keuangan pastinya bisa menjadi tugas yang rumit, bukan? Namun, SimpananQiu hadir dengan sejumlah alasan mengapa Anda harus memilihnya:
      </p>
    </div>

    <div class="accordion-list">
      <ul>
        <li>
          <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> Praktis dan Mudah Digunakan <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
          <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
            <p>
              SimpananQiu dirancang untuk memberikan pengalaman pengguna yang praktis dan mudah digunakan. Tidak perlu lagi menghadapi kompleksitas dalam mencatat keuangan Anda.
            </p>
          </div>
        </li>

        <li>
          <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span> Efisien dalam pencatatan Keuangan <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
          <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
            <p>
              Dengan fitur-fitur yang lengkap, SimpananQiu membantu Anda mencatat pendapatan dan pengeluaran secara efisien. pencatatan keuangan yang efektif dalam genggaman Anda.
            </p>
          </div>
        </li>

        <li>
          <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed"><span>03</span> Laporan Keuangan Akurat <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
          <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
            <p>
              SimpananQiu membantu Anda memantau keuangan Anda dengan laporan yang akurat. Informasi yang jelas dan terpercaya untuk keputusan yang bijak.
            </p>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("assets/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
</div>


      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Skills Section ======= -->
    <!-- <section id="skills" class="skills">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
            <img src="assets/img/skills.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
            <h3>Voluptatem dignissimos provident quasi corporis voluptates</h3>
            <p class="fst-italic">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>

            <div class="skills-content">

              <div class="progress">
                <span class="skill">HTML <i class="val">100%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">CSS <i class="val">90%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">JavaScript <i class="val">75%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Photoshop <i class="val">55%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </section> -->
    <!-- End Skills Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">
  <div class="section-title">
    <h2>Layanan Kami</h2>
    <p>Kami menyediakan beragam layanan yang memenuhi kebutuhan Anda. Berikut beberapa layanan unggulan kami:</p>
  </div>

  <div class="row">
    <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
      <div class="icon-box">
        <div class="icon"><i class="bx bxl-dribbble"></i></div>
        <h4><a href="">Solusi Lengkap</a></h4>
        <p>Menyediakan solusi lengkap untuk semua kebutuhan Anda</p>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
      <div class="icon-box">
        <div class="icon"><i class="bx bx-file"></i></div>
        <h4><a href="">Kemudahan</a></h4>
        <p>Memberikan kemudahan dalam mengatasi masalah dan tantangan Anda</p>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
      <div class="icon-box">
        <div class="icon"><i class="bx bx-tachometer"></i></div>
        <h4><a href="">Kualitas dan Kecepatan</a></h4>
        <p>Mengutamakan kualitas dan kecepatan dalam setiap pelayanan</p>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
      <div class="icon-box">
        <div class="icon"><i class="bx bx-layer"></i></div>
        <h4><a href="">Solusi Terbaik</a></h4>
        <p>Menyediakan berbagai solusi terbaik untuk mencapai tujuan Anda</p>
      </div>
    </div>
  </div>
</div>

    </section><!-- End Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
     <div class="container" data-aos="zoom-in">

  <div class="row">
    <div class="col-lg-9 text-center text-lg-start">
      <h3>Tindakan Panggilan</h3>
      <p>SimpananQiu siap membantu Anda dalam mencatat keuangan dengan mudah dan efisien. Mari bergabung bersama kami hari ini!</p>
    </div>
    <div class="col-lg-3 cta-btn-container text-center">
      <a class="cta-btn align-middle" href="login/">Mulai Sekarang</a>
    </div>
  </div>

</div>

    </section><!-- End Cta Section -->

    <!-- ======= Portfolio Section ======= -->
    <!-- <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Portfolio</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <li data-filter="*" class="filter-active">All</li>
          <li data-filter=".filter-app">App</li>
          <li data-filter=".filter-card">Card</li>
          <li data-filter=".filter-web">Web</li>
        </ul>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 1</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Web 3</h4>
              <p>Web</p>
              <a href="assets/img/portfolio/portfolio-2.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 2</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 2</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-4.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Web 2</h4>
              <p>Web</p>
              <a href="assets/img/portfolio/portfolio-5.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 3</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-6.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 1</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-7.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 3</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-8.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Web 3</h4>
              <p>Web</p>
              <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Portfolio Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container" data-aos="fade-up">

       <div class="section-title">
  <h2>Tim Kami</h2>
  <p>Kami adalah tim yang berdedikasi untuk membantu Anda dalam mencatat keuangan dengan lebih baik. Kami siap memberikan solusi yang praktis dan efisien untuk memenuhi kebutuhan Anda.</p>
</div>


        <div class="row">

          <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/fajar.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Fajar Maulana Nugroho Sutardi</h4>
                <span>Leader, Front End, Back End</span>
                <p>Use your instincts to do good, even though the person you are helping may not have reason.</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/farish.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Farish Augie Yukeza</h4>
                <span>UI/UX Designer</span>
                <p>If they can, why should I?</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/gio.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Giofany Fauziano</h4>
                <span>Databases, Front End, Back End</span>
                <p>Learn as if you will live forever, live as if you will die tomorrow</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/nafkah.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Nafkha Fauziah</h4>
                <span>System Analyst, QA Tester</span>
                <p>Will always love fictional characters</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

           <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/najla.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Najla Salsabila Putri Patiary</h4>
                <span>System Analyst, QA Tester</span>
                <p>When you give joy to others, you get more joy in return. You need to think carefully about the happiness you can give.</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="member d-flex align-items-start">
              <div class="pic"><img src="assets/img/riska.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Riska Lia Amaliah Siagian</h4>
                <span>UI/UX Designer</span>
                <p>When you fall, try to get up and look back at how far you have come</p>
                <div class="social">
                  <a href=""><i class="ri-twitter-fill"></i></a>
                  <a href=""><i class="ri-facebook-fill"></i></a>
                  <a href=""><i class="ri-instagram-fill"></i></a>
                  <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
   <h2>Harga</h2>
   <p>Kami menawarkan berbagai pilihan harga yang sesuai dengan kebutuhan Anda. Temukan penawaran terbaik kami di sini.</p>
</div>


       <div class="row">
   <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
      <div class="box">
         <h3>Rencana Gratis</h3>
         <h4><sup>Rp</sup>0<span>per bulan</span></h4>
         <ul>
            <li><i class="bx bx-check"></i> Fitur Menabung Terbatas</li>
            <li><i class="bx bx-check"></i> Fitur Pencatatan Pengeluaran Terbatas</li>
            <li><i class="bx bx-check"></i> Fitur Pencatatan Pendapatan Terbatas</li>
            <li class="na"><i class="bx bx-x"></i> <span>Layanan Prioritas (VIP)</span></li>
            <li class="na"><i class="bx bx-x"></i> <span>Fitur Pencatatan Keuangan Tidak Terbatas</span></li>
         </ul>
         <a href="login/" class="buy-btn">Mulai</a>
      </div>
   </div>

   <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
      <div class="box featured">
         <h3>Rencana Premium</h3>
         <h4><sup>Rp</sup>100.000,00<span>per bulan</span></h4>
         <ul>
            <li><i class="bx bx-check"></i> Fitur Menabung Tidak Terbatas</li>
            <li><i class="bx bx-check"></i> Fitur Pencatatan Pengeluaran Tidak Terbatas</li>
            <li><i class="bx bx-check"></i> Fitur Pencatatan Pendapatan Tidak Terbatas</li>
            <li><i class="bx bx-check"></i> Akses Prioritas</li>
            <li><i class="bx bx-check"></i> Konsultasi Keuangan Pribadi</li>
         </ul>
         <a href="login/" class="buy-btn">Mulai</a>
      </div>
   </div>
</div>


      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">
  <div class="section-title">
    <h2>Pertanyaan yang Sering Diajukan</h2>
    <p>Di bawah ini adalah beberapa pertanyaan yang sering diajukan tentang layanan kami. Temukan jawaban Anda di sini:</p>
  </div>

  <div class="faq-list">
    <ul>
      <li data-aos="fade-up" data-aos-delay="100">
        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Bagaimana cara menggunakan layanan kami? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
        <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
          <p>
            Anda dapat dengan mudah menggunakan layanan kami dengan mengikuti langkah-langkah yang tertera di situs kami. Silakan ikuti panduan yang kami sediakan.
          </p>
        </div>
      </li>

      <li data-aos="fade-up" data-aos-delay="200">
        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Apa manfaat dari layanan ini? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
        <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
          <p>
            Layanan kami memberikan berbagai manfaat, termasuk kemudahan dalam menyelesaikan tugas-tugas keuangan Anda dan solusi untuk tantangan keuangan Anda.
          </p>
        </div>
      </li>

      <li data-aos="fade-up" data-aos-delay="300">
        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">Bagaimana cara menghubungi tim dukungan pelanggan? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
        <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
          <p>
            Anda dapat menghubungi tim dukungan pelanggan kami melalui kontak yang tersedia di situs kami. Kami siap membantu Anda dengan pertanyaan atau masalah apa pun.
          </p>
        </div>
      </li>

      <li data-aos="fade-up" data-aos-delay="400">
        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Bagaimana cara memanfaatkan fitur-fitur kami? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
        <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
          <p>
            Anda dapat memanfaatkan semua fitur yang kami sediakan dengan mengikuti petunjuk yang ada di situs kami. Dapatkan manfaat maksimal dari layanan kami.
          </p>
        </div>
      </li>

      <li data-aos="fade-up" data-aos-delay="500">
        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Bagaimana keamanan informasi pribadi saya dijaga? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
        <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
          <p>
            Keamanan informasi pribadi Anda adalah prioritas bagi kami. Kami memiliki tindakan keamanan yang ketat untuk melindungi data Anda dari akses yang tidak sah.
          </p>
        </div>
      </li>
    </ul>
  </div>
</div>

    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

       <div class="section-title">
    <h2>Kontak</h2>
    <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, silakan hubungi kami melalui informasi di bawah ini:</p>
  </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Lokasi:</h4>
                <p>Jl. Barokah No. 06 Wanaherang Gunungputri 16965</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>simpananqiu@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telepon:</h4>
                <p>+62 898928499</p>
              </div>

              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d991.1926345826656!2d106.939711!3d-6.4235214!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eae99f5ccb45%3A0x343a14e466d07009!2sSMK%20Negeri%20Gunung%20Putri%20Bogor!5e0!3m2!1sid!2sid!4v1696902861476!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
              
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="" method="post"  class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="nama_orang">Nama</label>
                  <input type="text" name="nama_orang" class="form-control" id="nama_orang" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="email_orang">Email </label>
                  <input type="email" class="form-control" name="email_orang" id="email_orang" required>
                </div>
              </div>
              <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" name="judul" id="judul" required>
              </div>
              <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea class="form-control" name="pesan" id="pesan" rows="10" required></textarea>
              </div>
             
              <div class="text-center"><button type="submit" name="kontak">Kirim Pesan</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 col-md-6 footer-contact">
        <h3>SimpananQiu</h3>
        <p>
         Jl. Barokah No. 06 Wanaherang Gunungputri 16965<br>
        
          <strong>Telepon:</strong> +62 898928499<br>
          <strong>Email:</strong> simpananqiu@gmail.com<br>
        </p>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Tautan Berguna</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#hero">Beranda</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#about">Tentang Kami</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#services">Layanan</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Kebijakan Layanan</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Kebijakan Privasi</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Layanan Kami</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Desain Web</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Pengembangan Web</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Manajemen Produk</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Pemasaran</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Desain Grafis</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Jejaring Sosial Kami</h4>
        <p>Tetap terhubung dengan kami melalui media sosial:</p>
        <div class="social-links mt-3">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-google"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>

    </div>
  </div>
</div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>SimpananQiu</span></strong>. All Rights Reserved
      </div>
      <!-- <div class="credits"> -->
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/"></a> -->
      </div>
    </div>
  </footer><!-- End Footer -->

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