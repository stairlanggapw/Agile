<?php
    require_once dirname(__DIR__) . '/auth/auth.php';
    require_once dirname(__DIR__) . '/koneksi.php';

    if (!isset($_GET['id_film']) || !ctype_digit($_GET['id_film'])) {
        die("Film tidak ditemukan.");
    }

    $id_film = (int) $_GET['id_film'];

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id_film, judul_film, gambar, genre, durasi
        FROM master_film
        WHERE id_film = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_film);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $film = mysqli_fetch_assoc($result);

    if (!$film) {
        die("Film tidak ditemukan.");
    }

    $stmt_jadwal = mysqli_prepare(
        $koneksi,
        "SELECT tanggal_tayang, jam_tayang, studio, harga_tiket
        FROM jadwal_tayang
        WHERE id_film = ?
        ORDER BY tanggal_tayang ASC, jam_tayang ASC"
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
    <title><?= htmlspecialchars($film['judul_film']) ?> | Detail Film</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap');

        *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
            font-family: "Manrope", sans-serif;
        }

        body{
            background-color: #0a0a0d;
            color: white;
        }

        .detail-container{
            
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <div class="top-detail">
            <button><a href="../home.php">Back</a></button>
            <h3>Detail Film</h3>
        </div>
        <div class="detail-container">
            <div>
                <img
                    class="poster"
                    src="../assets/img/<?= htmlspecialchars($film['gambar']) ?>"
                    alt="<?= htmlspecialchars($film['judul_film']) ?>"
                >
            </div>

            <div class="film-info">
                <h1><?= htmlspecialchars($film['judul_film']) ?></h1>

                <p>Genre: <?= htmlspecialchars($film['genre']) ?></p>
                <p>Durasi: <?= (int) $film['durasi'] ?> menit</p>

                <div class="schedule">
                    <h2>Pilih Jadwal Tayang</h2>

                    <?php if (mysqli_num_rows($jadwal_query) > 0): ?>
                        <?php while ($jadwal = mysqli_fetch_assoc($jadwal_query)): ?>

                            <div class="schedule-item">
                                <div>
                                    <p>
                                        Tanggal:
                                        <?= htmlspecialchars($jadwal['tanggal_tayang']) ?>
                                    </p>

                                    <p>
                                        Jam:
                                        <?= htmlspecialchars($jadwal['jam_tayang']) ?>
                                    </p>

                                    <p>
                                        Studio:
                                        <?= htmlspecialchars($jadwal['studio']) ?>
                                    </p>

                                    <p>
                                        Harga:
                                        Rp <?= number_format((int) $jadwal['harga_tiket'], 0, ',', '.') ?>
                                    </p>
                                </div>

                                <button id="btn-paymnt" class="btn-payment">Pembayaran</button>
                            </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Belum ada jadwal tayang untuk film ini.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="../main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</body>
</html>