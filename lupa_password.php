<?php
include 'config/koneksi.php';

if (isset($_POST['submit_email'])) {
    global $conn; // Menggunakan variabel $conn dari config
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Cek apakah email terdaftar
    $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        // Generate Token acak dan set kedaluwarsa 1 jam
        $token = bin2hex(random_bytes(32));
        $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Simpan token ke database
        mysqli_query($conn, "UPDATE users SET reset_token='$token', token_expire='$expire' WHERE email='$email'");
        
        // Pengalihan otomatis ke halaman ganti password baru (Simulasi)
        echo "<script>
                alert('Sistem simulasi: Link reset telah dibuat!');
                window.location='ganti_password.php?token=$token';
              </script>";
    } else {
        echo "<script>alert('Email tidak terdaftar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - SIBSIKASIR</title>
    <style>
        body { background-color: #fafafa; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #6c757d; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>SIBSIKASIR</h2>
        <p style="color: #666;">Masukkan email terdaftar untuk mereset password</p>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email Anda" required>
            <button type="submit" name="submit_email">Kirim Link Reset</button>
        </form>
        <p style="margin-top:15px; font-size:14px;"><a href="login.php" style="color:#28a745; text-decoration:none;">Kembali ke Login</a></p>
    </div>
</body>
</html>