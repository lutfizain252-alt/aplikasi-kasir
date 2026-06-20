<?php
session_start();
include "../config/koneksi.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data ringkasan transaksi
$queryTx = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'");
$tx = mysqli_fetch_assoc($queryTx);

// Ambil list banyak barang yang terikat di transaksi ini
$queryBarang = mysqli_query($conn, "SELECT detail_transaksi.*, barang.nama_barang 
                                    FROM detail_transaksi 
                                    JOIN barang ON detail_transaksi.id_barang = barang.id 
                                    WHERE detail_transaksi.no_nota='$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pengaturan khusus untuk printer */
        @media print { 
            .no-print { display: none !important; }
            .card { border: none !important; box-shadow: none !important; }
            body { background-color: #fff !important; }
        }
        /* Memberikan gaya agar nota terlihat seperti struk kasir asli */
        .struk-card { max-width: 400px; margin: auto; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow struk-card">
        <div class="card-header bg-dark text-white fw-bold text-center">🧾 NOTA TRANSAKSI</div>
        <div class="card-body p-4">
            <p class="small"><strong>ID:</strong> #<?= $tx['id'] ?><br>
               <strong>Waktu:</strong> <?= $tx['tanggal'] ?><br>
               <strong>Kasir:</strong> <?= htmlspecialchars($tx['kasir']) ?></p>
            <hr>
            <table class="table table-sm">
                <thead>
                    <tr><th>Barang</th><th class="text-center">Qty</th><th class="text-end">Total</th></tr>
                </thead>
                <tbody>
                    <?php while($b = mysqli_fetch_assoc($queryBarang)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                        <td class="text-center"><?= $b['qty'] ?></td>
                        <td class="text-end">Rp <?= number_format($b['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr>
            <div class="d-flex justify-content-between">
                <span class="fw-bold">TOTAL:</span>
                <h4 class="fw-bold text-danger">Rp <?= number_format($tx['total'], 0, ',', '.') ?></h4>
            </div>

            <div class="d-flex gap-2 mt-4 no-print">
                <button onclick="window.print()" class="btn btn-success btn-sm w-100">🖨️ Cetak</button>
                <a href="index.php" class="btn btn-warning btn-sm w-100">🛒 Baru</a>
                <a href="../dashboard.php" class="btn btn-secondary btn-sm w-100">⬅️ Kembali </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>