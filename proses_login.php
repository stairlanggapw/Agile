<?php
    session_start();
    include 'koneksi.php';

    if(isset($_SESSION['login']) && $_SESSION['login'] === true){
        header("Location: home.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: login.php");
        exit;
    }

    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if($identifier === '' || $password === ''){
        header("Location: login.php?error=kosong");
        exit;
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, username, email, password, role
        FROM users
        WHERE username = ? OR email = ?
        LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "ss", $identifier, $identifier);
    mysqli_stmt_execute($stmt);

    $hasil = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($hasil);

    if(!$user || !password_verify($password, $user['password'])){
        header("Location: login.php?error=gagal");
        exit;
    }

    session_regenerate_id(true);

    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: admin/dashboard.php");
        exit;
    }

    header("Location: home.php");
    exit;
?>