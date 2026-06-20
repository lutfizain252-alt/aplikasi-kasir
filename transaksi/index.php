<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nama']) || trim($_SESSION['nama']) == '') {
    header("Location: ../login.php");
    exit;
}

$username_aktif = $_SESSION['username'];
$barang = mysqli_query($conn, "SELECT * FROM barang WHERE username='$username_aktif' AND stok > 0");

$array_barang = [];
while($b = mysqli_fetch_assoc($barang)){
    $harga_bersih = (int)$b['harga'];
    if ($harga_bersih < 1000) { $harga_bersih = $harga_bersih * 1000; }
    $array_barang[] = [
        'id' => $b['id'],
        'nama_barang' => $b['nama_barang'],
        'stok' => $b['stok'],
        'harga' => $harga_bersih
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir Multi-Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body { background-color: #f4f6f9; }
        .card { border-radius: 12px; border: none; }
        .select2-container .select2-selection--single { height: 45px !important; padding: 8px !important; }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow-lg mb-3">
                <div class="card-header bg-warning text-white fw-bold py-3">🛍️ Pilih & Tambah Barang</div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Cari Barang</label>
                        <select id="id_barang" class="form-control">
                            <option value="">-- Cari & Pilih Barang --</option>
                            <?php foreach($array_barang as $brg){ ?>
                                <option value="<?= $brg['id'] ?>" data-nama="<?= htmlspecialchars($brg['nama_barang']) ?>" data-harga="<?= $brg['harga'] ?>" data-stok="<?= $brg['stok'] ?>">
                                    <?= htmlspecialchars($brg['nama_barang']) ?> | Stok: <?= $brg['stok'] ?> | Rp <?= number_format($brg['harga'], 0, ',', '.') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary">Jumlah Beli</label>
                        <input type="number" id="qty" class="form-control" min="1" value="1">
                    </div>
                    <button type="button" id="btn-tambah" class="btn btn-primary w-100 fw-bold rounded-pill">➕ Tambah ke Keranjang</button>
                </div>
            </div>
            <a href="../dashboard.php" class="btn btn-secondary w-100 rounded-pill fw-bold">⬅️ Kembali</a>
        </div>

        <div class="col-md-7">
            <form action="simpan.php" method="POST" autocomplete="off">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white fw-bold py-3">🛒 Daftar Belanjaan</div>
                    <div class="card-body p-4">
                        <table class="table table-hover" id="tabel-keranjang">
                            <thead><tr><th>Barang</th><th>Qty</th><th>Harga</th><th>Subtotal</th><th>Aksi</th></tr></thead>
                            <tbody><tr id="row-kosong"><td colspan="5" class="text-center">Keranjang kosong.</td></tr></tbody>
                        </table>
                        <div class="mb-3 mt-4">
                            <label class="fw-bold text-danger">TOTAL</label>
                            <input type="text" id="total_tampil" class="form-control" value="Rp 0" readonly>
                            <input type="hidden" name="total_akhir" id="total_akhir" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-success">UANG TUNAI</label>
                            <input type="text" id="uang_bayar_input" class="form-control" placeholder="Masukkan nominal...">
                            <input type="hidden" name="uang_bayar" id="uang_bayar_asli" value="0">
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-secondary">KEMBALIAN</label>
                            <input type="text" id="kembalian_tampil" class="form-control" value="Rp 0" readonly>
                        </div>
                        <button type="submit" class="btn btn-warning text-white btn-lg w-100 fw-bold rounded-pill">💾 Simpan Transaksi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#id_barang').select2({ width: '100%' });
    });

    let keranjang = [];
    let totalGlobal = 0;

    $('#btn-tambah').click(function() {
        let sel = $('#id_barang option:selected');
        if(!sel.val()) { alert("Pilih barang!"); return; }
        
        let id = sel.val(), nama = sel.data('nama'), harga = parseInt(sel.data('harga')), stok = parseInt(sel.data('stok')), qty = parseInt($('#qty').val());
        if(qty > stok) { alert("Stok tidak cukup!"); return; }

        keranjang.push({id, nama, harga, qty, subtotal: harga * qty});
        perbaruiTabel();
    });

    function perbaruiTabel() {
        let tbody = $('#tabel-keranjang tbody').empty();
        totalGlobal = 0;
        keranjang.forEach((item, i) => {
            totalGlobal += item.subtotal;
            tbody.append(`<tr><td>${item.nama}<input type="hidden" name="arr_id_barang[]" value="${item.id}"><input type="hidden" name="arr_qty[]" value="${item.qty}"></td><td>${item.qty}</td><td>${item.harga}</td><td>${item.subtotal}</td><td><button type="button" class="btn btn-danger btn-sm" onclick="keranjang.splice(${i},1); perbaruiTabel()">X</button></td></tr>`);
        });
        $('#total_tampil').val("Rp " + totalGlobal.toLocaleString('id-ID'));
        $('#total_akhir').val(totalGlobal);
    }

    $('#uang_bayar_input').keyup(function() {
        let val = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(parseInt(val || 0).toLocaleString('id-ID'));
        $('#uang_bayar_asli').val(val);
        let kembali = parseInt(val || 0) - totalGlobal;
        $('#kembalian_tampil').val(kembali >= 0 ? "Rp " + kembali.toLocaleString('id-ID') : "Uang Kurang");
    });
</script>
</body>
</html>