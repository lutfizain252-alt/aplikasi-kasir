<?php
session_start();
include "config/koneksi.php";

// Jika user ternyata sudah login dan session-nya valid, langsung lempar ke dashboard
if (isset($_SESSION['nama']) && trim($_SESSION['nama']) != '') {
    echo "<script>window.location='dashboard.php';</script>";
    exit;
}

// Buat variabel awal untuk menampung pesan error
$error_message = "";

if (isset($_POST['login'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        $_SESSION['username'] = $data['username'];
        $_SESSION['nama']     = trim($data['nama']);
        $_SESSION['role']     = $data['role'];

        echo "<script>window.location='dashboard.php';</script>";
        exit;
    } else {
        // GANTI DI SINI: Alih-alih memanggil alert script, kita isi teks ke variabel error
        $error_message = "Login gagal! Username atau Password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN SIKASIR</title>
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

        .card-header h3 {
            color: #198754;
            letter-spacing: 0.5px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg p-3">
                    <div class="card-header text-center bg-transparent border-0 pt-4">
                        <h3 class="fw-bold m-0">SIBSIKASIR</h3>
                        <small class="text-muted">Silakan masuk ke akun Anda</small>
                    </div>

                    <div class="card-body">

                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="font-size: 14px; border-radius: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg>
                                <?= $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan username" autocomplete="off" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" autocomplete="new-password" required>
                            </div>

                            <button name="login" type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm">Masuk Sistem</button>

                            <div class="mt-4 text-center" style="font-size: 14px;">
                                <a href="register.php" class="text-success text-decoration-none fw-bold">Daftar Akun Baru</a>
                                <span class="text-muted mx-2">|</span>
                                <a href="lupa_password.php" class="text-secondary text-decoration-none">Lupa Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>