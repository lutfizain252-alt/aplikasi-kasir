<?php

include "../config/koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data barang berdasarkan ID
$data = mysqli_query($conn,

"SELECT * FROM barang

WHERE id='$id'");

$d = mysqli_fetch_assoc($data);

// Ambil semua kategori
$kategori = mysqli_query($conn,

"SELECT * FROM kategori");


// Jika tombol update ditekan
if(isset($_POST['update'])){

$nama = $_POST['nama_barang'];

$id_kategori = $_POST['id_kategori'];

$harga = $_POST['harga'];

$stok = $_POST['stok'];

mysqli_query($conn,

"UPDATE barang

SET

nama_barang='$nama',

id_kategori='$id_kategori',

harga='$harga',

stok='$stok'

WHERE id='$id'");

header("Location:index.php");

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Barang</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header">

<h3>Edit Barang</h3>

</div>

<div class="card-body">

<form method="POST">

<label>

Nama Barang

</label>

<input

type="text"

name="nama_barang"

class="form-control"

value="<?= $d['nama_barang']; ?>"

required>

<br>


<label>

Kategori

</label>

<select

name="id_kategori"

class="form-control"

required>

<option value="">

Pilih Kategori

</option>

<?php

while($k=mysqli_fetch_assoc($kategori)){

?>

<option

value="<?= $k['id']; ?>"

<?php

if($k['id']==$d['id_kategori']){

echo "selected";

}

?>

>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<br>


<label>

Harga

</label>

<input

type="number"

name="harga"

class="form-control"

value="<?= $d['harga']; ?>"

required>

<br>


<label>

Stok

</label>

<input

type="number"

name="stok"

class="form-control"

value="<?= $d['stok']; ?>"

required>

<br>


<button

type="submit"

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