<?php
include 'database.php';

if(isset($_POST['registrasi'])){
    $username = $_POST["username"];
    $email = $_POST["emai"];
    $passowrd = $_POST["password"];
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
        <div action="registrasi.php" class="login-box">
            <form method="POST">
                <h2>Register</h2>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                        <input type="user" name="username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES, 'UTD-8'); ?>" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" value="<?php echo htmlspecialchars($passowrd ?? '', ENT_QUOTES, 'UTF-8')?>" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                </div>
                <button id="registerBtn" type="submit" name="registrasi">Login</button>
                <div class="register-link">
                    <p>already have an account!<a href="index.php"> Login</a></p>
                </div>
            </form>
        </div>
    </section>

    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>