<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];
$kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE username='$username_aktif'");

if (isset($_POST['simpan'])) {
    $nama   = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));
    $id_kat = mysqli_real_escape_string($conn, $_POST['id_kategori']);

    // PENTING: Hapus titik agar menjadi angka murni sebelum masuk database
    $harga  = str_replace('.', '', $_POST['harga']);
    $stok   = mysqli_real_escape_string($conn, $_POST['stok']);

    $query = "INSERT INTO barang (nama_barang, id_kategori, username, harga, stok) 
              VALUES ('$nama', '$id_kat', '$username_aktif', '$harga', '$stok')";

    if (mysqli_query($conn, $query)) {
        // Arahkan kembali ke tambah.php dengan status sukses
        header("Location: index.php?status=sukses");
        exit;
    } else {
        echo "<script>alert('Gagal menambah barang!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"> </script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h4 class="fw-bold mb-4">📂 Tambah Barang Baru</h4>
                    <form method="POST" action="" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
                                    <option value="<?= $k['id']; ?>"><?= $k['nama_kategori']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="text" id="input_harga" name="harga" class="form-control" placeholder="Contoh: 1.500" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" required min="0">
                        </div>
                        <button name="simpan" type="submit" class="btn btn-success fw-bold rounded-pill">Simpan Barang</button>
                        <a href="index.php" class="btn btn-secondary rounded-pill">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script untuk format ribuan otomatis saat mengetik
        const inputHarga = document.getElementById('input_harga');
        inputHarga.addEventListener('keyup', function(e) {
            let val = this.value.replace(/[^0-9]/g, ''); // Hapus karakter selain angka
            this.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambah titik otomatis
        });

        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Barang berhasil disimpan ke sistem.',
                icon: 'success',
                showConfirmButton: false, // Menghilangkan tombol OK
                timer: 1200, // Durasi 1 detik
                timerProgressBar: true // Menampilkan bar progres agar user tahu notifikasi akan hilang
            }).then(function() {
                // Otomatis pindah ke halaman data barang setelah notifikasi selesai
                window.location.href = 'index.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>