<?php
session_start();
include "../../koneksi.php";

$id_users = $_GET['id_users']; // Ambil id_users dari permintaan AJAX
$transaksi = $_GET['transaksi']; // Ambil grup dari permintaan AJAX

switch ($transaksi) {
    case "Berlangsung":
        // Kode untuk menampilkan aset dengan grup "Berlangsung"
        $result = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE id_user = $id_users");
        $dataDitemukan = false; // Variabel penanda

        while ($d = mysqli_fetch_array($result)) {
            $id_tabungan = $d['id_tabungan'];
            $query_catat = mysqli_query($koneksi, "SELECT id_tabungan, SUM(nominal) AS total_nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan GROUP BY id_tabungan");
            $catat = mysqli_fetch_array($query_catat);

            if (!$catat || $d['target'] > $catat['total_nominal']) {
                
    
              // After fetching $d['id_tabungan']
$_SESSION['id_tabungan'] = $d['id_tabungan'];

               
                echo '<div class="col-md-4">';
            echo '  <div class="card mb-4">';
            echo '    <div class="card-body clickable">';
            echo '      <h5 class="card-text nama_tabungan"  data-id="' . $d['id_tabungan'] . '">' . $d['nama_tabungan'] . '</h5>';
            echo '<div class="text-center mb-2">';
            $gambarPath = "../../data/img/tabungan/" . $d['gambar']; // Path gambar sesuai dengan data dalam database
            if (empty($d['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                $gambarPath = "../dist/img/galeri.png";
            }

            echo '<a href="#" data-toggle="modal" title="Klik Gambar" class="edit-modal modal-gambar" data-id="'.$d['id_tabungan'].'" data-target="#gambarModal_t'.$d['id_tabungan'].'">
            <img style="width:300px;height:300px;border-radius:20px;"
                 src="'.$gambarPath.'"
                 alt="Gambar Tabungan">
                 </a>';
            echo '</div>';
            echo '      <p class="card-text id_user" style="display:none;">' . $d['id_user'] . '</p>';
             $formattedTarget = 'Rp ' . number_format($d['target'], 2, ',', '.');
            echo '      <h6 class="card-text text-bold" style="font-size:20px;">' . $formattedTarget. '</h6>';
            $FormatNominal = 'Rp ' . number_format($d['nominal'], 2, ',', '.');
            if($d['rencana'] === 'Harian') {
                            echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perhari</h6>';

            } else if($d['rencana'] === 'Mingguan') {
                            echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perminggu</h6>';
            } else if($d['rencana'] === 'Bulanan') {
                            echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perbulan</h6>';
            }
            echo '<hr>';
             echo '<div class="text-center">';
             $id_tabungan = $d['id_tabungan'];
            // ...
$query_catat = mysqli_query($koneksi, "SELECT id_tabungan, SUM(nominal) AS total_nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan GROUP BY id_tabungan");
$catat = mysqli_fetch_array($query_catat);

if ($catat) {
    // Data catat_tabungan ditemukan
    $hitungan = $d['target'] - $catat['total_nominal'];
    $hitung = floor($hitungan / $d['nominal']); // Menggunakan floor untuk membulatkan ke bawah

    // Tampilkan data sesuai kebutuhan
    echo '<div class="text-center">';
    if ($d['rencana'] === 'Harian') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung . ' Perhari</h6>';
    } elseif ($d['rencana'] === 'Mingguan') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung . ' Perminggu</h6>';
    } elseif ($d['rencana'] === 'Bulanan') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung . ' Perbulan</h6>';
    }
    echo '</div>';
} else {
    // Data catat_tabungan tidak ditemukan
    $hitung_a = floor($d['target'] / $d['nominal']); // Menggunakan floor untuk membulatkan ke bawah
    echo '<div class="text-center">';
    if ($d['rencana'] === 'Harian') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung_a . ' Perhari</h6>';
    } elseif ($d['rencana'] === 'Mingguan') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung_a . ' Perminggu</h6>';
    } elseif ($d['rencana'] === 'Bulanan') {
        echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung_a . ' Perbulan</h6>';
    }
    echo '</div>';
}
// ...


        
             echo '</div>';
            echo '<a href="#" class="btn btn-warning edit-tabungan" data-id-tabungan="' . $d['id_tabungan'] . '"><i class="fa fa-pen"></i></a>';

            echo '     <a href="#" class="btn btn-danger delete-category" data-id="' . $d['id_tabungan'] . '"><i class="fa fa-trash"></i></a>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
           
                $dataDitemukan = true; // Set variabel penanda ke true
            }
        }

        if (!$dataDitemukan) {
            // Tidak ada data yang memenuhi target
            echo '<div style="text-align:center;">';
            echo '<a href="#" data-toggle="modal" title="No Data">';
            echo '<img style="width:300px;height:300px;border-radius:20px;margin: auto;"';
            echo 'src="../dist/img/no_data.jpg" alt="Gambar Tabungan">';
            echo '</a>';
            echo '<p>Tidak ada data yang belum terpenuhi untuk ditampilkan.</p>';
            echo '</div>';
        }
        break;

    case "Tercapai":
    $result = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE id_user = $id_users ");
    $dataDitemukan = false; // Variabel penanda

    while ($d = mysqli_fetch_array($result)) {
        $id_tabungan = $d['id_tabungan'];

        // Menghitung jumlah nominal untuk 'tambah' dalam catat_tabungan
        $query_tambah = mysqli_query($koneksi, "SELECT SUM(nominal) AS total_tambah FROM catat_tabungan WHERE id_tabungan = $id_tabungan AND nama_catat = 'Tambah'");
        $total_tambah = mysqli_fetch_assoc($query_tambah)['total_tambah'];

        // Menghitung jumlah nominal untuk 'kurang' dalam catat_tabungan
        $query_kurang = mysqli_query($koneksi, "SELECT SUM(nominal) AS total_kurang FROM catat_tabungan WHERE id_tabungan = $id_tabungan AND nama_catat = 'Kurang'");
        $total_kurang = mysqli_fetch_assoc($query_kurang)['total_kurang'];

        $totalNominal = $total_tambah - $total_kurang; // Selisih total 'tambah' dan 'kurang'

        $target = $d['target'];
        $toleransi = 0.01; // Toleransi (misalnya, 1 sen)

        if (abs($totalNominal - $target) <= $toleransi) {
            // Data mencapai atau melebihi target
            echo '<div class="col-md-4">';
            echo '  <div class="card mb-4">';
            echo '    <div class="card-body clickable">';
            echo '      <h5 class="card-text nama_tabungan" data-id="' . $d['id_tabungan'] . '">' . $d['nama_tabungan'] . '</h5>';
            echo '<div class="text-center mb-2">';
            $gambarPath = "../../data/img/tabungan/" . $d['gambar']; // Path gambar sesuai dengan data dalam database
            if (empty($d['gambar']) || !file_exists($gambarPath)) {
                // Tampilkan "galeri.png" jika kolom gambar kosong atau file gambar tidak ada
                $gambarPath = "../dist/img/galeri.png";
            }

            echo '<a href="#" data-toggle="modal" title="Klik Gambar" class="edit-modal modal-gambar" data-id="'.$d['id_tabungan'].'" data-target="#gambarModal_t'.$d['id_tabungan'].'">';
            echo '<img style="width:300px;height:300px;border-radius:20px;margin: auto;"';
            echo 'src="'.$gambarPath.'" alt="Gambar Tabungan">';
            echo '</a>';
            echo '</div>';
            echo '      <p class="card-text id_user" style="display:none;">' . $d['id_user'] . '</p>';
            $formattedTarget = 'Rp ' . number_format($d['target'], 2, ',', '.');
            echo '      <h6 class="card-text text-bold" style="font-size:20px;">' . $formattedTarget. '</h6>';
            $FormatNominal = 'Rp ' . number_format($d['nominal'], 2, ',', '.');
            if($d['rencana'] === 'Harian') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perhari</h6>';
            } else if($d['rencana'] === 'Mingguan') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perminggu</h6>';
            } else if($d['rencana'] === 'Bulanan') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $FormatNominal. ' Perbulan</h6>';
            }
            echo '<hr>';
            echo '<div class="text-center">';
            $id_tabungan = $d['id_tabungan'];
            $query_catat = mysqli_query($koneksi, "SELECT * FROM catat_tabungan WHERE id_tabungan = $id_tabungan");
            $catat = mysqli_fetch_array($query_catat);
            if($catat['nama_catat'] === 'Tambah') {
                $hitungan = $d['target'] - $catat['nominal'];
                $hitung = $hitungan / $d['nominal'];
            } 
            if($d['rencana'] === 'Harian') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung. ' Perhari</h6>';
            } else if($d['rencana'] === 'Mingguan') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung. ' Perminggu</h6>';
            } else if($d['rencana'] === 'Bulanan') {
                echo '<h6 class="card-text text-bold" style="font-size:15px;">' . $hitung. ' Perbulan</h6>';
            }

            echo '</div>';
            echo '      <a href="#" class="btn btn-warning edit-category"><i class="fa fa-pen"></i></a>';
            echo '     <a href="#" class="btn btn-danger delete-category" data-id="' . $d['id_tabungan'] . '"><i class="fa fa-trash"></i></a>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
            $dataDitemukan = true; // Set variabel penanda ke true
        }
    }

    if (!$dataDitemukan) {
        // Tidak ada data yang memenuhi target
        echo '<div style="text-align:center;">';
        echo '<a href="#" data-toggle="modal" title="No Data">';
        echo '<img style="width:300px;height:300px;border-radius:20px;margin: auto;"';
        echo 'src="../dist/img/no_data.jpg" alt="Gambar Tabungan">';
        echo '</a>';
        echo '<p>Tidak ada data untuk ditampilkan.</p>';
        echo '</div>';
    }

    break;

    default:
        // Handle jika grup tidak dikenali
        echo "Grup tidak valid.";
}
?>
