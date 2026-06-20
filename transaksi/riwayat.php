<?php
session_start();
include "../config/koneksi.php";

// Proteksi halaman: Wajib login
if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];

// Ambil riwayat transaksi
$query = "SELECT * FROM transaksi ORDER BY id DESC";
$data  = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - SIBSIKASIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card-table { border-radius: 12px; border: none; }
        .table thead { background-color: #198754; color: white; }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">📜 Riwayat Transaksi</h2>
            <p class="text-muted small m-0">Daftar rekaman seluruh penjualan toko Anda.</p>
        </div>
        <div>
            <a href="../dashboard.php" class="btn btn-secondary px-4 rounded-pill fw-bold">⬅️ Kembali</a>
        </div>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th width="8%" class="py-3 text-center">ID No</th>
                        <th class="py-3">Tanggal / Waktu</th>
                        <th class="py-3">Nama Kasir</th>
                        <th class="py-3">Total Belanja</th>
                        <th width="20%" class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(mysqli_num_rows($data) > 0) {
                        while($d = mysqli_fetch_assoc($data)){
                            
                            // Perbaikan otomatis nominal yang terpotong (misal 30 -> 30.000)
                            $total_tampil = (int)$d['total'];
                            if ($total_tampil < 1000) {
                                $total_tampil = $total_tampil * 1000;
                            }
                    ?>
                        <tr>
                            <td class="text-center fw-bold text-secondary">#<?= $d['id'] ?></td>
                            <td class="text-muted fw-medium"><?= $d['tanggal'] ?></td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                                    👤 <?= htmlspecialchars($d['kasir']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">Rp <?= number_format($total_tampil, 0, ',', '.') ?></td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="detail.php?id=<?= $d['id'] ?>" class="btn btn-info btn-sm px-3 rounded-pill text-white fw-bold">Detail</a>
                                    <a href="hapus_riwayat.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm px-3 rounded-pill fw-bold" onclick="return confirm('Yakin ingin menghapus catatan riwayat transaksi ID #<?= $d['id'] ?> ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else { 
                    ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <div class="fs-4 mb-2">📜</div>
                                Belum ada riwayat transaksi yang tercatat.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>