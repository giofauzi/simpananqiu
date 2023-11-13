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
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php
                  $gambarPath = "../../data/img/tabungan/" . $row['gambar']; // Path gambar sesuai dengan data dalam database
            if (empty($row['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                $gambarPath = "../dist/img/galeri.png";
            }

            echo '<a href="#" data-toggle="modal" title="Klik Gambar" class="edit-modal modal-gambar" data-target="#gambarModal_t'.$row['id_tabungan'].'">
            <img style="width:250px;height:250px;border-radius:20px;margin-bottom:5px;"
                 src="'.$gambarPath.'"
                 alt="Gambar Tabungan">
                 </a>';
                 ?>
                </div>
                <?php 
               $formatTarget = 'Rp' . number_format($row['target'], 2, ',', '.');
                ?>
                <div class="profile-info">
    <h3 class="profile-username text-bold"><?= $formatTarget ?></h3>
    <div style="margin-bottom:-13px;">   
   <?php 
$id_tabungan = $row['id_tabungan'];

// Query untuk mengambil data dari tabel catat_tabungan
$query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

// Inisialisasi variabel untuk menyimpan total nominal positif dan negatif
$total_positif = 0;
$total_negatif = 0;

while ($catat = mysqli_fetch_assoc($query_catat)) {
    // Pisahkan tanda dan nilai
    $tanda = substr($catat['nominal'], 0, 1); // Ambil karakter pertama (tanda)
    $nilai = (int) substr($catat['nominal'], 1); // Ambil nilai setelah karakter pertama

    // Lakukan perhitungan berdasarkan tanda
    if ($tanda === '+') {
        $total_positif += $nilai;
    } elseif ($tanda === '-') {
        $total_negatif += $nilai;
    }
}

// Hitung total nominal
$total_nominal = $total_positif - $total_negatif;

// Hitung persentase progres
$hitung_persen = min(($total_nominal / $row['target']) * 100, 100); // Persen tidak boleh lebih dari 100

// Tampilkan input knob dengan nilai persen progres
echo '<input type="text" class="knob" value="'.number_format($hitung_persen, 0, '', '').'" data-width="60" data-height="60" data-fgColor="#3c8dbc">';
?>


    </div>            
</div>
<?php
$formatUang = 'Rp' . number_format($row['nominal'], 2, ',', '.');
if($row['rencana'] === 'Harian') {
 echo '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perhari</p>';
} else if($row['rencana'] === 'Mingguan') {
  echo '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perminggu</p>';
} else if($row['rencana'] === 'Bulanan') {
  echo '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perbulan</p>';
}
?>
    


                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Tanggal Dibuat</b> <a class="float-right" style="color:black;"><?=  date('d F Y H.i', strtotime($row['tgl_b'])) ?></a>
                  </li>
                  <li class="list-group-item">
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

// Tampilkan data sesuai kebutuhan
if ($row['rencana'] === 'Harian') {
    echo '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Hari Lagi</a>';
} elseif ($row['rencana'] === 'Mingguan') {
    echo '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Minggu Lagi</a>';
} elseif ($row['rencana'] === 'Bulanan') {
    echo '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Bulan Lagi</a>';
}
?>

                   
                  </li>
                  
                </ul>

               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Kondisi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
    <strong><i class="fas fa-arrow-up mr-1" style="color:green"></i> Terkumpul</strong>

    <?php
    $id_tabungan = $row['id_tabungan'];
    $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

    // Inisialisasi variabel untuk menyimpan total nominal positif
    $total_positif = 0;

    while ($catat = mysqli_fetch_assoc($query_catat)) {
        // Pisahkan tanda dan nilai
        $tanda = substr($catat['nominal'], 0, 1); // Ambil karakter pertama (tanda)
        $nilai = (int) substr($catat['nominal'], 1); // Ambil nilai setelah karakter pertama

        // Lakukan perhitungan berdasarkan tanda
        if ($tanda === '+') {
            $total_positif += $nilai;
        } else if($tanda === '-') {
          $total_positif -= $nilai;
        }
    }

    $format ='Rp '. number_format($total_positif,2,'.',',');
    echo '<p  style="color:green;">' . $format . '</p>';
    ?>

    <hr>

    <strong><i class="fas fa-arrow-down mr-1" style="color:red;"></i> Kekurangan</strong>

    <?php
    $id_tabungan = $row['id_tabungan'];
    $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

    // Inisialisasi variabel untuk menyimpan total nominal negatif
    $total_negatif = 0;

    while ($catat = mysqli_fetch_assoc($query_catat)) {
        // Pisahkan tanda dan nilai
        $tanda = substr($catat['nominal'], 0, 1); // Ambil karakter pertama (tanda)
        $nilai = (int) substr($catat['nominal'], 1); // Ambil nilai setelah karakter pertama

        // Lakukan perhitungan berdasarkan tanda
        if ($tanda === '+') {
            $total_negatif += $nilai;
        } else if($tanda === '-') {
          $total_negatif -= $nilai;
        }
    }

    $hitungan = $row['target'] - $total_negatif;
    $format ='Rp '. number_format($hitungan, 2, '.', ',');
    echo '<p style="color:red;"> ' . $format . '</p>';
    ?>

    <hr>
</div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Aktifitas</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Alur</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab"><i class='fas fa-edit'></i></a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane"  style="max-height: 700px; overflow-y: auto;" id="activity">
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
                  <div class="tab-pane" style="max-height: 700px; overflow-y: auto;" id="timeline">
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

                  <div class="tab-pane" id="settings">
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
                          <select class="form-control select2 tipe" name="tipe" style="width:100%;">
    <option value="">Pilih</option>
    <option value="tambah">Tambah</option>
    <option value="kurangi">Kurangi</option>
  </select>
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
                          <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
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
