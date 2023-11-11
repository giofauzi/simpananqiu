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
    <h3 class="profile-username"><?= $formatTarget ?></h3>
    <div style="margin-bottom:-13px;">   
    <?php 
$id_tabungan = $row['id_tabungan'];

// Query untuk menghitung total nominal pada tabel catat_tabungan
$query_catat = mysqli_query($koneksi, "SELECT SUM(nominal) AS total_nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");
$catat = mysqli_fetch_array($query_catat);

if ($catat) {
    // Data catat_tabungan ditemukan
    $total_nominal = $catat['total_nominal'];
    $hitung_persen = min(($total_nominal / $row['target']) * 100, 100); // Persen tidak boleh lebih dari 100

    // Tampilkan input knob dengan nilai persen progres
   echo '<input type="text" class="knob" value="'.number_format($hitung_persen, 0, '', '').'" data-width="60" data-height="60" data-fgColor="#3c8dbc">';

} else {
    // Data catat_tabungan tidak ditemukan, progres 0%
    echo '<input type="text" class="knob" value="0" data-width="60" data-height="60" data-fgColor="#3c8dbc">';
}
?>

    </div>
                    
</div>
<?php
$formatUang = 'Rp' . number_format($row['nominal'], 2, ',', '.');
if($row['rencana'] === 'Harian') {
 echo '<p class="text-muted" style="margin-top:-20px;">'.$formatUang.' Perhari</p>';
} else if($row['rencana'] === 'Mingguan') {
  echo '<p class="text-muted" style="margin-top:-20px;">'.$formatUang.' Perminggu</p>';
} else if($row['rencana'] === 'Bulanan') {
  echo '<p class="text-muted" style="margin-top:-20px;">'.$formatUang.' Perbulan</p>';
}
?>
    


                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Tanggal Dibuat</b> <a class="float-right"><?=  date('d F Y H.i', strtotime($row['tgl_b'])) ?></a>
                  </li>
                  <li class="list-group-item">
                    <?php 
                    $id_tabungan = $row['id_tabungan'];
            // ...
$query_catat = mysqli_query($koneksi, "SELECT id_tabungan, SUM(nominal) AS total_nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan GROUP BY id_tabungan");
$catat = mysqli_fetch_array($query_catat);

if ($catat) {
    // Data catat_tabungan ditemukan
    $hitungan = $row['target'] - $catat['total_nominal'];
    $hitung = floor($hitungan / $row['nominal']); // Menggunakan floor untuk membulatkan ke bawah

    // Tampilkan data sesuai kebutuhan
   
    if ($row['rencana'] === 'Harian') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung . ' Hari Lagi</a>';
    } elseif ($row['rencana'] === 'Mingguan') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung . ' Minggu Lagi</a>';
    } elseif ($row['rencana'] === 'Bulanan') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung . ' Bulan Lagi</a>';
    }
   
} else {
    // Data catat_tabungan tidak ditemukan
    $hitung_a = floor($row['target'] / $row['nominal']); // Menggunakan floor untuk membulatkan ke bawah
   
    if ($row['rencana'] === 'Harian') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung_a . ' Hari Lagi</a>';
    } elseif ($row['rencana'] === 'Mingguan') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung_a . ' Minggu Lagi</a>';
    } elseif ($row['rencana'] === 'Bulanan') {
        echo '<b>Estimasi</b> <a class="float-right">' . $hitung_a . ' Bulan Lagi</a>';
    }
 
}
// ...
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
$query_catat = mysqli_query($koneksi, "SELECT id_tabungan, SUM(nominal) AS total_nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan GROUP BY id_tabungan");
$catat = mysqli_fetch_array($query_catat);
if ($catat) {
$hitungan = $row['target'] - $catat['total_nominal'];
echo ' <p class="text-muted">'.$hitungan.'</p>';
} else {
echo ' <p class="text-muted">0</p>';

}
                  ?>
              

                <hr>

                <strong><i class="fas fa-arrow-down mr-1" style="color:red;"></i> Kekurangan</strong>

                <p class="text-muted"></p>

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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - 5 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                              <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                              <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
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
