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
        $gambarPath = "../../data/img/tabungan/{$gambar}";
        if (empty($row['gambar']) || !file_exists($gambarPath)) {
            $gambarPath = "../dist/img/galeri.png";
        }
        $konten .= '<a href="#" data-toggle="modal" title="Klik Gambar" class="edit-modal modal-gambar" data-target="#gambarModal_t'.$row['id_tabungan'].'">
            <img style="width:250px;height:250px;border-radius:20px;margin-bottom:5px;" src="'.$gambarPath.'" alt="Gambar Tabungan">
        </a></div>';

        $formatTarget = 'Rp' . number_format($row['target'], 2, ',', '.');
        $konten .= '<div class="profile-info">
            <h3 class="profile-username text-bold">'. $formatTarget .'</h3>
            <div style="margin-bottom:-13px;">';

            $id_tabungan = $row['id_tabungan'];
            $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

            $total_positif = 0;
            $total_negatif = 0;

            while ($catat = mysqli_fetch_assoc($query_catat)) {
                $tanda = substr($catat['nominal'], 0, 1);
                $nilai = (int) substr($catat['nominal'], 1);

                if ($tanda === '+') {
                    $total_positif += $nilai;
                } elseif ($tanda === '-') {
                    $total_negatif += $nilai;
                }
            }

            $total_nominal = $total_positif - $total_negatif;
            $hitung_persen = min(($total_nominal / $row['target']) * 100, 100);
            $konten .= '<input type="text" class="knob" value="'.number_format($hitung_persen, 0, '', '').'" data-width="60" data-height="60" data-fgColor="#3c8dbc">';
            $konten .= '</div>';

            $formatUang = 'Rp' . number_format($row['nominal'], 2, ',', '.');
            if ($row['rencana'] === 'Harian') {
                $konten .= '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perhari</p>';
            } elseif ($row['rencana'] === 'Mingguan') {
                $konten .= '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perminggu</p>';
            } elseif ($row['rencana'] === 'Bulanan') {
                $konten .= '<p style="margin-top:-20px;font-weight:bold;color:black;">'.$formatUang.' Perbulan</p>';
            }

            $konten .= '<ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Tanggal Dibuat</b> <a class="float-right" style="color:black;">'.date('d F Y H.i', strtotime($row['tgl_b'])).'</a>
                </li>
                <li class="list-group-item">';

            $id_tabungan = $row['id_tabungan'];
            $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

            $total_nominal = 0;

            while ($catat = mysqli_fetch_assoc($query_catat)) {
                $tanda = substr($catat['nominal'], 0, 1);
                $nilai = (int) substr($catat['nominal'], 1);

                if ($tanda === '+') {
                    $total_nominal += $nilai;
                } elseif ($tanda === '-') {
                    $total_nominal -= $nilai;
                }
            }

            $sisa_target = max(0, $row['target'] - $total_nominal);
            $estimasi_waktu = floor($sisa_target / $row['nominal']);

            if ($row['rencana'] === 'Harian') {
                $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Hari Lagi</a>';
            } elseif ($row['rencana'] === 'Mingguan') {
                $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Minggu Lagi</a>';
            } elseif ($row['rencana'] === 'Bulanan') {
                $konten .= '<b>Estimasi</b> <a class="float-right" style="color:black;">' . $estimasi_waktu . ' Bulan Lagi</a>';
            }

            $konten .= '</li></ul></div>';

            $konten .= '<div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kondisi</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-arrow-up mr-1" style="color:green"></i> Terkumpul</strong>';

                    $id_tabungan = $row['id_tabungan'];
                    $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

                    $total_positif = 0;

                    while ($catat = mysqli_fetch_assoc($query_catat)) {
                        $tanda = substr($catat['nominal'], 0, 1);
                        $nilai = (int) substr($catat['nominal'], 1);

                        if ($tanda === '+') {
                            $total_positif += $nilai;
                        } elseif ($tanda === '-') {
                            $total_positif -= $nilai;
                        }
                    }

                    $format = 'Rp '. number_format($total_positif, 2, '.', ',');
                    $konten .= '<p style="color:green;">' . $format . '</p>';
                    $konten .= '<hr><strong><i class="fas fa-arrow-down mr-1" style="color:red;"></i> Kekurangan</strong>';

                    $id_tabungan = $row['id_tabungan'];
                    $query_catat = mysqli_query($koneksi, "SELECT nominal FROM catat_tabungan WHERE id_tabungan = $id_tabungan");

                    $total_negatif = 0;

                    while ($catat = mysqli_fetch_assoc($query_catat)) {
                        $tanda = substr($catat['nominal'], 0, 1);
                        $nilai = (int) substr($catat['nominal'], 1);

                        if ($tanda === '+') {
                            $total_negatif += $nilai;
                        } elseif ($tanda === '-') {
                            $total_negatif -= $nilai;
                        }
                    }

                    $hitungan = $row['target'] - $total_negatif;
                    $format = 'Rp '. number_format($hitungan, 2, '.', ',');
                    $konten .= '<p style="color:red;"> ' . $format . '</p>';
                    $konten .= '<hr></div></div></div>';

    header('konten-Type: application/json');
    echo json_encode(['konten' => $konten]);
    mysqli_close($koneksi);
?>
