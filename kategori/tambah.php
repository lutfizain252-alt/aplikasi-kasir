<?php
session_start();
include "../config/koneksi.php";

// Proteksi halaman: Wajib login (Lokasi redirect disesuaikan agar tidak looping)
if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];

// Proses ketika tombol Simpan Kategori diklik
if (isset($_POST['simpan'])) {
    // Ambil input dan amankan dari karakter aneh/SQL Injection
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

    // Validasi jika input kosong
    if (trim($nama_kategori) != '') {
        // Simpan data kategori baru beserta username pemiliknya
        $query_simpan = "INSERT INTO kategori (nama_kategori, username) VALUES ('$nama_kategori', '$username_aktif')";

        if (mysqli_query($conn, $query_simpan)) {
            // Mengirim status sukses ke halaman index
            header("Location: index.php?status=sukses");
            exit;
        } else {
            $error = "Gagal menyimpan data!";
        }
    } else {
        $error = "Nama kategori tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - SIBSIKASIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card-custom {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger rounded-pill px-4" role="alert">
                        ⚠️ <?= $error; ?>
                    </div>
                <?php endif; ?>

                <div class="card card-custom shadow-lg">
                    <div class="card-header bg-success text-white fw-bold py-3">
                        ➕ Tambah Kategori Baru
                    </div>
                    <div class="card-body p-4">

                        <form action="" method="POST" autocomplete="off">

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary mb-2">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control px-3 py-2 rounded-3" placeholder="Masukkan nama kategori (Contoh: Makanan, Minuman)" required autofocus>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" name="simpan" class="btn btn-success px-4 fw-bold rounded-pill shadow-sm">Simpan Kategori</button>
                                <a href="index.php" class="btn btn-secondary px-4 rounded-pill">Batal</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>