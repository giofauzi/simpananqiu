<?php 
session_start();
include "../koneksi.php";
$id_users = $_SESSION['user_login'];

$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = $id_users");
$all = mysqli_fetch_array($result);

// Periksa apakah sesi 'status_vr' sudah diinisialisasi
if (isset($_SESSION['status_vr']) && $_SESSION['status_vr'] !== null) {
    // Sesuaikan kode sesuai kebutuhan jika sesi 'status_vr' sudah ada
    $verifikasi =  $_SESSION['status_vr'];
    // Lanjutkan dengan kode Anda yang menggunakan $verifikasi
    // ...
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $vr = mysqli_real_escape_string($koneksi, $_POST['vr']);

    $query = "SELECT * FROM users WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($vr, $user['vr'])) {
            $_SESSION['user_login'] = $user['id_user'];
            $_SESSION['status_vr'] = $user['vr'];
        $_SESSION['user_last_activity'] = time(); // Setel waktu aktivitas terakhir
            header("Location: ../users/"); // Jika 'vr' ada datanya, arahkan ke index.php
    } else {
        $_SESSION['error_message'] = 'Password yang Anda masukkan salah.';
        header("Location: lockscreen.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lockscreen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
   
    <a href="index2.html"><b>SimpananQIu</b></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?=  $all['username'] ?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="../data/img/users/<?= $all['foto'] ?>" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="post" action="">
      <div class="input-group">
        <input type="hidden" name="id_user" class="form-control" value="<?= $id_users ?>">
        <input type="password" name="vr" class="form-control" placeholder="Password Verifikasi">

        <div class="input-group-append">
          <button type="submit" class="btn">
            <i class="fas fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

    <?php
if (isset($_SESSION['error_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "error",';
    echo '    title: "' . $_SESSION['error_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 2000'; //Ini 2 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['error_message']); // Hapus pesan dari session
}

// 
?>

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Masukkan Verifikasi 2 Langkah
  </div>
  <div class="text-center">
    <a href="lupa_password.php">Lupa?</a>
  </div>
 <div class="lockscreen-footer text-center">
    Copyright &copy;<?php echo date("Y"); ?> -  <b><a href="" class="text-black">SIMPANANQIU</a></b><br>
    All rights reserved
</div>

</div>
<!-- /.center -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
