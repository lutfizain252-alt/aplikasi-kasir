<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lacak jalur koneksi database secara aman
if (file_exists('config/koneksi.php')) {
    include 'config/koneksi.php';
} else if (file_exists('../config/koneksi.php')) {
    include '../config/koneksi.php';
} else {
    include '../../config/koneksi.php';
}

global $conn;

// Proteksi halaman: Menggunakan session utama sesuai sistem login kita
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['user'];

// Ambil data barang milik user yang sedang aktif login
$query = "SELECT barang.*, kategori.nama_kategori 
          FROM barang 
          LEFT JOIN kategori ON barang.id_kategori = kategori.id
          WHERE barang.username = '$username_aktif'
          ORDER BY barang.id DESC";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - SIBSIKASIR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background-color: #f8fafc;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
        }

        .header-title {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }

        .header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Card Styling */
        .card-table {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        /* Table Design Customize */
        .table {
            margin-bottom: 0;
        }
        .table thead {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #ffffff;
        }
        .table thead th {
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: none;
            padding: 18px 16px;
        }
        .table tbody td {
            padding: 16px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Buttons & Badges Custom */
        .btn-modern {
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-modern:hover {
            transform: translateY(-1px);
        }
        .btn-back {
            background-color: #ffffff;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .btn-back:hover {
            background-color: #f1f5f9;
            color: #334155;
        }
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }
        .btn-add:hover {
            color: white;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
        }

        /* Action Mini Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
        }
        .btn-edit {
            background-color: #fef3c7;
            color: #d97706;
        }
        .btn-edit:hover {
            background-color: #fde68a;
            color: #b45309;
        }
        .btn-delete {
            background-color: #fef2f2;
            color: #ef4444;
        }
        .btn-delete:hover {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .badge-kategori {
            background-color: #ecfdf5;
            color: #059669;
            font-weight: 600;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #a7f3d0;
        }
        .badge-stok {
            font-weight: 600;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container main-container" style="max-width: 1300px; margin-top: 40px; margin-bottom: 40px;">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
            <div>
                <h2 class="header-title"><i class="fa-solid fa-box text-success me-2"></i> Data Barang Toko</h2>
                <p class="header-subtitle">Kelola master inventori stok dan harga produk penjualan kasir Anda.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="../dashboard.php" class="btn btn-modern btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <a href="tambah.php" class="btn btn-modern btn-add"><i class="fa-solid fa-plus"></i> Tambah Barang</a>
            </div>
        </div>

        <div class="card card-table shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th width="6%" class="text-center">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th width="12%" class="text-center">Stok Sisa</th>
                            <th width="12%" class="text-center">Opsi Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($data && mysqli_num_rows($data) > 0) {
                            while ($d = mysqli_fetch_assoc($data)) {
                        ?>
                                <tr>
                                    <td class="text-center fw-semibold text-secondary"><?= $no++; ?></td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($d['nama_barang']); ?></td>
                                    <td>
                                        <?= $d['nama_kategori'] ? '<span class="badge-kategori"><i class="fa-solid fa-tag me-1"></i> ' . htmlspecialchars($d['nama_kategori']) . '</span>' : '<span class="text-muted small fs-6 fst-italic">Tanpa Kategori</span>'; ?>
                                    </td>
                                    <td class="fw-bold text-success">
                                        Rp <?= number_format($d['harga'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($d['stok'] <= 0): ?>
                                            <span class="badge badge-stok bg-danger text-white">Habis</span>
                                        <?php else: ?>
                                            <span class="badge badge-stok bg-light text-dark border"><?= $d['stok']; ?> Pcs</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <a href="edit.php?id=<?= $d['id']; ?>" class="btn-action btn-edit" title="Ubah Data">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn-action btn-delete" title="Hapus Data"
                                               onclick="konfirmasiHapus(<?= $d['id']; ?>, '<?= htmlspecialchars(addslashes($d['nama_barang'])); ?>')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="fs-2 mb-3 text-secondary"><i class="fa-solid fa-box-open"></i></div>
                                    <span class="fw-semibold d-block text-dark">Belum Ada Data Barang</span>
                                    Silakan tambahkan data barang baru dengan menekan tombol hijau di atas.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi Interaktif Konfirmasi Hapus SweetAlert2
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Produk '" + nama + "' akan dieliminasi dari sistem secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'hapus.php?id=' + id;
                }
            });
        }

        // Handler Notifikasi Sukses Aksi
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Dihapus!',
                text: 'Data barang berhasil dihilangkan.',
                showConfirmButton: false,
                timer: 1300
            });
        <?php endif; ?>

        <?php if (isset($_SESSION['sukses'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $_SESSION['sukses']; ?>',
                showConfirmButton: false,
                timer: 1300
            });
            <?php unset($_SESSION['sukses']); ?>
        <?php endif; ?>
    </script>
</body>
</html>