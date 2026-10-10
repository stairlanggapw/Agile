<?php
    session_start();

    if(isset($_SESSION['login']) && $_SESSION['login'] === true){
        if (($_SESSION['role'] ?? '') === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit;
    }

    $pesan = "";
    $pesan_error = "";

    if(isset($_GET['register']) && $_GET['register'] === 'success'){
        $pesan = "Registrasi berhasil! Silakan login.";
    }

    $error = $_GET['error'] ?? '';
    if ($error === 'kosong') {
        $pesan_error = 'Email/username dan password wajib diisi.';
    } elseif ($error === 'belum_terdaftar') {
        $pesan_error = 'Akun tidak ditemukan. Silakan registrasi dulu.';
    } elseif ($error === 'salah') {
        $pesan_error = 'Username/email atau password salah. Coba lagi.';
    } elseif ($error === 'gagal') {
        $pesan_error = 'Username/email atau password salah. Coba lagi.';
    } elseif ($error === 'internal') {
        $pesan_error = 'Terjadi kesalahan sistem. Coba lagi.';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Design</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section>
        <div class="login-box">
            <form action="proses_login.php" method="POST">
                <h2>Login</h2>
                <?php if(!empty($pesan)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty($pesan_error)): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($pesan_error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="text" name="identifier" required>
                    <label>Email atau Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember">Remember me</label>
                    <a href="#">Forgot Password</a>
                </div>
                <button id="loginBtn" name="login" type="submit">Login</button>
                <div class="register-link">
                    <p>Don't have an account?<a href="registrasi.php"> Register</a></p>
                </div>
            </form>
        </div>
    </section>
    
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>