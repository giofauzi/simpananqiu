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
            <h1>Transaksi</h1>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                 <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                 <div class="row">
                <h3 class="card-title">Transaksi</h3>
                    </div>
                <div class="row mt-2">
                    <div class="col-1">
                
                    <a class="btn btn-app" id="tombol" data-toggle="modal" data-target="#modal-lg">
                  <i class="fas fa-plus"></i> Plus
                </a>
              </div>
              </div>
              
               </div>
              <!-- /.card-header -->
             

  
              <div class="card-body">
                <div class="container-fluid ">
               <div class="row">
               <div class="col-lg-4 col-sm-4 ">
 <?php
$query = mysqli_query($koneksi, "SELECT id_user, nama_keuangan, SUM(total) as total_keuangan FROM keuangan WHERE id_user = '$id_users' AND nama_keuangan = 'Pemasukan'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
   $total_keuangan = 'Rp ' . number_format($row['total_keuangan'], 2, ',', '.');
?>
    <p style="margin-bottom:-5px;text-align:center;font-weight:bold;">Pemasukan</p>
    <?php
    if ($total_keuangan !== NULL) {
        echo '<p  style="color:blue;text-align:center;">' . $total_keuangan . '</p>';
    } else {
        echo '<p  style="color:blue;text-align:center;">0</p>';
    }
    ?>
<?php
} else {
    echo "Tidak ada data yang sesuai dengan kriteria.";
}
?>

</div>

                <div class="col-lg-4 col-sm-4">
                  <?php
$query = mysqli_query($koneksi, "SELECT id_user, nama_keuangan, SUM(total) as total_keuangan FROM keuangan WHERE id_user = '$id_users' AND nama_keuangan = 'Pengeluaran'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $total_keuangan_p = 'Rp ' . number_format($row['total_keuangan'], 2, ',', '.');

?>
    <p style="margin-bottom:-5px;text-align:center;font-weight:bold;">Pengeluaran</p>
    <?php
    if ($total_keuangan_p !== NULL) {
        echo '<p  style="color:red;text-align:center;">' . $total_keuangan_p . '</p>';
    } else {
        echo '<p  style="color:red;text-align:center;">0</p>';
    }
    ?>
<?php
} else {
    echo "Tidak ada data yang sesuai dengan kriteria.";
}
?>

                </div>
                <div class="col-lg-4 col-sm-4">
                <?php 
  $query_p = mysqli_query($koneksi, "SELECT id_user, nama_keuangan, SUM(total) as total_keuangan
  FROM keuangan WHERE id_user = '$id_users' AND nama_keuangan = 'Pengeluaran'");
  
  while ($row_p = mysqli_fetch_array($query_p)) {
    $total_keuangan_p = $row_p['total_keuangan'];

    $query = mysqli_query($koneksi, "SELECT id_user, nama_keuangan, SUM(total) as total_keuangan
    FROM keuangan WHERE id_user = '$id_users' AND nama_keuangan = 'Pemasukan'");
  
    while ($row = mysqli_fetch_array($query)) {
      $total_keuangan = $row['total_keuangan'];
      
      $selisih = $total_keuangan - $total_keuangan_p;
      $formattedSelisih = 'Rp ' . number_format($selisih, 2, ',', '.');
  ?>
  <p style="margin-bottom: -5px; text-align: center; font-weight: bold;">Total</p>
  <p style="text-align: center;"><?= $formattedSelisih ?></p>
  <?php 
    }
  } 
?>

                </div>
               </div>
               </div>
                </div>
                  </div>
               
                  <div class="card">
                    <div class="card-header">
                      <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
            </div>
                

                     <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal dan Waktu</th>
                    <th>Total</th>
                    <th>Kategori</th>
                    <th>Aset</th>
                    <th>Catatan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  
                  <tbody>
                   <?php
$no = 1;
$query = mysqli_query($koneksi, "SELECT * FROM keuangan WHERE id_user = $id_users");
while ($row = mysqli_fetch_array($query)) {
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= date('d F Y H.i', strtotime($row['tgl_b'])) ?></td>
   <?php
if ($row['nama_keuangan'] === 'Pemasukan') {
  $formattedTotal = 'Rp ' . number_format($row['total'], 2, ',', '.');
  echo '<td style="color: blue;">' . $formattedTotal . '</td>';
} else if ($row['nama_keuangan'] === 'Pengeluaran') {
  $formattedTotal = 'Rp ' . number_format($row['total'], 2, ',', '.');
  echo '<td style="color: red;">' . $formattedTotal . '</td>';
}

?>

    
    <?php
    $noK = $row['id_kategori'];
    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori = '$noK' ");
    while ($k = mysqli_fetch_array($kategori)) {
    ?>
    <td><?= $k['nama_kategori'] ?></td>
    <?php }?>
    <?php 
    $noA = $row['id_aset'];
    $aset = mysqli_query($koneksi, "SELECT * FROM aset WHERE id_aset = '$noA'");
    while ($a = mysqli_fetch_array($aset)) {
    ?>
    <td><?= $a['grup'] ?>/ <?= $a['nama_aset']?></td>
    <?php  }?>
    <td><?= $row['catatan'] ?></td>
    <td>
        <?php
        $gambarPath = "../../data/img/transaksi/" . $row['deskripsi']; // Path gambar sesuai dengan data dalam database
        if (file_exists($gambarPath)) {
            // Tampilkan gambar jika file gambar ada
            echo '<img src="' . $gambarPath . '" data-toggle="modal"  alt="Gambar Transaksi" data-target="#gambarModal' . $row['id_keuangan'] . '"  width="100" height="100">';
        } else {
            // Tampilkan deskripsi jika file gambar tidak ada
            echo $row['deskripsi'];
        }
        ?>
    </td>
    <td>
      <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modal-lg<?= $row['id_keuangan'] ?>" ><i class="fa fa-pen"></i></a>
      <a href="#" class="btn btn-danger delete" data-id="<?= $row['id_keuangan'] ?>"><i class="fa fa-trash"></i></a>
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>





   <?php 

include "../view/footer_t.php";
?>