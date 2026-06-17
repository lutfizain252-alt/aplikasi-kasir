<?php

session_start();

include "../config/koneksi.php";

$id_barang=$_POST['id_barang'];
$qty=$_POST['qty'];

$barang=mysqli_query($conn,

"SELECT *
FROM barang
WHERE id='$id_barang'");

$b=mysqli_fetch_assoc($barang);

$harga=$b['harga'];

$subtotal=$harga*$qty;

$stok_baru=$b['stok']-$qty;

if($stok_baru < 0){

echo "<script>
alert('Stok tidak cukup');
window.location='index.php';
</script>";

exit;

}

mysqli_query($conn,

"INSERT INTO transaksi
(kasir,total)

VALUES

('".$_SESSION['nama']."',
'$subtotal')");

$id_transaksi=mysqli_insert_id($conn);

mysqli_query($conn,

"INSERT INTO detail_transaksi

(id_transaksi,id_barang,qty,harga,subtotal)

VALUES

('$id_transaksi',
'$id_barang',
'$qty',
'$harga',
'$subtotal')");

mysqli_query($conn,

"UPDATE barang

SET stok='$stok_baru'

WHERE id='$id_barang'");

header("Location:detail.php?id=".$id_transaksi);

?>