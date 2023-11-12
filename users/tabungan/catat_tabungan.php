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
        }
    }

    echo '<p  style="color:green;">' . $total_positif . '</p>';
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
        }
    }

    $hitungan = $row['target'] - $total_negatif;
    echo '<p style="color:red;">' . $hitungan . '</p>';
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
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane"  style="max-height: 700px; overflow-y: auto;" id="activity">
                    <!-- Post -->
                    
                   <div id="aktifitas" class="post">
               </div>
             <script>
// Fungsi untuk memperbarui profil
function Aktivitas() {
    var id_users = <?= json_encode($id_users) ?>; // Ganti dengan nilai ID pengguna yang sesuai
    var id_tabungan = <?= json_encode($id_tabungan_from_url) ?>; // Ganti dengan nilai ID tabungan yang sesuai
    
    $.ajax({
        url: 'aktifitas.php',
        method: 'GET',
        data: { 
            id_users: id_users,
            id_tabungan: id_tabungan
        }, // Kirim parameter ID pengguna dan ID tabungan
        dataType: 'json',
        success: function(data) {
            $('#aktifitas').html(data.ActivityData);
        },
        error: function() {
            // Penanganan kesalahan jika terjadi
        }
    });
}

// Memanggil fungsi pembaruan setiap 1 detik
setInterval(Aktivitas, 1000);
</script>

              
                    <!-- /.post -->

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" style="max-height: 700px; overflow-y: auto;" id="timeline">
                    <!-- The timeline -->
                    <div id="alur" class="post">
               </div>
             <script>
// Fungsi untuk memperbarui profil
function Aktivitas() {
    var id_users = <?= json_encode($id_users) ?>; // Ganti dengan nilai ID pengguna yang sesuai
    var id_tabungan = <?= json_encode($id_tabungan_from_url) ?>; // Ganti dengan nilai ID tabungan yang sesuai
    
    $.ajax({
        url: 'alur.php',
        method: 'GET',
        data: { 
            id_users: id_users,
            id_tabungan: id_tabungan
        }, // Kirim parameter ID pengguna dan ID tabungan
        dataType: 'json',
        success: function(data) {
            $('#alur').html(data.AlurData);
        },
        error: function() {
            // Penanganan kesalahan jika terjadi
        }
    });
}

// Memanggil fungsi pembaruan setiap 1 detik
setInterval(Aktivitas, 1000);
</script>
                    
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <?php 
                        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
                        ?>
                        <label for="inputName" class="col-sm-2 col-form-label"><?= $currentDateTime ?></label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
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
