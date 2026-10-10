<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    // Redirect absolut agar benar baik dari root maupun subfolder admin/
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    // Jika sedang di /admin, naik satu level
    if (substr($base, -6) === '/admin') {
        $base = substr($base, 0, -6);
    }
    header("location: " . $base . "/login.php");
    exit();
}