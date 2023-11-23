<?php
include "../../koneksi.php";

if (isset($_GET['nama']) && isset($_GET['no'])) {
    $id_user_from_url = $_GET['nama'];
    $id_tabungan_from_url = $_GET['no'];

    // Fetch the total_nominal from the catat_tabungan table
    $total_nominal_query = "SELECT SUM(nominal) as total_nominal FROM catat_tabungan WHERE id_tabungan = '$id_tabungan_from_url'";
    $total_nominal_result = mysqli_query($koneksi, $total_nominal_query);
    $total_nominal_row = mysqli_fetch_assoc($total_nominal_result);
    $total_nominal = $total_nominal_row['total_nominal'];

    echo $total_nominal;
} else {
    echo "0";
}

mysqli_close($koneksi);
?>
