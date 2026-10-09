<?php
    require_once 'auth.php';

    if($_SESSION['role'] !== 'admin'){
        header("Location: ../home.php");
        exit();
    }
?>
