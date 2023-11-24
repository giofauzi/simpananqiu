<?php 
include "../view/header_t.php";
include "../view/navbar_t.php";
include "../view/sidebar_t.php";

if(isset($_GET['no'])) {
    $premium = $_GET['no'];

    if($premium == 1) {
        ?>
         <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tingkatkan Akun</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tingkatkan Akun</li>
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
            <div class="callout callout-info">
<h5><i class="fas fa-info"></i> Catatan:</h5>
Halaman ini merupakan halaman pemesanan, Silahkan mengisi data yang diperlukan.
</div>
            <div class="card">
           <div class="card-header">
    <form id="TambahMasuk" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?= $id_users ?>" >

                    <div class="row">
                    <div class="col-lg-6">
                 <div class="form-group">
                    <label for="nama_premium">Nama Produk</label>
                    <input type="text" class="form-control" name="nama_premium" value="Bisnis" id="nama_premium" readonly>
                  </div>

                  <div class="form-group">
                    <label for="tipe_premium">Tipe Produk</label>
                    <input type="text" class="form-control" name="tipe_premium" value="Tahun" id="tipe_premium" readonly>
                  </div>

                  <div class="form-group">
                    <label for="bayaran">Metode Pembayaran</label>
                    <input type="text" class="form-control" name="bayaran" value="E-Wallet" id="bayaran" readonly>
                  </div>
                  
                  
                </div>

            
                    <div class="col-lg-6">


                     <div class="form-group">
                  <label for="metode_pembayaran">E-Wallet</label>
                  <select class="form-control select2" name="metode_pembayaran" id="metode_pembayaran" style="width: 100%;">
                    <option value="">Pilih</option>
                    <option value="081223952077 - Dana">081223952077 - Dana</option>
                    <option value="081223952077 - Ovo">081223952077 - Ovo</option>
                    <option value="081223952077 - Gopay">081223952077 - Gopay</option>
                  </select>
                </div>
                
                     <div class="form-group">
                    <label for="bukti">Bukti Pembayaran</label>
                    <input type="file" class="form-control" name="bukti"  id="bukti" >
                  </div>



 <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                   <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan" rows="3"></textarea>
                </div>
</div>
</div>
<div class="form-group">
                        <button type="submit" class="btn btn-primary tambahpemasukan" id="">Simpan</button>

                        </div>
                      </div>
                    </form>
</div>

            
             

                  </div>
               
                  
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
        <?php 
    } else if($premium == 2) {
        echo 'Bulan';

   } else {
        // Tidak sesuai, redirect ke halaman yang sesuai
        $_SESSION['gagal'] = 'Opps, Anda Gagal!';
        echo '<script>window.location.href = "premium.php";</script>';
    }
} else {
        // Tidak sesuai, redirect ke halaman yang sesuai
        $_SESSION['gagal'] = 'Opps, Anda Gagal!';
        echo '<script>window.location.href = "premium.php";</script>';
    }
?>


<?php 
include '../view/footer_t.php';
?>