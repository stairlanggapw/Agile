<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit;
    }

    $username = $_SESSION['username'] ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    
    
    <!-- <h1>Selamat datang, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h1>
    <p>Ini adalah halaman home.</p>
    <a href="logout.php">Logout</a>      -->

</body>
</html>