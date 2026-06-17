<?php

include "../config/koneksi.php";

$id=$_GET['id'];

$data=mysqli_query($conn,

"SELECT *

FROM kategori

WHERE id='$id'");

$d=mysqli_fetch_assoc($data);


if(isset($_POST['update'])){

$nama=$_POST['nama_kategori'];

mysqli_query($conn,

"UPDATE kategori

SET

nama_kategori='$nama'

WHERE

id='$id'");

header("Location:index.php");

}

?>


<!DOCTYPE html>

<html>

<head>

<title>

Edit Kategori

</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">

Edit Kategori

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

value="<?= $d['nama_kategori']; ?>"

required>

<br>

<button

name="update"

class="btn btn-warning">

Update

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