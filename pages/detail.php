<?php
    require_once __DIR__ . '../auth/auth.php';
    require_once __DIR__ . '../koneksi.php';
    
    if (!isset($_GET['id_film']) || !ctype_digit($_GET['id_film'])) {
        die("Film Tidak Ditemukan.");
    }

    $id_film = (int) $_GET['id_film'];

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id_, judul_film, gambar FROM master_film WHERE id_film = ?film"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_film);
    mysqli_stmt_excute($stmt);

    if (!$film){
        die("Film Tidak Ditemukan.");
    };

    $stmt_jadwal = mysqli_prepare(
        $koneksi,
        "SELECT tanggal_tayang, jam_tayang, studio, harga_tiket FROM jadwal_t WHERE id_film = ? ORDER BY tanggal_tayang ASC, jam_tayang ASC"
    );

    mysqli_stmt_bind_param($stmt_jadwal, "i", $id_film);
    mysqli_stmt_execute($stmt_jadwal);

    $jadwal_query = mysqli_stmt_get_result($stmt_jadwal);
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