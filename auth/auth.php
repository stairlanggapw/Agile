<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

    if (substr($base, -6) === '/admin') {
        $base = substr($base, 0, -6);
    }
    header("location: " . $base . "/login.php");
    exit();
}
?>