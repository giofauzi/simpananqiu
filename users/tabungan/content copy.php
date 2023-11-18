<?php
include "../../koneksi.php";

$id_users = $_GET['id_users']; // Terima parameter dari permintaan AJAX
$id_tabungan = $_GET['id_tabungan']; // Terima parameter dari permintaan AJAX

// update-about.php

$query = "SELECT * FROM tabungan WHERE id_user = $id_users AND id_tabungan = $id_tabungan";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nama_tabungan = $row["nama_tabungan"];
    $target = $row["target"];
    $rencana = $row["rencana"];
    $nominal = $row["nominal"];
    $gambar = $row["gambar"];
    $tgl_b = $row["tgl_b"];
    $tgl_e = $row["tgl_e"];
}


$konten = '<div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">';
                  $gambarPath = "../../data/img/tabungan/" . $row['gambar']; // Path gambar sesuai dengan data dalam database
            if (empty($row['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                $gambarPath = "../dist/img/galeri.png";
            }

            $konten .= '<a href="#" data-toggle="modal" title="Klik Gambar" class="edit-modal modal-gambar" data-target="#gambarModal_t'.$row['id_tabungan'].'">
            <img style="width:250px;height:250px;border-radius:20px;margin-bottom:5px;"
                 src="'.$gambarPath.'"
                 alt="Gambar Tabungan">
                 </a>';
                 $konten .= '
                </div>';
               
               $formatTarget = 'Rp' . number_format($row['target'], 2, ',', '.');
               $konten .= '
                <div class="profile-info">
    <h3 class="profile-username text-bold">'.$formatTarget .'</h3>
    <div style="margin-bottom:-10px;">';   
  
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
$konten .= '<input type="text" class="knob" value="'.number_format($hitung_persen, 0, '', '').'" data-width="60" data-height="60" data-fgColor="#3c8dbc">';

$konten .= '

    </div>            
</div>';

$formatUang = 'Rp' . number_format($row['nominal'], 2, ',', '.');
if($row['rencana'] === 'Harian') {
 $konten .= '<p style="margin-top:-10px;font-weight:bold;color:black;">'.$formatUang.' Perhari</p>';
} else if($row['rencana'] === 'Mingguan') {
  $konten .= '<p style="margin-top:-10px;font-weight:bold;color:black;">'.$formatUang.' Perminggu</p>';
} else if($row['rencana'] === 'Bulanan') {
  $konten .= '<p style="margin-top:-10px;font-weight:bold;color:black;">'.$formatUang.' Perbulan</p>';
}

$konten .= '
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Tanggal Dibuat</b> <a class="float-right" style="color:black;">'. date('d F Y H.i', strtotime($row['tgl_b'])) .'</a>
                  </li>
                  <li class="list-group-item">';
                     
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
    $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Hari Lagi</a>';
} elseif ($row['rencana'] === 'Mingguan') {
    $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Minggu Lagi</a>';
} elseif ($row['rencana'] === 'Bulanan') {
    $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Bulan Lagi</a>';
}


          $konten .= '         
                  </li>
                  
                </ul>

               
              </div>
        
            </div>
            
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Kondisi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
    <strong><i class="fas fa-arrow-up mr-1" style="color:green"></i> Terkumpul</strong>';


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
    $konten .= '<p  style="color:green;">' . $format . '</p>';
    
    $konten .= '

    <hr>

    <strong><i class="fas fa-arrow-down mr-1" style="color:red;"></i> Kekurangan</strong>';

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
    $konten .= '<p style="color:red;"> ' . $format . '</p>';
    
$konten .= '
    <hr>
</div>

            </div>';
            $konten .= "
            <script src='../plugins/jquery-knob/jquery.knob.min.js'></script>
            <script>
  $(function () {
    /* jQueryKnob */

    $('.knob').knob({
     
      draw: function () {


        if (this.$.data('skin') == 'tron') {

          var a   = this.angle(this.cv)  // Angle
            ,
              sa  = this.startAngle          // Previous start angle
            ,
              sat = this.startAngle         // Start angle
            ,
              ea                            // Previous end angle
            ,
              eat = sat + a                 // End angle
            ,
              r   = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
    /* END JQUERY KNOB */

    //INITIALIZE SPARKLINE CHARTS
    var sparkline1 = new Sparkline($('#sparkline-1')[0], { width: 240, height: 70, lineColor: '#92c1dc', endColor: '#92c1dc' })
    var sparkline2 = new Sparkline($('#sparkline-2')[0], { width: 240, height: 70, lineColor: '#f56954', endColor: '#f56954' })
    var sparkline3 = new Sparkline($('#sparkline-3')[0], { width: 240, height: 70, lineColor: '#3af221', endColor: '#3af221' })

    sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
    sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
    sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])

  })

</script>
            ";

    header('konten-Type: application/json');
    echo json_encode(['konten' => $konten]);
    mysqli_close($koneksi);
?>
