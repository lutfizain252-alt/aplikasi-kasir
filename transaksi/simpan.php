<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['arr_id_barang']) && count($_POST['arr_id_barang']) > 0) {
    
    $ids_barang  = $_POST['arr_id_barang']; 
    $qtys        = $_POST['arr_qty'];       
    $total_akhir = (int)$_POST['total_akhir'];
    $kasir       = $_SESSION['nama'];

    // 1. Simpan Ringkasan ke Tabel Utama 'transaksi' (Kolom: tanggal, kasir, total)
    $queryMaster = "INSERT INTO transaksi (tanggal, kasir, total) VALUES (NOW(), '$kasir', '$total_akhir')";
    
    if (mysqli_query($conn, $queryMaster)) {
        // Ambil ID Transaksi utama yang barusan tercipta otomatis
        $id_nota_baru = mysqli_insert_id($conn);

        // 2. Simpan Rincian Barang ke Tabel Pendukung 'detail_transaksi'
        for ($i = 0; $i < count($ids_barang); $i++) {
            $id_barang = mysqli_real_escape_string($conn, $ids_barang[$i]);
            $qty       = (int)$qtys[$i];

            // Ambil harga dari database
            $queryB = mysqli_query($conn, "SELECT harga FROM barang WHERE id='$id_barang'");
            $dataB  = mysqli_fetch_assoc($queryB);
            $harga_asli = (int)$dataB['harga'];
            
            // Pengaman angka nominal ribuan agar tidak terpotong menjadi satuan kecil
            if ($harga_asli < 1000) { 
                $harga_asli = $harga_asli * 1000; 
            }

            $subtotal = $harga_asli * $qty;

            // Memasukkan rincian barang (no_nota diisi ID transaksi utama)
            $queryDetail = "INSERT INTO detail_transaksi (no_nota, id_barang, qty, subtotal) 
                            VALUES ('$id_nota_baru', '$id_barang', '$qty', '$subtotal')";
            mysqli_query($conn, $queryDetail);

            // 3. Potong Stok Toko
            mysqli_query($conn, "UPDATE barang SET stok = stok - $qty WHERE id = '$id_barang'");
        }

        // Jika sukses semua, layar kasir langsung otomatis pindah ke halaman cetak struk!
        header("Location: detail.php?id=" . $id_nota_baru);
        exit;
    } else {
        echo "Gagal menyimpan data utama: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Keranjang belanja kosong!'); window.location='index.php';</script>";
}
?>