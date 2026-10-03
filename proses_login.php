<?php
    session_start();

    if(isset($_SESSION['login'])){
        header("Location: home.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: login.php");
        exit();
    }

    include 'koneksi.php';
    
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if($identifier === '' || $password === ''){
        header("Location: login.php?error=kosong");
        exit();
    }

    $stmt = mysqli_prepare($koneksi, "SELECT username, email, password FROM users WHERE email = ? OR username = ? LIMIT 1");
    if(!$stmt){
        header("Location: login.php?error=gagal");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'ss', $identifier, $identifier);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);

    if(!$hasil || mysqli_num_rows($hasil) === 0){
        mysqli_stmt_close($stmt);
        header("Location: login.php?error=belum_terdaftar");
        exit();
    }

    $user = mysqli_fetch_assoc($hasil);
    mysqli_stmt_close($stmt);

    $hash = $user['password'] ?? '';

    $valid = false;
    if(!empty($hash) && password_verify($password, $hash)){
        $valid = true;
    } elseif(hash_equals((string)$hash, (string)$password)){
        $valid = true;
        $new_hash = password_hash($password, PASSWORD_DEFAULT);
        $up = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE username = ? OR email = ?");
        if($up){
            mysqli_stmt_bind_param($up, 'sss', $new_hash, $user['username'], $user['email']);
            mysqli_stmt_execute($up);
            mysqli_stmt_close($up);
        }
    }

    if(!$valid){
        header("Location: login.php?error=salah");
        exit();
    }

    session_regenerate_id(true);
    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

    header("Location: home.php");
    exit();
?>