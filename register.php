<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    
    // Set default role sebagai 'kasir' untuk akun baru yang mendaftar mandiri
    $role     = 'kasir'; 

    // Cek apakah username sudah pernah digunakan atau belum
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Gagal! Username sudah terdaftar, silakan gunakan username lain.');</script>";
    } else {
        // Query Simpan Akun Baru ke Database
        $query_reg = mysqli_query($conn, "INSERT INTO users (nama, username, email, password, role) 
                                           VALUES ('$nama', '$username', '$email', '$password', '$role')");
        
        if ($query_reg) {
            echo "<script>
                alert('Pendaftaran Berhasil! Silakan login menggunakan akun Anda.');
                window.location='login.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Terjadi kesalahan sistem. Gagal mendaftar.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFTAR AKUN BARU</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-success m-0">DAFTAR AKUN</h2>
                        <small class="text-muted">Lengkapi data untuk membuat akun kasir</small>
                    </div>

                    <form method="POST" action="" autocomplete="off">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••" required autocomplete="new-password">
                        </div>

                        <button name="register" type="submit" class="btn btn-success w-100 mt-2 shadow-sm">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-4 small">
                        <span class="text-muted">Sudah punya akun?</span> 
                        <a href="login.php" class="text-success text-decoration-none fw-bold ms-1">Login di sini</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>