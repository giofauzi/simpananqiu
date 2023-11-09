<?php 
include "session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SimpananQiu</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Sweetalert2 -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="../plugins/pace-progress/themes/black/pace-theme-flat-top.css">
   <!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


   <!-- Favicons -->
  <link href="../dist/img/favicon.jpeg" rel="icon">
  <link href="../dist/img/favicon.jpeg" rel="apple-touch-icon">

  
    <!-- SweetAlert2 -->
  <!-- <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> -->
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">


<?php 
// Query database untuk memeriksa nilai 'status' dari tabel 'users' untuk pengguna saat ini
$query = "SELECT status FROM users WHERE id_user = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_users); // Ganti "i" dengan tipe data yang sesuai
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user['status'] == 1) {
    // Tampilkan peringatan SweetAlert hanya jika 'status' adalah 1 (misalnya, pengguna belum premium)
    echo "<script>
    function tampilkanIklan() {
      Swal.fire({
        title: 'Oops!',
        text: 'Anda Belum Premium!',
        imageUrl: '../../assets/img/promo.png',
        imageWidth: 300,
        imageHeight: 300,
        imageAlt: 'Custom image',
      });
    }

    // Menampilkan SweetAlert pertama kali setelah halaman dimuat
    setTimeout(tampilkanIklan, 60000); // Show the alert after 1 minute

    // Membuat interval untuk menampilkan SweetAlert setiap 1 menit
    setInterval(tampilkanIklan, 60000); // Show the alert every minute
    </script>";
}

?>


  
  <style>

 .input-container {
    position: relative;
  }
  
  .toggle-password {
    position: absolute;
    top: 30%;
    right: 30px;
    transform: translateY(90%);
    transform: scale(1.5);
    cursor: pointer;
  }

   .toggle-password2 {
    position: absolute;
    top: 30%;
    right: 30px;
    transform: translateY(90%);
    transform: scale(1.5);
    cursor: pointer;
  }
  
  
/* CSS untuk tampilan gambar */
.custom-modal-content {
  text-align: center;
}

/* CSS untuk tombol tutup */
.custom-modal-close-button {
  background-color: transparent;
  border: none;
  color: #000;
  position: absolute;
  top: 10px;
  right: 10px;
}


    .floating-icon {
  position: fixed;
  bottom: 85px; /* Jarak dari bawah halaman */
  right: 20px; /* Jarak dari sisi kanan halaman */
  z-index: 999; /* Layer di atas elemen lain */
}


.clickable {
  cursor: pointer;
  transition: background-color 0.9s;
}

.clickable:hover {
  background-color: grey;
   color:white;
}



.modal.modal-bottom .modal-dialog {
  position: fixed;
  bottom: -100%;
  left: 0;
  right: 0;
  margin: 0;
  transition: bottom 0.5s;
}

.modal.modal-bottom.show .modal-dialog {
  bottom: 0;
}
/* CSS untuk modal di layar yang lebih kecil (contohnya, lebar kurang dari 768px) */
@media (max-width: 768px) {
  .modal.modal-bottom .modal-dialog {
    bottom: -100%;
  }
  #previewImage {
    width: 200px;
    height: 200px;
    margin-bottom: 10px;
  }
   #previewImage_p {
    width: 200px;
    height: 200px;
    margin-bottom: 10px;
  }
}

/* CSS untuk modal di layar yang lebih besar */
@media (min-width: 768px) {
  .modal.modal-bottom .modal-dialog {
    bottom: -100%;
  }
}


.circle {
  background-color: #007BFF; /* Warna latar belakang lingkaran */
  width: 50px; /* Lebar lingkaran */
  height: 50px; /* Tinggi lingkaran */
  border-radius: 50%; /* Membuat lingkaran */
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Efek bayangan */
  cursor: pointer; /* Mengubah kursor saat diarahkan ke ikon */
}

.circle i {
  color: white; /* Warna ikon */
  font-size: 24px; /* Ukuran ikon */
}
/* Ganti ukuran tampilan saat lebar layar kurang dari 768px (tampilan mobile) */
@media (max-width: 768px) {
  .floating-icon {
    display: block; /* Tampilkan ikon plus */
  }
}

/* Gantilah ukuran tampilan saat lebar layar lebih dari atau sama dengan 768px (tampilan desktop) */
@media (min-width: 768px) {
  .floating-icon {
    display: none; /* Sembunyikan ikon plus */
  }
}
  /* Tampilkan tombol hanya saat lebar layar >= 768px */
    @media screen and (max-width: 768px) {
        #tombol {
            display: none; /* Tampilkan tombol saat lebar layar >= 768px, dan mobile tidak ada tombolnya */
        }
    }
    
  </style>
</head>
<body class="hold-transition sidebar-mini pace-primary">
<div class="wrapper">


 <?php
// Menentukan halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Periksa apakah halaman saat ini bukan transaksi.php atau update.php
if ($current_page !== 'transaksi.php' && $current_page !== 'update.php') {
    // Tampilkan preloader.
    ?>
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../dist/img/favicon.png" alt="Logo SimpananQiu" height="200" width="200">
    </div>
    <?php
}
?>
