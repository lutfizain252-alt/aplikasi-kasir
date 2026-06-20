<?php
session_start();
include "../config/koneksi.php";

// Proteksi halaman: Wajib login
if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];

// Ambil data barang HANYA milik user yang sedang aktif login
$query = "SELECT barang.*, kategori.nama_kategori 
          FROM barang 
          LEFT JOIN kategori ON barang.id_kategori = kategori.id
          WHERE barang.username = '$username_aktif'";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - SIBSIKASIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card-table {
            border-radius: 12px;
            border: none;
        }

        .table thead {
            background-color: #198754;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">📦 Data Barang Anda</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="../dashboard.php" class="btn btn-secondary px-3 rounded-pill fw-bold">⬅️ Kembali</a>
                <a href="tambah.php" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">➕ Tambah Barang</a>
            </div>
        </div>

        <div class="card card-table shadow-sm">
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%" class="py-3 text-center">No</th>
                            <th class="py-3">Nama Barang</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Harga Jual</th>
                            <th width="10%" class="py-3 text-center">Stok</th>
                            <th width="15%" class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($data) > 0) {
                            while ($d = mysqli_fetch_assoc($data)) {
                        ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $no++; ?></td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($d['nama_barang']); ?></td>
                                    <td>
                                        <?= $d['nama_kategori'] ? '<span class="badge bg-light text-success border border-success-subtle px-3 py-2 rounded-pill small">' . htmlspecialchars($d['nama_kategori']) . '</span>' : '<span class="text-muted small italic">Tanpa Kategori</span>'; ?>
                                    </td>

                                    <td class="fw-bold text-success">Rp <?= number_format($d['harga'] * 1000, 0, ',', '.'); ?></td>

                                    <td class="text-center">
                                        <?php if ($d['stok'] <= 0): ?>
                                            <span class="badge bg-danger rounded-pill px-2 py-1">Habis</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill px-3 py-1.5"><?= $d['stok']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning btn-sm px-3 rounded-pill text-white fw-bold">Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm px-3 rounded-pill fw-bold"
                                                onclick="konfirmasiHapus(<?= $d['id']; ?>, '<?= htmlspecialchars($d['nama_barang']); ?>')">
                                                Hapus
                                            </a>

                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="fs-4 mb-2">📦</div>
                                    Belum ada data barang di akun ini.<br>Silakan klik tombol <strong>Tambah Barang</strong> di atas.
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
        // Fungsi konfirmasi hapus (yang sudah ada)
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Barang '" + nama + "' akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'hapus.php?id=' + id;
                }
            });
        }

        // TAMBAHKAN KODE INI DI BAWAHNYA:
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data barang telah dihapus dari sistem.',
                showConfirmButton: false,
                timer: 1200
            });
        <?php endif; ?>

        <?php if (isset($_SESSION['sukses'])): ?>

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data barang telah diperbarui',
                showConfirmButton: false,
                timer: 1200
            });

            <?php unset($_SESSION['sukses']); ?>
        <?php endif; ?>
    </script>
</body>

</html>
</script>
</body>

</html>