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
$konten .= '<p>Progress Anda! <b>'.number_format($hitung_persen, 0, '', '').'%</b></p>
';

$konten .= "
<div class='progress'>
  <div class='progress-bar bg-primary progress-bar-striped progress-bar-animated' role='progressbar'
       aria-valuenow='" . number_format($hitung_persen, 0, '', '') . "' aria-valuemin='0' aria-valuemax='100' style='width: " . number_format($hitung_persen, 0, '', '') . "%'>
    <span class='sr-only'>" . number_format($hitung_persen, 0, '', '') . "% Complete (success)</span>
  </div>
</div>
";




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

$tgl_b = new DateTime($row['tgl_b']);
$tgl_e = new DateTime($row['tgl_e']);

// Set waktu pada kedua objek DateTime menjadi pukul 00:00:00
$tgl_b->setTime(0, 0, 0);
$tgl_e->setTime(0, 0, 0);

// Hitung selisih hari
$selisih = $tgl_b->diff($tgl_e)->days;

$konten .= '
    <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
            <b>Tanggal Dibuat</b> <a class="float-right" style="color:black;">'. date('d F Y H.i', strtotime($row['tgl_b'])) .'</a>
        </li>
        <li class="list-group-item">
            <b>Tanggal Selesai</b> <a class="float-right" style="color:black;">'. date('d F Y H.i', strtotime($row['tgl_e'])) .'</a>
        </li>
        <li class="list-group-item">
        ';

        // Menghitung selisih hari
$selisih = $tgl_b->diff($tgl_e)->days;

// Logika kondisional untuk menampilkan selisih waktu sesuai dengan nilai "rencana"
if ($row['rencana'] === 'Harian') {
    $konten .= '<b> Selesai Dengan</b><a class="float-right" style="color:black;">'.$selisih.' hari</a>';
} elseif ($row['rencana'] === 'Mingguan') {
    $minggu = floor($selisih / 7);
    $hariSisa = $selisih % 7;
    $konten .= '<b> Selesai Dengan</b><a class="float-right" style="color:black;">'.$minggu.' minggu '.$hariSisa.' hari</a>';
} elseif ($row['rencana'] === 'Bulanan') {
    $bulan = floor($selisih / 30);
    $minggu = floor($selisih / 7);
    $hariSisa = $selisih % 30;
    $konten .= '<b> Selesai Dengan</b><a class="float-right" style="color:black;">'.$bulan.' bulan '.$minggu.' minggu '.$hariSisa.' hari</a>';
}


        $konten .= '
        </li>';


          $konten .= '         
                  
                  
                </ul>
               <a href="tabungan.php" class="btn btn-warning btn-block">
               <b>Kembali</b>
               </a>
              
              </div>
        
            </div>
';

    header('konten-Type: application/json');
    echo json_encode(['konten' => $konten]);
    mysqli_close($koneksi);
?>
  