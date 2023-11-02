<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_keuangan'])) {
    $id_keuangan = $_POST['id_keuangan'];

    // Simpan id_keuangan dalam session
    $_SESSION['id_keuangan'] = $id_keuangan;

    echo 'success';
} else {
    echo 'error';
}
