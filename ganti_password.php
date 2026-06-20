<?php
include 'config/koneksi.php';

if (isset($_GET['token'])) {
    global $conn; // Memberitahu VS Code bahwa $conn berasal dari koneksi.php
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $waktu_sekarang = date("Y-m-d H:i:s");

    // Validasi apakah token cocok dan belum kadaluwarsa
    $cek_token = mysqli_query($conn, "SELECT * FROM users WHERE reset_token='$token' AND token_expire > '$waktu_sekarang'");

    if (mysqli_num_rows($cek_token) == 0) {
        echo "<script>alert('Token tidak valid atau sudah kedaluwarsa!'); window.location='login.php';</script>";
        exit;
    }
} else {
    // Jika halaman diakses langsung tanpa token di URL, langsung lempar ke login
    header("Location: login.php");
    exit;
}

if (isset($_POST['change_password'])) {
    global $conn;
    // Mengambil token kembali dari URL agar tidak hilang saat form disubmit
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $password_baru = $_POST['password'];

    // Sesuai database sibsikasir Anda, password disimpan dalam teks biasa (belum di-hash)
    $password_fix = mysqli_real_escape_string($conn, $password_baru);

    // Update password baru dan hapus token lama (set ke NULL)
    $update = mysqli_query($conn, "UPDATE users SET password='$password_fix', reset_token=NULL, token_expire=NULL WHERE reset_token='$token'");

    if ($update) {
        echo "<script>alert('Password berhasil diperbarui! Silakan login kembali.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buat Password Baru</title>
    <style>
        body {
            background-color: #fafafa;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Buat Password Baru</h2>
        <form action="" method="POST">
            <input type="password" name="password" placeholder="Masukkan Password Baru" required>
            <button type="submit" name="change_password">Simpan Password</button>
        </form>
    </div>
</body>

</html>