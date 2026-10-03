<?php
    include 'koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: registrasi.php");
        exit();
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if($username === '' || $email === '' || $password === ''){
        header("Location: registrasi.php?error=kosong");
        exit();
    }

    $cek = mysqli_prepare($koneksi, "SELECT * FROM users WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($cek, 'ss', $username, $email);
    mysqli_stmt_execute($cek);
    $hasil_cek = mysqli_stmt_get_result($cek);

    if(mysqli_num_rows($hasil_cek) > 0){
        mysqli_stmt_close($cek);
        header("Location: registrasi.php?error=digunakan");
        exit();
    }

    mysqli_stmt_close($cek);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_prepare($koneksi, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($query, 'sss', $username, $email, $password_hash);

    if(mysqli_stmt_execute($query)){
        mysqli_stmt_close($query);
        header("Location: login.php?register=success");
        exit();
    }

    mysqli_stmt_close($query);
    header("Location: registrasi.php?error=gagal");
    exit();
?>