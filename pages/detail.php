<?php
    require_once __DIR__ . '../auth/auth.php';
    require_once __DIR__ . '../koneksi.php';

    $query = mysqli_query($koneksi, "SELECT judul_film, gambar FROM master_film");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bioskop Stefanus Suka Mundur</title>
    <style>

    </style>
</head>
<body>
    <div class="detail-container">
        <button><a href="../home.php">Back</a></button>
        <div class="detail-content">
            <h1>Selamat Datang Di Pemesanan Tiket.</h1>
            <div class="film-info">
                <span class="film-title"></span>
            </div>
        </div>
    </div>

    <script src="../main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</body>
</html>