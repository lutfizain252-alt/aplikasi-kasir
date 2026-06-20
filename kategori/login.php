<?php
session_start();
include "config/koneksi.php";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if(mysqli_num_rows($query) > 0){
        // KUNCI UTAMA: Menyimpan username ke session agar data barang & kategori bisa dipisah antar-akun!
        $_SESSION['username'] = $data['username']; 
        $_SESSION['nama']     = $data['nama'];
        $_SESSION['role']     = $data['role'];
        
        header("Location: dashboard.php");
        exit;
    } else {
        // Upgrade pesan error sesuai dengan screenshot yang Anda kirimkan
        echo "<script>
            alert('Login gagal! Username atau Password salah.');
            window.location='login.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN SIBSIKASIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .btn-success {
            background-color: #198754;
            border: none;
            padding: 10px;
            font-weight: bold;
        }
        .btn-success:hover {
            background-color: #146c43;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-success m-0" style="letter-spacing: 1px;">SIBSIKASIR</h2>
                        <small class="text-muted">Silakan masuk ke akun Anda</small>
                    </div>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Username</label>
                            <input type="text" name="username" class="form-control form-control-lg bg-light" placeholder="Masukkan Username" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Masukkan Password" required>
                        </div>

                        <button name="login" type="submit" class="btn btn-success btn-lg w-100 mt-2 shadow-sm">Masuk Sistem</button>
                    </form>

                    <div class="text-center mt-4 small">
                        <a href="register.php" class="text-success text-decoration-none fw-bold">Daftar Akun Baru</a>
                        <span class="text-muted mx-2">|</span>
                        <a href="lupa_password.php" class="text-muted text-decoration-none">Lupa Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>