<?php

include "../config/koneksi.php";

$data=mysqli_query($conn,

"SELECT *
FROM transaksi
ORDER BY id DESC");

?>

<!DOCTYPE html>

<html>

<head>

<title>Riwayat Transaksi</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Riwayat Transaksi</h2>

<table class="table table-bordered">

<tr>

<th>ID</th>
<th>Tanggal</th>
<th>Kasir</th>
<th>Total</th>
<th>Aksi</th>

</tr>

<?php

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $d['id'] ?></td>

<td><?= $d['tanggal'] ?></td>

<td><?= $d['kasir'] ?></td>

<td>
Rp <?= number_format($d['total']) ?>
</td>

<td>

<a
href="detail.php?id=<?= $d['id'] ?>"
class="btn btn-info btn-sm">

Detail

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>