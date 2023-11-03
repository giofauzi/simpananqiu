<?php include '../view/header_t.php' ?>
<?php include '../view/navbar_t.php' ?>
<?php include '../view/sidebar_t.php' ?>
<!-- Include Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Akun User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    

<div class="card">
               <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Judul</th>
                    <th>Pesan</th>
                    <th>Tanggal Buat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  
                  <tbody>

                  
                  <?php
                  function sensorEmail($email) {
    $parts = explode('@', $email);
    $username = $parts[0];
    $domain = $parts[1];

    $sensoredUsername = substr($username, 0, 3) . str_repeat('*', max(0, strlen($username) - 4));

    return $sensoredUsername . '@' . $domain;
}
$no = 1;
$query = mysqli_query($koneksi, "SELECT * FROM kontak");
while ($row = mysqli_fetch_array($query)) {
?>
<tr>
  <td><?= $no++; ?></td>
  <td><?= $row['nama']; ?></td>
  <td> <?php
      if ($row['id_user'] == 0) {
          echo 'Bukan Pengguna';
      } else {
          echo 'Pengguna';
      }
      ?></td>
  <td><?= sensorEmail($row['email']); ?></td>
  <td><?= $row['judul']; ?></td>
  <td><?= $row['pesan']; ?></td>
  <td><?= $row['tgl_b']; ?></td>
  <td>
    <a href="#" class="btn btn-danger delete" data-id="<?= $row['id_kontak'] ?>"><i class="fa fa-trash"></i></a>
  </td>

</tr>
<?php } ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
             
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
        </div>
<script>
  $('#example2').on('click', '.delete', function() {
  // Dapatkan ID kategori yang akan dihapus
  const kontakId = $(this).data('id');

  // Tampilkan konfirmasi penghapusan menggunakan SweetAlert
  Swal.fire({
    title: 'Konfirmasi Penghapusan',
    text: 'Anda yakin ingin menghapus transaksi ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Lakukan permintaan AJAX untuk menghapus transaksi
      $.ajax({
        url: 'delete.php', // Ganti dengan URL yang sesuai
        method: 'POST',
        data: { id: kontakId },
        success: function(response) {
  if (response === 'success') {
    // Berhasil mengedit transaksi
   // Mengatur SweetAlert untuk ditampilkan setelah 2 detik
setTimeout(() => {
  Swal.fire({
    icon: 'success',
    title: 'Transaksi Berhasil Dihapus!',
  
    showConfirmButton: false,
    timer: 1000, // Menunggu 5 detik
    allowOutsideClick: false
  }).then(() => {
    // Menunggu 5 detik sebelum mereset ulang halaman
    setTimeout(() => {
      location.reload(); // Melakukan refresh halaman setelah 5 detik
    }, 1000);
  });
}, 1000);
  } else {
    Swal.fire({
      title: 'Gagal Menghapus transaksi',
      icon: 'error',
      showConfirmButton: false, // Menghilangkan tombol OK
      timer: 2000, // Menampilkan pesan selama 2 detik (sesuaikan sesuai kebutuhan)
      allowOutsideClick: false // Mencegah pengguna menutup pesan dengan mengklik di luar pesan
    });
  }
}
      });
    }
  });
});
</script>   

<?php

include '../view/footer_t.php' ?>