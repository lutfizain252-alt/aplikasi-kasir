<?php

include "../config/koneksi.php";

$id=$_GET['id'];

$data=mysqli_query($conn,

"SELECT
transaksi.*,
barang.nama_barang,
detail_transaksi.qty,
detail_transaksi.harga,
detail_transaksi.subtotal

FROM transaksi

JOIN detail_transaksi

ON transaksi.id=
detail_transaksi.id_transaksi

JOIN barang

ON barang.id=
detail_transaksi.id_barang

WHERE transaksi.id='$id'");

$d=mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>

<html>

<head>

<title>Detail Transaksi</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Detail Transaksi</h2>

<table class="table table-bordered">

<tr>
<td>ID</td>
<td><?= $d['id'] ?></td>
</tr>

<tr>
<td>Tanggal</td>
<td><?= $d['tanggal'] ?></td>
</tr>

<tr>
<td>Kasir</td>
<td><?= $d['kasir'] ?></td>
</tr>

<tr>
<td>Barang</td>
<td><?= $d['nama_barang'] ?></td>
</tr>

<tr>
<td>Qty</td>
<td><?= $d['qty'] ?></td>
</tr>

<tr>
<td>Harga</td>
<td>Rp <?= number_format($d['harga']) ?></td>
</tr>

<tr>
<td>Total</td>
<td>Rp <?= number_format($d['subtotal']) ?></td>
</tr>

</table>

<a
href="cetak.php?id=<?= $id ?>"
class="btn btn-success">

Cetak Struk

</a>

<a
href="riwayat.php"
class="btn btn-primary">

Riwayat

</a>

</div>

</body>

</html>