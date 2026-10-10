<?php
session_start();
require_once __DIR__ . '/koneksi.php';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    if (($_SESSION['role'] ?? '') === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: home.php');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$identifier = trim($_POST['identifier'] ?? '');
$password = $_POST['password'] ?? '';

if ($identifier === '' || $password === '') {
    header('Location: login.php?error=kosong');
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    'SELECT id, username, email, password, role
     FROM users
     WHERE username = ? OR email = ?
     LIMIT 1'
);

if (!$stmt) {
    error_log('Login prepare error: ' . mysqli_error($koneksi));
    header('Location: login.php?error=internal');
    exit;
}

mysqli_stmt_bind_param($stmt, 'ss', $identifier, $identifier);

if (!mysqli_stmt_execute($stmt)) {
    error_log('Login execute error: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    header('Location: login.php?error=internal');
    exit;
}

$result = mysqli_stmt_get_result($stmt);
$user = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($stmt);

if (!$user) {
    header('Location: login.php?error=belum_terdaftar');
    exit;
}

$hash = (string) ($user['password'] ?? '');
$valid = false;

if ($hash !== '' && password_verify($password, $hash)) {
    $valid = true;
    // Rehash jika algoritma sudah usang
    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $up = mysqli_prepare($koneksi, 'UPDATE users SET password = ? WHERE id = ?');
        if ($up) {
            mysqli_stmt_bind_param($up, 'si', $newHash, $user['id']);
            mysqli_stmt_execute($up);
            mysqli_stmt_close($up);
        }
    }
} elseif ($hash !== '' && hash_equals($hash, md5($password))) {
    // Migrasi akun lama yang masih simpan MD5 -> upgrade ke bcrypt
    $valid = true;
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $up = mysqli_prepare($koneksi, 'UPDATE users SET password = ? WHERE id = ?');
    if ($up) {
        mysqli_stmt_bind_param($up, 'si', $newHash, $user['id']);
        mysqli_stmt_execute($up);
        mysqli_stmt_close($up);
    }
} elseif ($hash !== '' && hash_equals($hash, $password)) {
    // Migrasi akun lama yang masih plain text -> upgrade ke bcrypt
    $valid = true;
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $up = mysqli_prepare($koneksi, 'UPDATE users SET password = ? WHERE id = ?');
    if ($up) {
        mysqli_stmt_bind_param($up, 'si', $newHash, $user['id']);
        mysqli_stmt_execute($up);
        mysqli_stmt_close($up);
    }
}

if (!$valid) {
    header('Location: login.php?error=salah');
    exit;
}

// Role kosong (data lama) -> default 'user' dan perbaiki di DB
$role = trim((string) ($user['role'] ?? ''));
if ($role === '') {
    $role = 'user';
    $upRole = mysqli_prepare($koneksi, "UPDATE users SET role = 'user' WHERE id = ?");
    if ($upRole) {
        mysqli_stmt_bind_param($upRole, 'i', $user['id']);
        mysqli_stmt_execute($upRole);
        mysqli_stmt_close($upRole);
    }
}

session_regenerate_id(true);

$_SESSION['login'] = true;
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $role;

if ($role === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

header('Location: home.php');
exit;
?>