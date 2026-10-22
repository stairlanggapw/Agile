<?php
    require_once __DIR__ . '/auth.php';

    if(($_SESSION['role'] ?? '') !== 'admin'){
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if (substr($base, -6) === '/admin') {
            $base = substr($base, 0, -6);
        }
        header("Location: " . $base . "/home.php");
        exit();
    }
?>
