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

<title>Cetak Struk</title>

</head>

<body onload="window.print()">

<center>

<h3>SIBSIKASIR</h3>

====================

<br>

<?= $d['tanggal'] ?>

<br>

====================

<br>

<?= $d['nama_barang'] ?>

<br>

<?= $d['qty'] ?>

x

<?= number_format($d['harga']) ?>

<br>

-------------------

<br>

TOTAL

<br>

Rp <?= number_format($d['subtotal']) ?>

<br>

====================

<br>

Terima Kasih

</center>

</body>

</html>