<?php
session_start();
include "../config/koneksi.php";

// Proteksi halaman: Wajib login
if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$username_aktif = $_SESSION['username'];

// 1. Putus hubungan barang-barang yang memakai kategori ini
mysqli_query($conn, "UPDATE barang SET id_kategori = NULL WHERE id_kategori = '$id' AND username = '$username_aktif'");

// 2. Hapus data kategori
$hapus = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id' AND username = '$username_aktif'");

// 3. Tambahkan status 'berhasil' agar notifikasi muncul di index.php
if($hapus) {
    header("Location: index.php?status=berhasil");
} else {
    header("Location: index.php?status=gagal");
}
exit;
?>