<?php

session_start();

include "config/koneksi.php";

if(!isset($_SESSION['nama'])){

header("Location:login.php");

}

$jBarang=mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) as total

FROM barang")

);


$jKategori=mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) as total

FROM kategori")

);


$jTransaksi=mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) as total

FROM transaksi")

);


$omzet=mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT SUM(total) as total

FROM transaksi")

);

?>


<!DOCTYPE html>

<html>

<head>

<title>

Dashboard SIBSIKASIR

</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>

<body>


<nav class="navbar navbar-dark bg-success">

<div class="container">

<a class="navbar-brand">

SIBSIKASIR

</a>


<div>

Halo,

<?= $_SESSION['nama']; ?>


<a

href="logout.php"

class="btn btn-light btn-sm">

Logout

</a>

</div>

</div>

</nav>



<div class="container mt-4">


<div class="row">


<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>

Barang

</h5>

<h1>

<?= $jBarang['total']; ?>

</h1>

<a

href="barang/index.php"

class="btn btn-success">

Kelola

</a>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>

Kategori

</h5>

<h1>

<?= $jKategori['total']; ?>

</h1>

<a

href="kategori/index.php"

class="btn btn-primary">

Kelola

</a>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>

Transaksi

</h5>

<h1>

<?= $jTransaksi['total']; ?>

</h1>

<a

href="transaksi/riwayat.php"

class="btn btn-warning">

Lihat

</a>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>

Omzet

</h5>

<h3>

Rp

<?=

number_format(

$omzet['total']

?? 0

);

?>

</h3>

</div>

</div>

</div>


</div>


<br>


<div class="card shadow">

<div class="card-header">

Menu Cepat

</div>


<div class="card-body">


<a

href="barang/index.php"

class="btn btn-success">

Barang

</a>


<a

href="kategori/index.php"

class="btn btn-primary">

Kategori

</a>


<a

href="transaksi/index.php"

class="btn btn-warning">

Kasir

</a>


<a

href="transaksi/riwayat.php"

class="btn btn-info">

Riwayat

</a>


</div>

</div>


</div>


</body>

</html>