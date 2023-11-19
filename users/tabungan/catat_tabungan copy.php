<?php 
include "../view/header_t.php";
include "../view/navbar_t.php";
include "../view/sidebar_t.php";


// Pastikan bahwa $_GET['nama'] dan $_GET['no'] telah di-set dan bukan kosong
if (isset($_GET['nama']) && isset($_GET['no'])) {
    $id_user_from_url = $_GET['nama'];
    $id_tabungan_from_url = $_GET['no'];
    

    // Lakukan pengecekan apakah id_user dan id_tabungan sesuai
    // Gantilah kondisi ini sesuai dengan cara Anda menyimpan id_user dan id_tabungan
    $query = "SELECT * FROM tabungan WHERE id_user = '$id_user_from_url' AND id_tabungan = '$id_tabungan_from_url'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_array($result);

     

    if ($result && mysqli_num_rows($result) > 0) {
        ?>
        
        <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabungan - <?= $row['nama_tabungan'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../">Home</a></li>
              <li class="breadcrumb-item active">Target Menabung</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->

             <div id="Kontent">
  <!-- Konten Info -->
</div>
            <script>
function updateInfo() {
    var id_users = <?= $id_users ?>;
    var id_tabungan = <?= $id_tabungan_from_url ?>;
    $.ajax({
        url: 'content-tabungan.php',
        method: 'GET',
        data: { id_users: id_users, id_tabungan: id_tabungan },
        dataType: 'json',
        success: function(data) {
            $('#Kontent').html(data.konten);
            initializeKnob();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
        }
    });
}

setInterval(updateInfo, 1000);


</script>
            
            <!-- /.card -->

           <!-- Untuk Info -->
          <div id="Content">
  <!-- Konten Info -->
</div>
<script>
  // Fungsi untuk memperbarui profil
function updateInfo() {
    var id_users = <?= $id_users ?>; // Ganti dengan nilai ID pengguna yang sesuai
    var id_tabungan = <?= $id_tabungan_from_url ?>;
    $.ajax({
        url: 'content.php',
        method: 'GET',
        data: { id_users: id_users,
        id_tabungan: id_tabungan }, // Kirim parameter ID pengguna
        dataType: 'json',
        success: function(data) {
            $('#Content').html(data.konten);
        },
        error: function() {
            // Penanganan kesalahan jika terjadi
        }
    });
}
  // Memanggil fungsi pembaruan setiap 1 detik
  setInterval(updateInfo, 1000);
</script>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Aktifitas</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Alur</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tambah" data-toggle="tab"><i class='fas fa-edit'></i></a></li>
                  <li class="nav-item"><a class="nav-link" href="#pengaturan" data-toggle="tab">Pengaturan</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane"  style="max-height: 550px; overflow-y: auto;" id="activity">
                    <!-- Post -->
                    <div class="form-group">
  <label for="pilih_tipe">Pilih Tipe</label>
  <select class="form-control select2 tipe1" style="width:100%;">
    <option value="pilih">Pilih</option>
    <option value="tambah">Tambah</option>
    <option value="ubah">Ubah</option>
  </select>
</div>
<div id="aktifitas" class="post"></div>
<script>
  // Fungsi untuk memperbarui profil
  function Aktivitas() {
    var id_users = <?= json_encode($id_users) ?>; // Ganti dengan nilai ID pengguna yang sesuai
    var id_tabungan = <?= json_encode($id_tabungan_from_url) ?>; // Ganti dengan nilai ID tabungan yang sesuai
    var selectedOption = $('.tipe1').val(); // Ambil nilai yang dipilih dari select

    $.ajax({
      url: 'aktifitas.php',
      method: 'GET',
      data: {
        id_users: id_users,
        id_tabungan: id_tabungan,
        tipe_aktifitas: selectedOption // Kirim tipe aktifitas sebagai parameter
      },
      dataType: 'json',
      success: function (data) {
        $('#aktifitas').html(data.ActivityData);
      },
      error: function () {
        // Penanganan kesalahan jika terjadi
      }
    });
  }

  // Tambahkan event listener ke elemen select
  $('.tipe1').on('change', Aktivitas);

  // Memanggil fungsi pembaruan setiap 1 detik
  setInterval(Aktivitas, 1000);
</script>


              
                    <!-- /.post -->

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" style="max-height: 550px; overflow-y: auto;" id="timeline">
                    <!-- The timeline -->
                    <div class="form-group">
  <label for="pilih_tipe">Pilih Tipe</label>
  <select class="form-control select2 tipe2" style="width:100%;">
    <option value="pilih">Pilih</option>
    <option value="tambah">Tambah</option>
    <option value="ubah">Ubah</option>
  </select>
</div>
                    <div id="alur" class="post">
               </div>
             <script>
// Fungsi untuk memperbarui profil
function Alur() {
    var id_users = <?= json_encode($id_users) ?>; // Ganti dengan nilai ID pengguna yang sesuai
    var id_tabungan = <?= json_encode($id_tabungan_from_url) ?>; // Ganti dengan nilai ID tabungan yang sesuai
    var selectedOption = $('.tipe2').val(); // Ambil nilai yang dipilih dari select

    $.ajax({
      url: 'alur.php',
      method: 'GET',
      data: {
        id_users: id_users,
        id_tabungan: id_tabungan,
        tipe_alur: selectedOption // Kirim tipe alur sebagai parameter
      },
      dataType: 'json',
      success: function (data) {
        $('#alur').html(data.AlurData);
      },
      error: function () {
        // Penanganan kesalahan jika terjadi
      }
    });
  }

  // Tambahkan event listener ke elemen select
  $('.tipe2').on('change', Alur);

  // Memanggil fungsi pembaruan setiap 1 detik
  setInterval(Alur, 1000);
</script>
                    
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="tambah">
                    <form id="CatatForm" class="form-horizontal">
                      <?php 
$id_tabungan = $row['id_tabungan'];

// Query untuk mengambil data dari tabel catat_tabungan
$query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

// Inisialisasi variabel untuk menyimpan total nominal
$total_nominal = 0;

while ($catat = mysqli_fetch_assoc($query_catat)) {
    // Pisahkan tanda dan nilai
    $tanda = substr($catat['nominal'], 0, 1); // Ambil karakter pertama (tanda)
    $nilai = (int) substr($catat['nominal'], 1); // Ambil nilai setelah karakter pertama

    // Lakukan perhitungan berdasarkan tanda
    if ($tanda === '+') {
        $total_nominal += $nilai;
    } elseif ($tanda === '-') {
        $total_nominal -= $nilai;
    }
}

// Hitung sisa target
$sisa_target = max(0, $row['target'] - $total_nominal);

// Hitung estimasi waktu
$estimasi_waktu = floor($sisa_target / $row['nominal']); // Menggunakan floor untuk membulatkan ke bawah
echo '<input type="hidden" class="form-control" name="estimasi" value="'.$estimasi_waktu.'" id="estimasi">';
?>
                      <input type="hidden" class="form-control" name="nomor" value="<?= $id_users ?>" id="nomor">
                      <input type="hidden" class="form-control" name="nama" value="<?= $id_tabungan_from_url ?>" id="nama">
                      <div class="form-group row">
                        <label for="nama_catat" class="col-sm-2 col-form-label">Nama Catat</label>
                        <div class="col-sm-10">
                           <input type="text" readonly value="Tambah" class="form-control tipe" name="tipe">
                         
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="noninal" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="nominal" id="nominal" placeholder="Nominal">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </div>
                    </form>
                    <hr>
                    <?php 
          $query_catat_edit = mysqli_query($koneksi, "SELECT * FROM catat_tabungan");
          while($c = mysqli_fetch_array($query_catat_edit)) {
                    ?>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop<?= $c['id_catat'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Catat Tabungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="EditCatat" method="post">
  <input type="text" class="form-control id_catat_tabungan" name="id_catat_tabungan"  value="<?= $c['id_catat'] ?>">
  <input type="text" class="form-control id_users_catat" name="id_users_catat"  value="<?= $id_users ?>">
  <input type="text" class="form-control nomor_tabungan" name="nomor_tabungan" value="<?= $id_tabungan_from_url ?>">

          <div class="mb-3">
  <label for="nomor_nominal" class="form-label">Nominal</label>
  <input type="number" class="form-control nomor_nominal" name="nomor_nominal" value="<?= abs($c['nominal']) ?>" id="nomor_nominal" placeholder="Masukkan Nonimal">
</div>
<div class="mb-3">
  <label for="keterangan_catat" class="form-label">Keterangan</label>
  <textarea class="form-control keterangan_catat" id="keterangan_catat" placeholder="Masukkan Keterangan" rows="3"><?= $c['keterangan'] ?></textarea>
</div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Ubah</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>
 <div id="catat-tabungan" style="max-height: 450px; overflow-y: auto;" class="row"></div>
                    <script>
$(document).ready(function() {
  function loadData(containerId) {
  var IDTabungan = <?= $id_tabungan_from_url ?>; // Ambil id_tabungan dari PHP dan sisipkan ke dalam JavaScript

  // Lakukan permintaan AJAX untuk mengambil data kategori, termasuk id_tabungan
  $.ajax({
    url: 'get_data.php',
    method: 'GET',
    data: {
      id_tabungan: IDTabungan,
    },
    success: function(data) {
      $('#' + containerId).html(data);
    }
  });
}

// Load data for "Pemasukan" and "Pengeluaran" initially
loadData("catat-tabungan");
// Atur penyegaran setiap 3 detik (3000 milidetik) untuk data "Pemasukan" dan "Pengeluaran"
setInterval(function() {
  loadData("catat-tabungan");
}, 1000);



 // Edit data
$('.EditCatat').on('submit', function(e) {
    e.preventDefault(); // Menghentikan tindakan default submit form

   const ID_catat_tabungan = $('.id_catat_tabungan').val();
const ID_users_catat = $('.id_users_catat').val();
const Nomor_tabungan = $('.nomor_tabungan').val();
const Nomor_nominal = $('.nomor_nominal').val();
const Keterangan_catat = $('.keterangan_catat').val();

// Buat objek FormData untuk mengirim data dalam bentuk form
const formData = new FormData();
formData.append('id', ID_catat_tabungan); // Perbaiki nama variabel
formData.append('nomor_user', ID_users_catat); // Perbaiki nama variabel
formData.append('id_tabungan', Nomor_tabungan);
formData.append('nomor_nominal', Nomor_nominal);
formData.append('keterangan_catat', Keterangan_catat);


    $.ajax({
        type: "POST",
        url: "edit_catat.php", // Sesuaikan dengan URL yang sesuai
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.includes("berhasil")) {
              // Mengatur SweetAlert untuk ditampilkan setelah 2 detik
setTimeout(() => {
  Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: response,
    showConfirmButton: false,
    timer: 2000, // Menunggu 5 detik
    allowOutsideClick: false
  })
}, 
);
            
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
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Terjadi kesalahan: ' + error,
            });
        }
    });
});





// Tambahkan event handler untuk tombol "Delete"
$('#catat-tabungan').on('click', '.delete-category', function() {
  // Dapatkan ID kategori yang akan dihapus
  const categoryId = $(this).data('id');

  // Tampilkan konfirmasi penghapusan menggunakan SweetAlert
  Swal.fire({
    title: 'Konfirmasi Penghapusan',
    text: 'Anda yakin ingin menghapus kategori ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Lakukan permintaan AJAX untuk menghapus kategori
      $.ajax({
        url: 'delete_pengeluaran.php', // Ganti dengan URL yang sesuai
        method: 'POST',
        data: { id: categoryId },
        success: function(response) {
  if (response === 'success') {
    // Berhasil mengedit kategori
    Swal.fire({
      title: 'Kategori Telah Dihapus!',
      icon: 'success',
      showConfirmButton: false, // Menghilangkan tombol OK
      timer: 2000, // Menampilkan pesan selama 2 detik (sesuaikan sesuai kebutuhan)
      allowOutsideClick: false // Mencegah pengguna menutup pesan dengan mengklik di luar pesan
    });
    loadCategories(); // Muat ulang data kategori setelah mengedit
  } else {
    Swal.fire({
      title: 'Gagal Menghapus Kategori',
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

});
</script>
                  
                <!-- /.tab-content -->
              </div><!-- /.card-body -->

              <div class="tab-pane" id="pengaturan">
                    <form id="TabunganForm" class="TabunganForm" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control"  name="user_id" id="user_id"  value="<?= $id_users ?>">
                                <input type="hidden" class="form-control"  name="id" id="id"  value="<?= $row['id_tabungan'] ?>">
                                <div class="row">
                                <div class="col-sm-6">

                                <div class="form-group">
                                <label for="nama_tabungan">Nama Tabungan</label>
                                <input type="text" class="form-control" value="<?= $row['nama_tabungan'] ?>"  name="nama_tabungan" id="nama_tabungan" placeholder="Masukkan Nama Tabungan">
                            </div>

                            <div class="form-group">
                                <label for="target_tabungan">Target Tabungan</label>
                                <input type="number" class="form-control" value="<?= $row['target'] ?>" name="target_tabungan" id="target_tabungan" placeholder="Masukkan Nama Tabungan">
                            </div>

                            </div>

                            <div class="col-sm-6">
                               <div class="form-group">
                  <label for="rencana_pengisian">Rencana Pengisian</label>
                  <select class="form-control select2" name="rencana_pengisian" id="rencana_pengisian" style="width: 100%;">
                    <option value="Harian" <?= $row['rencana'] == 'Harian' ? 'selected' : '' ?>>Harian</option>
                    <option value="Mingguan" <?= $row['rencana'] == 'Mingguan' ? 'selected' : '' ?>>Mingguan</option>
                    <option value="Bulanan" <?= $row['rencana'] == 'Bulanan' ? 'selected' : '' ?>>Bulanan</option>
                  </select>
                </div>
                  
               <div class="form-group">
    <label for="nominal_pengisian">Nominal Pengisian</label>
    <div class="input-group">
        <input type="number" name="nominal_pengisian" value="<?= $row['nominal'] ?>" id="nominal_pengisian" class="form-control">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>
    </div>
</div>


                            </div>
                            </div>


                             <div class="form-group">
                                <label for="fileInput">Gambar</label>
                                <input type="file" class="form-control"  name="fileInput" id="fileInput" accept=".jpg, .jpeg, .png"  placeholder="Masukkan Nama Tabungan">
                            </div>
                            <div class="text-center">
<img id="imageValidationMessage" src="../../data/img/tabungan/<?= $row['gambar'] ?>" style="max-width: 300px; max-height: 300px;">
</div>

                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                           <button type="button" class="btn btn-danger mt-3 delete-tabungan" data-id="<?= $row['id_tabungan'] ?>">Hapus Tabungan</button>

                        </form>

                        <script>

                          $(document).ready(function() {

// Tambahkan event handler untuk tombol "Delete"
$('#TabunganForm').on('click', '.delete-tabungan', function() {
  // Dapatkan ID kategori yang akan dihapus
  const id_tabungan = $(this).data('id');

  // Tampilkan konfirmasi penghapusan menggunakan SweetAlert
  Swal.fire({
    title: 'Konfirmasi Penghapusan',
    text: 'Anda yakin ingin menghapus tabungan ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Lakukan permintaan AJAX untuk menghapus tabungan
      $.ajax({
        url: 'delete_tabungan.php', // Ganti dengan URL yang sesuai
        method: 'POST',
        data: { id: id_tabungan },
        success: function(response) {
  if (response === 'success') {
    // Berhasil mengedit tabungan
    setTimeout(() => {
    Swal.fire({
      title: 'Tabungan Telah Dihapus!',
      icon: 'success',
      showConfirmButton: false, // Menghilangkan tombol OK
      timer: 2000, // Menampilkan pesan selama 2 detik (sesuaikan sesuai kebutuhan)
      allowOutsideClick: false // Mencegah pengguna menutup pesan dengan mengklik di luar pesan
    }).then(() => {
    // Menunggu 5 detik sebelum mereset ulang halaman
    setTimeout(() => {
     location.href = 'tabungan.php';
    }, 1000);
  });
}, 1000);
  } else {
    Swal.fire({
      title: 'Gagal Menghapus Tabungan',
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

});

                           // Merekam perubahan pada input file
document.getElementById('fileInput').addEventListener('change', function() {
    // Menampilkan fileInput yang dipilih
    var previewImage = document.getElementById('imageValidationMessage');
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        previewImage.src = e.target.result;
    };

    reader.readAsDataURL(file);
});

$('#TabunganForm').on('submit', function(e) {
    e.preventDefault(); // Menghentikan tindakan default submit form

    const userId = $('#user_id').val();
    const ID = $('#id').val();
    const tabungan = $('#nama_tabungan').val();
    const target_tabungan = $('#target_tabungan').val();
    const rencana = $('#rencana_pengisian').val();
    const nominal = $('#nominal_pengisian').val();
    const fileInput = $('#fileInput')[0].files[0];

    // Buat objek FormData untuk mengirim data dalam bentuk form
    const formData = new FormData();
    formData.append('id', ID);
    formData.append('id_user', userId);
    formData.append('nama_tabungan', tabungan);
    formData.append('target_tabungan', target_tabungan);
    formData.append('rencana_pengisian', rencana);
    formData.append('nominal_pengisian', nominal);
    formData.append('fileInput', fileInput);

    $.ajax({
        type: "POST",
        url: "update-tabungan.php", // Sesuaikan dengan URL yang sesuai
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.includes("berhasil")) {
                   // Mengatur SweetAlert untuk ditampilkan setelah 2 detik
setTimeout(() => {
  Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: response,
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
                    icon: 'error',
                    title: 'Gagal',
                    text: response,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Terjadi kesalahan: ' + error,
            });
        }
    });
});
                        </script>
                    <hr>
                <!-- /.tab-content -->
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<script>
  $(document).ready(function () {
   // Event saat tombol "Simpan" diklik
    $("#CatatForm").on("submit", function (e) {
  e.preventDefault(); 
        var estimasi = $("#estimasi").val(); 
        var id_tabungan = $("#nama").val(); 
        var idUsers = $("#nomor").val(); 
          var tipe = $(".tipe").val(); 
        var nominal = $("#nominal").val(); 
        var keterangan = $("#keterangan").val(); 
        // Kirim permintaan Ajax

        if (tipe === "") {
            console.log("Tipe harus diisi.");
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Tipe harus diisi.',
                showConfirmButton: false,
                timer: 2000
            });
        } else if (nominal === "") {
            console.log("Nominal harus diisi.");
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Nominal harus diisi.',
                showConfirmButton: false,
                timer: 2000
            });
        } else {
        $.ajax({
            type: "POST",
            url: "aksi_catat.php", // Ganti dengan alamat file PHP yang sesuai
            data: {
                id_tabungan: id_tabungan, // Tambahkan id_tabungan ke data yang dikirimkan
                estimasi: estimasi, // Tambahkan estimasi ke data yang dikirimkan
                id_user: idUsers, // Tambahkan id_user ke data yang dikirimkan
                  tipe: tipe, // Tambahkan tipe ke data yang dikirimkan
                nominal: nominal,
                keterangan: keterangan
            },
            success: function (response) {
            if (response.includes("berhasil")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: response,
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Anda bisa mengosongkan input atau menutup modal jika berhasil
                        $("#nama").val("");
                        $("#modal-lg").modal("hide");

                       
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
  }
});
});
</script>




   
  <?php 
            $query_t = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE id_user = $id_users");
            while($tabungan = mysqli_fetch_array($query_t)) {
            ?>
              <!-- Modal -->
<div class="modal fade" id="gambarModal_t<?= $tabungan['id_tabungan'] ?>" tabindex="-1" role="dialog" aria-labelledby="gambarModalLabel<?= $tabungan['id_tabungan'] ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="gambarModalLabel<?= $tabungan['id_tabungan'] ?>">Gambar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <?php
        $gambarPath = "../../data/img/tabungan/" . $tabungan['gambar']; // Path gambar sesuai dengan data dalam database
            if (empty($tabungan['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                $gambarPath = "../dist/img/galeri.png";
            }
            // Tampilkan gambar jika file gambar ada
            echo '<img src="' . $gambarPath . '" alt="Gambar Tabungan" "  width="100%" height="auto">';
        ?>
        
      </div>
      <div class="modal-footer">
        <?php
        $gambarPath = "../../data/img/tabungan/" . $tabungan['gambar']; // Path gambar sesuai dengan data dalam database
        if (empty($tabungan['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                echo '<a href="../../data/img/tabungan/'. $tabungan['gambar'] .'" style="display:none;" download title="Download Gambar" class="btn btn-success"><i class="fas fa-download"></i> Download</a>';
            } else {
              echo '<a href="../../data/img/tabungan/'. $tabungan['gambar'] .'" download title="Download Gambar" class="btn btn-success"><i class="fas fa-download"></i> Download</a>';
            }
        ?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
      

    <?php 
    } else {
        // Tidak sesuai, redirect ke halaman yang sesuai
        $_SESSION['gagal'] = 'Opps, Anda Gagal!';
        echo '<script>window.location.href = "tabungan.php";</script>';
    }
} else {
    // Parameter tidak lengkap, redirect ke halaman yang sesuai
    $_SESSION['gagal'] = 'Opps, Anda Gagal!';
    echo '<script>window.location.href = "tabungan.php";</script>';
}
include "../view/footer_t.php";
?>
