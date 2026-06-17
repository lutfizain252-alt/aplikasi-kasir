<?php

session_start();
include "../config/koneksi.php";

$barang=mysqli_query($conn,
"SELECT * FROM barang
WHERE stok > 0");

?>

<!DOCTYPE html>
<html>
<head>

<title>Kasir</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Transaksi Kasir</h2>

<form
action="simpan.php"
method="POST">

<div class="mb-3">

<label>Barang</label>

<select
name="id_barang"
class="form-control"
required>

<option value="">
Pilih Barang
</option>

<?php
while($b=mysqli_fetch_assoc($barang)){
?>

<option
value="<?= $b['id'] ?>">

<?= $b['nama_barang'] ?>

| Stok :
<?= $b['stok'] ?>

| Rp
<?= number_format($b['harga']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Qty</label>

<input
type="number"
name="qty"
class="form-control"
required>

</div>

<button
type="submit"
class="btn btn-success">

Simpan Transaksi

</button>

<a
href="../dashboard.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>
</html>