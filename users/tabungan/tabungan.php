   <?php 
include "../view/header_t.php";
?>

  <?php 
include "../view/navbar_t.php";
?>

<?php 
include "../view/sidebar_t.php";
?>


 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Menabung</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Kategori</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item" id="kategoriTab" style="display: none;">
        <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Kategori</a>
    </li>
  
</ul>

        <div class="row">
          <div class="col-12">
            
            <div class="card">
              
              <div class="card-header">
                 <div class="row">
                <h3 class="card-title">Data Kategori</h3>
                    </div>
                <div class="row mt-2">
                    <div class="col-1" style="margin-bottom:-50px;">
                
                     <a class="btn btn-app" id="tombol" onclick="showTabAndHideButton('custom-tabs-four-home')">
                            <i class="fas fa-plus"></i> Plus
                        </a>
              </div>
              </div>
             <script>
    function showTabAndHideButton(tabId) {
        // Menampilkan tab yang diklik
        $(`#custom-tabs-four-tab a[href="#${tabId}"]`).tab("show");
        
        // Menghilangkan tombol "Plus"
        document.getElementById("tombol").style.display = "none";
        
        
        // Menampilkan elemen "Kategori" dan "Pengeluaran"
        document.getElementById("kategoriTab").style.display = "block";
        document.getElementById("custom-tabs-four-tabContent").style.display = "block";
        document.getElementById("pengeluaranTab").style.display = "block";
    }

       function hide(tabId) {
        // Menampilkan tab yang diklik
        $(`#custom-tabs-four-tab a[href="#${tabId}"]`).tab("show");
        
        // Menghilangkan tombol "Plus"
        document.getElementById("tombol1").style.display = "none";
        
        
        // Menampilkan elemen "Kategori" dan "Pengeluaran"
        document.getElementById("kategoriTab").style.display = "block";
        document.getElementById("custom-tabs-four-tabContent").style.display = "block";
        document.getElementById("pengeluaranTab").style.display = "block";
    }

    function muncul(tabId) {
        // Menampilkan tab yang diklik
        $(`#custom-tabs-four-tab a[href="#${tabId}"]`).tab("show");
        
        // Menghilangkan tombol "Plus"
        document.getElementById("tombol").style.display = "block";
        
        
        // Menampilkan elemen "Kategori" dan "Pengeluaran"
        document.getElementById("kategoriTab").style.display = "none";
        document.getElementById("custom-tabs-four-tabContent").style.display = "none";
        document.getElementById("pengeluaranTab").style.display = "none";
    }

    function kembali(tabId) {
        // Menampilkan tab yang diklik
        $(`#custom-tabs-four-tab a[href="#${tabId}"]`).tab("show");
        
        // Menghilangkan tombol "Plus"
        document.getElementById("tombol1").style.display = "block";
        
        
        // Menampilkan elemen "Kategori" dan "Pengeluaran"
        document.getElementById("kategoriTab").style.display = "none";
        document.getElementById("custom-tabs-four-tabContent").style.display = "none";
        document.getElementById("pengeluaranTab").style.display = "none";
    }
</script>

              <div class="card-body">

                 <div class="tab-content" id="custom-tabs-four-tabContent" style="display: none;">
                  <div class="tab-pane fade show active" id="custom-tabs-four-home"  role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                    

                    <!-- Form -->
 <form id="TabunganForm" class="Kategori">
                                <input type="hidden" class="form-control" required name="user_id" id="user_id"  value="<?= $id_users ?>">
                                

                                <div class="row">
                                <div class="col-sm-6">

                                <div class="form-group">
                                <label for="nama_tabungan">Nama Tabungan</label>
                                <input type="text" class="form-control" required name="nama_tabungan" id="nama_tabungan" placeholder="Masukkan Nama Tabungan">
                            </div>

                            <div class="form-group">
                                <label for="target_tabungan">Target Tabungan</label>
                                <input type="number" class="form-control" required name="target_tabungan" id="target_tabungan" placeholder="Masukkan Nama Tabungan">
                            </div>

                           
                            

                            </div>

                            <div class="col-sm-6">
                               <div class="form-group">
                  <label for="rencana_pengisian">Rencana Pengisian</label>
                  <select class="form-control select2" name="rencana_pengisian" id="rencana_pengisian" style="width: 100%;">
                    <option value="Harian">Harian</option>
                    <option value="Mingguan">Mingguan</option>
                    <option value="Bulanan">Bulanan</option>
                  </select>
                </div>
                  
               <div class="form-group">
    <label for="nominal_pengisian">Nominal Pengisian</label>
    <div class="input-group">
        <input type="number" name="nominal_pengisian" id="nominal_pengisian" class="form-control">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>
    </div>
