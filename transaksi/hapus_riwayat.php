<?php
session_start();
include "../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Hapus terlebih dahulu rincian barangnya di tabel detail_transaksi
    // Kolom pengikat yang benar adalah 'no_nota' sesuai database Anda
    $queryDetail = "DELETE FROM detail_transaksi WHERE no_nota = '$id'";
    mysqli_query($conn, $queryDetail);

    // 2. Setelah detailnya bersih, hapus data induknya di tabel transaksi
    $queryMaster = "DELETE FROM transaksi WHERE id = '$id'";
    
    if (mysqli_query($conn, $queryMaster)) {
        echo "<script>alert('Riwayat transaksi berhasil dihapus!'); window.location='riwayat.php';</script>";
    } else {
        echo "Gagal menghapus transaksi utama: " . mysqli_error($conn);
    }
} else {
    header("Location: riwayat.php");
}
?>