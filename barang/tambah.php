<?php

include "../config/koneksi.php";

$kategori=mysqli_query($conn,

"SELECT * FROM kategori");


if(isset($_POST['simpan'])){

$nama=$_POST['nama_barang'];

$kategori=$_POST['id_kategori'];

$harga=$_POST['harga'];

$stok=$_POST['stok'];

mysqli_query($conn,

"INSERT INTO barang

(nama_barang,id_kategori,harga,stok)

VALUES

('$nama',

'$kategori',

'$harga',

'$stok')");

header("Location:index.php");

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Tambah Barang</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">

Tambah Barang

</div>

<div class="card-body">

<form method="POST">

<label>Nama Barang</label>

<input

type="text"

name="nama_barang"

class="form-control"

required>

<br>

<label>Kategori</label>

<select

name="id_kategori"

class="form-control"

required>

<option>

Pilih Kategori

</option>

<?php

while($k=mysqli_fetch_assoc($kategori)){

?>

<option

value="<?= $k['id'] ?>">

<?= $k['nama_kategori'] ?>

</option>

<?php } ?>

</select>

<br>

<label>Harga</label>

<input

type="number"

name="harga"

class="form-control"

required>

<br>

<label>Stok</label>

<input

type="number"

name="stok"

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