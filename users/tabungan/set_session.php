<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tabungan'])) {
    $id_tabungan = $_POST['id_tabungan'];

    // Simpan id_tabungan dalam session
    $_SESSION['id_tabungan'] = $id_tabungan;

    echo 'success';
} else {
    echo 'error';
}
?>
