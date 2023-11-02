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
                    <th>Gender</th>
                    <th>Handphone</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Status</th>
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
$query = mysqli_query($koneksi, "SELECT * FROM users");
while ($row = mysqli_fetch_array($query)) {
?>
<tr>
  <td><?= $no++; ?></td>
  <td><?= $row['nama_user']; ?></td>
  <td><?= $row['gender']; ?></td>
  <td><?= $row['no_hp']; ?></td>
  <td><?= sensorEmail($row['email']); ?></td>

  <td><?php
        $gambarPath = "../../data/img/users/" . $row['foto']; // Path gambar sesuai dengan data dalam database
        if (file_exists($gambarPath)) {
            // Tampilkan gambar jika file gambar ada
            echo '<img src="' . $gambarPath . '" data-toggle="modal"  alt="Gambar Transaksi" data-target="#gambarModal' . $row['id_user'] . '"  width="100" height="100">';
        } else {
            // Tampilkan deskripsi jika file gambar tidak ada
            echo $row['foto'];
        }
        ?>
  </td>
  <td>
    <?php
      if ($row['status'] == 1) {
          echo 'NOT ACTIVE';
      } else {
          echo 'ACTIVE';
      }
      ?>
  </td>
  <td>
    <a href="#" class="btn btn-warning update" data-toggle="modal" data-target="#updateModal<?= $row['id_user'] ?>" data-userid="<?= $row['id_user'] ?>"><i class="fa fa-pen"></i></a>
    
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
   
<?php
$query = mysqli_query($koneksi, "SELECT * FROM users");
while ($row = mysqli_fetch_array($query)) {
?>
<div class="modal fade" id="updateModal<?= $row['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control status" name="status" style="width: 100%">
              <?php
              $statusOptions = array(
                array('value' => '1', 'label' => 'NOT ACTIVE'),
                array('value' => '2', 'label' => 'ACTIVE')
                // Tambahkan opsi lainnya jika diperlukan
              );

              $selectedStatus = $row['status']; // Ambil nilai status dari database

              foreach ($statusOptions as $option) {
                $selected = ($option['value'] == $selectedStatus) ? 'selected' : '';
                echo '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
              }
              ?>
            </select>
          </div>
          <input type="hidden" class="id_user" name="id_user" value="<?= $row['id_user'] ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary simpan">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<script>
$(document).ready(function () {
  // Event saat tombol "Simpan" diklik
  $(".simpan").on("click", function () {
    var modal = $(this).closest(".modal"); // Temukan modal yang terkait dengan tombol "Simpan"
    var idUser = modal.find(".id_user").val(); // Dapatkan nilai input 
    var status = modal.find(".status").val(); // Dapatkan nilai input

    // Kirim permintaan Ajax dengan id pengguna yang sesuai
    $.ajax({
      type: "POST",
      url: "update_akun.php", // Ganti dengan alamat file PHP yang sesuai
      data: {
        id_user: idUser, // Tambahkan id_user ke data yang dikirimkan
        status: status, // Tambahkan transaksi ke data yang dikirimkan
      },
      success: function (response) {
        if (response.includes("berhasil")) {
          Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: response,
            showConfirmButton: false,
            timer: 3000 // Menampilkan notifikasi selama 3 detik
          }).then((result) => {
            if (result.isConfirmed) {
              setTimeout(() => {
                location.reload(); // Melakukan refresh halaman setelah 3 detik
              }, 1000); // Tunggu 1 detik sebelum melakukan reload
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: response,
            showConfirmButton: false,
            timer: 2000
          });
        }
      },
      error: function (xhr, status, error) {
        // Tangani kesalahan jika permintaan Ajax gagal
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: 'Terjadi kesalahan: ' + error,
        });
      }
    });
  });
});
</script>




<?php include '../view/footer_t.php' ?>