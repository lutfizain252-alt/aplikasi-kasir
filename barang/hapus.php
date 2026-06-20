<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$username_aktif = $_SESSION['username'];

mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_barang = '$id'");
$query_hapus = mysqli_query($conn, "DELETE FROM barang WHERE id = '$id' AND username = '$username_aktif'");

if($query_hapus){
    header("Location: index.php?status=sukses");
} else {
    header("Location: index.php?status=gagal");
}
exit;
?>