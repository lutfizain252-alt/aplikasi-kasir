<?php

session_start();

include "config/koneksi.php";


if(isset($_POST['login'])){


$username=$_POST['username'];

$password=$_POST['password'];


$query=mysqli_query(

$conn,

"SELECT *

FROM users

WHERE username='$username'

AND password='$password'"

);


$data=mysqli_fetch_assoc($query);


if(mysqli_num_rows($query)>0){

$_SESSION['nama']=$data['nama'];

$_SESSION['role']=$data['role'];

header("Location:dashboard.php");

}else{

echo

"<script>

alert('Login gagal');

</script>";

}

}

?>


<!DOCTYPE html>

<html>

<head>

<title>

LOGIN SIBSIKASIR

</title>

<link

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"

rel="stylesheet">

</head>


<body>

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header text-center">

<h3>

SIBSIKASIR

</h3>

</div>


<div class="card-body">

<form method="POST">

<input

type="text"

name="username"

class="form-control mb-3"

placeholder="Username"

required>


<input

type="password"

name="password"

class="form-control mb-3"

placeholder="Password"

required>


<button

name="login"

class="btn btn-success w-100">

Login

</button>


</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>