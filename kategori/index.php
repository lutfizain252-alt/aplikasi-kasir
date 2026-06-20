<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];
$query = "SELECT * FROM kategori WHERE username = '$username_aktif'";
$data  = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Kategori - SIBSIKASIR</title>
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
                <h2 class="fw-bold text-dark mb-1">🗂️ Data Kategori Anda</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="../dashboard.php" class="btn btn-secondary px-3 rounded-pill fw-bold">⬅️ Kembali</a>
                <a href="tambah.php" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">➕ Tambah Kategori</a>
            </div>
        </div>

        <div class="card card-table shadow-sm">
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="8%" class="py-3 text-center">No</th>
                            <th class="py-3">Nama Kategori</th>
                            <th width="20%" class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($data) > 0) {
                            while ($d = mysqli_fetch_assoc($data)) { ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $no++; ?></td>
                                    <td>
                                        <span class="badge bg-light text-success border border-success-subtle px-3 py-2 rounded-pill fs-6 fw-semibold">
                                            <?= htmlspecialchars($d['nama_kategori']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning btn-sm px-3 rounded-pill text-white fw-bold">Edit</a>
                                            <button class="btn btn-danger btn-sm px-3 rounded-pill fw-bold"
                                                onclick="hapusKategori(<?= $d['id']; ?>, '<?= htmlspecialchars($d['nama_kategori']); ?>')">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">Belum ada data kategori.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function hapusKategori(id, nama) {
            Swal.fire({
                title: 'Yakin hapus kategori?',
                text: "Kategori: " + nama + " akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'hapus.php?id=' + id;
                }
            });
        }

        // Notifikasi sukses setelah berhasil dihapus
        <?php if (isset($_GET['status']) && $_GET['status'] == 'berhasil'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data kategori telah dihapus.',
                showConfirmButton: false,
                timer: 1200
            });
        <?php endif; ?>
        // notifikasi nambah
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data kategori berhasil disimpan ke sistem.',
                showConfirmButton: false,
                timer: 1200,
                timerProgressBar: true
            });
        <?php endif; ?>
    </script>
</body>

</html>