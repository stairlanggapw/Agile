<?php
    $error = $_GET['error'] ?? '';
    $pesan_error = '';
    if ($error === 'kosong') {
        $pesan_error = 'Data tidak boleh kosong.';
    } elseif ($error === 'digunakan') {
        $pesan_error = 'Username atau email sudah digunakan.';
    } elseif ($error === 'gagal') {
        $pesan_error = 'Terjadi kesalahan saat mendaftar. Coba lagi.';
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
        <div class="login-box login-box-register">
            <form action="proses_register.php" method="POST">
                <h2>Register</h2>
                <?php if(!empty($pesan_error)): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($pesan_error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" required> 
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                </div>
                <button id="registerBtn" type="submit" name="registrasi">Register</button>
                <div class="register-link">
                    <p>already have an account!<a href="login.php"> Login</a></p>
                </div>
            </form>
        </div>
    </section>

    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>