</div>


                            </div>
                            </div>


                             <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <input type="file" class="form-control" required name="gambar" id="gambar" accept=".jpg, .jpeg, .png" id="gambar" placeholder="Masukkan Nama Tabungan">
                            </div>
                            <div class="text-center">
<img id="imageValidationMessage" src="../dist/img/galeri.png" style="max-width: 300px; max-height: 300px;">
</div>

                            <button type="button" id="SimpanTabungan" class="btn btn-primary mt-3">Simpan</button>
                           <button type="button" class="btn btn-success mt-3" id="tombolKembali">Kembali</button>

                        </form>
                        
<script>


 // Merekam perubahan pada input file
document.getElementById('gambar').addEventListener('change', function() {
    // Menampilkan gambar yang dipilih
    var previewImage = document.getElementById('imageValidationMessage');
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        previewImage.src = e.target.result;
    };

    reader.readAsDataURL(file);
});


// Fungsi untuk mengosongkan isian formulir
function resetForm() {
    document.querySelector(".Kategori").reset();
}


// Fungsi untuk perangkat handphone
function kembaliHandphone(target) {
    // Tambahkan kode yang ingin Anda jalankan untuk perangkat handphone di sini
    resetForm(); // Mengosongkan isian formulir
    kembali();
}

// Fungsi untuk perangkat laptop
function kembaliLaptop(target) {
    // Tambahkan kode yang ingin Anda jalankan untuk perangkat laptop di sini
    resetForm(); // Mengosongkan isian formulir
    muncul();
}

