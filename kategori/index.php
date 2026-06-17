<?php

include "../config/koneksi.php";

$data=mysqli_query($conn,

"SELECT * FROM kategori");

?>

<!DOCTYPE html>

<html>

<head>

<title>

Data Kategori

</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>

Data Kategori

</h2>

<a

href="../dashboard.php"

class="btn btn-secondary">

Kembali

</a>

<a

href="tambah.php"

class="btn btn-success">

Tambah Kategori

</a>

<br><br>

<table class="table table-bordered">

<tr>

<th>No</th>

<th>Nama Kategori</th>

<th>Aksi</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td>

<?= $no++ ?>

</td>

<td>

<?= $d['nama_kategori'] ?>

</td>

<td>

<a

href="edit.php?id=<?= $d['id'] ?>"

class="btn btn-warning btn-sm">

Edit

</a>

<a

href="hapus.php?id=<?= $d['id'] ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Hapus kategori?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>