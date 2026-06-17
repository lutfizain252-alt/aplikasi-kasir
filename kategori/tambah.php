<?php

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

$nama=$_POST['nama_kategori'];

mysqli_query($conn,

"INSERT INTO kategori

(nama_kategori)

VALUES

('$nama')");

header("Location:index.php");

}

?>


<!DOCTYPE html>

<html>

<head>

<title>

Tambah Kategori

</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">

Tambah Kategori

</div>

<div class="card-body">

<form method="POST">

<label>

Nama Kategori

</label>

<input

type="text"

name="nama_kategori"

class="form-control"

required>

<br>

<button

name="simpan"

class="btn btn-success">

Simpan

</button>

<a

href="index.php"

class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>