// Periksa jenis perangkat dan atur fungsi onclick sesuai kebutuhan
if (window.innerWidth <= 768) {
    document.getElementById('tombolKembali').onclick = function() {
        kembaliHandphone('custom-tabs-four-home');
    };
} else {
    document.getElementById('tombolKembali').onclick = function() {
        kembaliLaptop('custom-tabs-four-home');
    };
}


  $(document).ready(function () {
   // Event saat tombol "Simpan" diklik
     $("#SimpanTabungan").on("click", function () {
        var idUsers = $("#user_id").val(); // Dapatkan nilai input id_user
         var nama_tabungan = $("#nama_tabungan").val(); // Dapatkan nilai input nama_tabungan
          var target_tabungan = $("#target_tabungan").val(); // Dapatkan nilai input target_tabungan
        var rencana_pengisian = $("#rencana_pengisian").val(); // Dapatkan nilai input Rencana Pengisian
        var nominal_pengisian = $("#nominal_pengisian").val(); // Dapatkan nilai input Nominal Pengisian
        var gambar = $('#gambar')[0].files[0];
        // Kirim permintaan Ajax
        $.ajax({
            type: "POST",
            url: "aksi.php", // Ganti dengan alamat file PHP yang sesuai
            data: {
                id_user: idUsers, // Tambahkan id_user ke data yang dikirimkan
                nama_tabungan: nama_tabungan, // Tambahkan nama_tabungan ke data yang dikirimkan
                  target_tabungan: target_tabungan, // Tambahkan target_tabungan ke data yang dikirimkan
                rencana_pengisian: rencana_pengisian,//Tambahkan rencana pengisian
                nominal_pengisian: nominal_pengisian, //Tambahkan nominal pengisian
                gambar: gambar //Tambahkan gambar
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
});
});


</script>

                <!-- /.form group -->
                  </div>
                </div>
          

              </div>
              </div>
              <!-- /.card-header -->
            
               
<script>
$(document).ready(function() {
  function loadData(transaksi, containerId) {
  var idUsers = <?= $id_users ?>; // Ambil id_users dari PHP dan sisipkan ke dalam JavaScript

  // Lakukan permintaan AJAX untuk mengambil data kategori, termasuk id_users
  $.ajax({
    url: 'muncul_kategori.php',
    method: 'GET',
    data: {
      id_users: idUsers,
      transaksi: transaksi,
    },
    success: function(data) {
      $('#' + containerId).html(data);
    }
  });
}

// Load data for "Pemasukan" and "Pengeluaran" initially
loadData("Pemasukan", "pemasukan-container");
loadData("Pengeluaran", "pengeluaran-container");

// Atur penyegaran setiap 3 detik (3000 milidetik) untuk data "Pemasukan" dan "Pengeluaran"
setInterval(function() {
  loadData("Pemasukan", "pemasukan-container");
  loadData("Pengeluaran", "pengeluaran-container");
}, 3000);





  $('#pemasukan-container,  #pengeluaran-container').on('click', '.edit-category', function() {
  const categoryId = $(this).closest('.card-body').find('.nama_kategori').data('id');
  const categoryName = $(this).closest('.card-body').find('.nama_kategori').text();
  const transaksi = $(this).closest('.card-body').find('.transaksi').text();
  const id_admin = $(this).closest('.card-body').find('.id_admin').text();

  Swal.fire({
    title: 'Edit Kategori',
    html: `<div class="form-group">
      <label for="nama_kategori">Nama Kategori</label>
      <input type="text" class="form-control" required name="nama" id="nama_kategori" placeholder="Masukkan Nama Kategori" value="${categoryName}">
      <input type="hidden" class="form-control" required name="id_users" id="id_user" value="<?= $id_users ?>">
      <input type="hidden" class="form-control" required name="id_admin" id="id_admin" value="${id_admin}">
    </div>
    <div class="form-group">
      <label for="transaksi_kategori">Jenis Transaksi</label>
      <select class="form-control" name="transaksi_kategori" id="transaksi_kategori" style="width: 100%"></select>
    </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Simpan',
    cancelButtonText: 'Batal',
    didOpen: () => {
      // Buat opsi-opsi untuk elemen select
      const selectOptions = ['Pemasukan', 'Pengeluaran'];

      // Perbarui select box berdasarkan nilai transaksi yang diperoleh
      selectOptions.forEach((option) => {
        const isSelected = option === transaksi ? 'selected' : '';
        $('#transaksi_kategori').append(`<option value="${option}" ${isSelected}>${option}</option>`);
      });
    },
  }).then((result) => {
    if (result.isConfirmed) {
      const editedCategoryName = $('#nama_kategori').val();
      const editIdUser = $('#id_user').val();
      const transaksi_kategori = $('#transaksi_kategori').val();
      const id_admin = $('#id_admin').val();

      $.ajax({
    url: 'edit.php',
    method: 'POST',
    data: {
        id: categoryId,
        id_users: editIdUser,
        nama: editedCategoryName,
        transaksi_kategori: transaksi_kategori,
        id_admin: id_admin,
    },
    dataType: 'json', // Mengharapkan respons dalam format JSON
    success: function(response) {
        if (response.status === 'success') {
            Swal.fire({
                title: 'Kategori Telah Diedit',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                allowOutsideClick: false,
            });
            loadCategories();
        } else if (response.status === 'error') {
            Swal.fire({
                title: 'Gagal Mengedit Kategori',
                text: response.message.join('<br>'), // Menampilkan pesan kesalahan dalam bentuk daftar
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
                allowOutsideClick: false,
            });
        }
    },
});

    }
  });
});





// Tambahkan event handler untuk tombol "Delete"
$('#pengeluaran-container, #pemasukan-container').on('click', '.delete-category', function() {
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

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
 <div style="margin-top:-10px">
              <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Kategori</h3></li>
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Pemasukan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Pengeluaran</a>
                  </li>
                </ul>
              </div>
              <div class="card-body" style="max-height: 700px; overflow-y: auto;">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                    <div id="pemasukan-container" class="row"></div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                    <div id="pengeluaran-container" class="row"></div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            </div>
           
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <?php 
include "../view/footer_t.php";
?>