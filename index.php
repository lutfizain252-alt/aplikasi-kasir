<?php

session_start();

if(isset($_SESSION['nama'])){

    header("Location: dashboard.php");

}else{

    header("Location: login.php");

}

?>