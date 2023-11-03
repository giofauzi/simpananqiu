 <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Sweetalert2 -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../users/plugins/fontawesome-free/css/all.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="../../users/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
   <!-- daterange picker -->
  <link rel="stylesheet" href="../../users/plugins/daterangepicker/daterangepicker.css">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../users/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../users/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../users/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../users/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../users/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../users/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../../users/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../../users/plugins/dropzone/min/dropzone.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../users/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../users/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../users/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


   <!-- Favicons -->
  <link href="../../users/../../users/assets/img/favicon.jpeg" rel="icon">
  <link href="../../users/../../users/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  
    <!-- SweetAlert2 -->
  <!-- <link rel="stylesheet" href="../../users/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> -->
  <!-- Toastr -->
  <link rel="stylesheet" href="../../users/plugins/toastr/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Theme style -->
  <link rel="stylesheet" href="../../users/dist/css/adminlte.min.css">
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
     <a href="" class="brand-link">
      <img src="../../users/dist/img/favicon.jpeg" alt="Logo SimpananQiu" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SimpananQiu</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../assets/img/admin-aja.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="../profile/profile.php" class="d-block"><?= $all['username'] ?></a>
        </div>
      </div>
     
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <?php
// Dapatkan nama file skrip PHP saat ini
$current_page = basename($_SERVER['PHP_SELF']);
// Daftar kategori
$setting = [
    'profile.php' => ['icon' => 'fas fa-user', 'title' => 'Profile'],
    
   
];
$master = [
    'k_s.php' => ['icon' => 'fas fa-tag', 'title' => 'Kategori'],
    // 'aset.php' => ['icon' => 'fas fa-wallet', 'title' => 'Aset'],
   
];

?>

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="../dashboard/index.php" class="nav-link <?= ($current_page === 'index.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>
     <li class="nav-item <?= (in_array($current_page, array_keys($master))) ? 'menu-open' : ''; ?>">
        <a href="#" class="nav-link <?= (in_array($current_page, array_keys($master))) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-folder"></i>
            <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php foreach ($master as $page => $master): ?>
    <li class="nav-item">
        <a href="../master/<?= $page ?>" class="nav-link <?= ($current_page === $page) ? 'active' : ''; ?>">
            <i class="<?= $master['icon'] ?> nav-icon"></i>
            <p><?= $master['title'] ?></p>
        </a>
    </li>
<?php endforeach; ?>

        </ul>
    </li>

    <li class="nav-item">
        <a href="../akun/akun.php" class="nav-link <?= ($current_page === 'akun.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
                Akun User
            </p>
        </a>
    </li>

    <li class="nav-item">
    <a href="../kontak/kontak.php" class="nav-link <?= ($current_page === 'kontak.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-address-book"></i> <!-- Mengganti ikon ke fas fa-address-book -->
        <p>
            Kontak
        </p>
    </a>
</li>

    
    <li class="nav-item <?= (in_array($current_page, array_keys($setting))) ? 'menu-open' : ''; ?>">
        <a href="#" class="nav-link <?= (in_array($current_page, array_keys($setting))) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                Pengaturan
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php foreach ($setting as $page => $settings): ?>
    <li class="nav-item">
        <a href="../profile/<?= $page ?>" class="nav-link <?= ($current_page === $page) ? 'active' : ''; ?>">
            <i class="<?= $settings['icon'] ?> nav-icon"></i>
            <p><?= $settings['title'] ?></p>
        </a>
    </li>
    </ul>
    </li>

    <li class="nav-item">
        <a href="#" id="logoutLink" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
                Logout
            </p>
        </a>
    </li>
    
<?php endforeach; ?>

        

     

</ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
document.getElementById('logoutLink').addEventListener('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda yakin ingin logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../logout.php';
        }
    });
});
</script>

<!-- jQuery -->
<script src="../../users/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../users/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../users/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../users/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../users/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../users/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../users/plugins/jszip/jszip.min.js"></script>
<script src="../../users/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../users/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../users/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="../../users/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../users/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../users/plugins/moment/moment.min.js"></script>
<script src="../../users/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../users/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../users/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../users/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../users/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../users/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../users/plugins/dropzone/min/dropzone.min.js"></script>

<!-- SweetAlert2 -->
<!-- <script src="../../users/plugins/sweetalert2/sweetalert2.min.js"></script> -->
<!-- Toastr -->
<script src="../../users/plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE App -->
<script src="../../users/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../users/dist/js/demo.js"></script>
  <!-- pace-progress -->
<script src="../../users/plugins/pace-progress/pace.min.js"></script>