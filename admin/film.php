<?php
    require_once __DIR__ . '/../auth/auth.php';
    require_once __DIR__ . '/../koneksi.php';

    $query = mysqli_query($koneksi, "SELECT id, username, email FROM pengguna");

    $username = $_SESSION['username'] ?? 'Pengguna';

    $film_per_page = 5;
    $halaman = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $halaman = max(1, $halaman);

    $count_query = mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total
         FROM jadwal_tayang
         INNER JOIN master_film ON jadwal_tayang.id_film = master_film.id_film"
    );

    $total_film = 0;
    if ($count_query) {
        $count_data = mysqli_fetch_assoc($count_query);
        $total_film = (int) ($count_data['total'] ?? 0);
    }

    $total_pages = max(1, (int) ceil($total_film / $film_per_page));
    $halaman = min($halaman, $total_pages);
    $offset = ($halaman - 1) * $film_per_page;

    $sql_film = "SELECT master_film.id_film, master_film.judul_film, master_film.gambar, master_film.genre, master_film.durasi,
                        jadwal_tayang.tanggal_tayang, jadwal_tayang.jam_tayang, jadwal_tayang.studio, jadwal_tayang.harga_tiket
                 FROM jadwal_tayang
                 INNER JOIN master_film ON jadwal_tayang.id_film = master_film.id_film
                 ORDER BY jadwal_tayang.tanggal_tayang ASC, jadwal_tayang.jam_tayang ASC
                 LIMIT $film_per_page OFFSET $offset";

    $film_query = mysqli_query($koneksi, $sql_film);

    $start_item = $total_film > 0 ? $offset + 1 : 0;
    $end_item = min($offset + $film_per_page, $total_film);

    $nama_bulan = [
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bioskop Stefanus Suka Mundur</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap');

        *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
            font-family: "Manrope", sans-serif;
        }

        html{
            scroll-behavior: smooth;
        }

        body{
            background-color: #0a0a0d;
        }

        .navigation{
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #b80710;
            padding: 12px clamp(18px, 4vw, 48px);
            position: sticky;
            top: 0; 
            z-index: 100;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .28);
        }

        .logo h2{
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: #fff;
            white-space: nowrap;
        }

        .nav-content{
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 4px;
        }

        .nav-content li{
            margin-right: 0;
        }

        .nav-content li a{
            padding: 9px 12px;
            color: rgba(255, 255, 255, .88);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            border-radius: 8px;
            transition: background .2s ease, color .2s ease;
        }

        .nav-content li a:hover{
            background: rgba(255, 255, 255, .13);
            color: #fff;
        }

        .nav-content button{
            border: none;
            border-radius: 8px;
            padding: 9px 14px;
            margin-left: 8px;
            background-color: #fff;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .nav-content button:hover{
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .18);
        }

        .nav-content button a{
            text-decoration: none;
            list-style: none;
            font-size: 12px;
            font-weight: 800;
            color: #9d060d;
            transition-duration: 0.4s;
        }
    </style>
</head>
<body>
    <nav class="navigation">
        <div class="logo">
            <h2>Bioskop Stefanus Suka Mundur</h2>
        </div>
        <ul class="nav-content">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="film.php">Pengaturan Film</a></li>
            <li><a href="jadwal.php">Pengaturan Jadwal</a></li>
            <li><a href="berita.php">Pengaturan Berita</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <button type="button" id="keluar" onclick="konfirmasiLogout()"><a href="../logout.php">Keluar</a></button>
        </ul>
    </nav>

    <section class="content-section" id="rekomendasi">
        <div class="section-heading">
            <div>
                <h2>Rekomendasi Film</h2>
                <p>Siap menonton? Pilih film favoritmu dan pesan tiket sekarang juga.</p>
            </div>
        </div>

        <div class="table-card">
            <div class="table-scroll">
                <table class="schedule-table">
                    <colgroup>
                        <col style="width: 42%;">
                        <col style="width: 19%;">
                        <col style="width: 13%;">
                        <col style="width: 14%;">
                        <col style="width: 12%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">Film</th>
                            <th scope="col">Jadwal</th>
                            <th scope="col">Studio</th>
                            <th scope="col" class="col-price">Harga</th>
                            <th scope="col" class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="filmTableBody">
                        <?php if ($total_film > 0): ?>
                            <?php while ($d = mysqli_fetch_assoc($film_query)): ?>
                                <?php
                                    $tanggal_ts = strtotime($d['tanggal_tayang']);
                                    $tanggal = date('j', $tanggal_ts) . ' ' . $nama_bulan[(int) date('n', $tanggal_ts)] . ' ' . date('Y', $tanggal_ts);
                                    $jam = date('H:i', strtotime($d['jam_tayang']));
                                    $initial = strtoupper(substr(trim($d['judul_film']), 0, 1));
                                ?>
                                <tr class="film-row">
                                    <td class="cell-film">
                                        <div class="film-info">
                                            <div class="poster" data-initial="<?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>">
                                                <img
                                                    src="assets/img/<?= htmlspecialchars($d['gambar'], ENT_QUOTES, 'UTF-8') ?>"
                                                    alt="Poster <?= htmlspecialchars($d['judul_film'], ENT_QUOTES, 'UTF-8') ?>"
                                                    loading="lazy"
                                                    onerror="this.onerror=null; this.style.display='none'; this.parentElement.classList.add('poster-fallback');"
                                                >
                                            </div>
                                            <div class="film-meta">
                                                <span class="film-title"><?= htmlspecialchars($d['judul_film']) ?></span>
                                                <span class="film-sub"><?= htmlspecialchars($d['genre']) ?> &bull; <?= (int) $d['durasi'] ?> menit</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-schedule">
                                        <span class="schedule-date"><?= htmlspecialchars($tanggal) ?></span>
                                        <span class="time-chip">
                                            <ion-icon name="time-outline"></ion-icon>
                                            <?= htmlspecialchars($jam) ?>
                                        </span>
                                    </td>
                                    <td class="cell-studio">
                                        <span class="studio-badge">
                                            <ion-icon name="film-outline"></ion-icon>
                                            <?= htmlspecialchars($d['studio']) ?>
                                        </span>
                                    </td>
                                    <td class="cell-price">
                                        <span class="price">
                                            <span class="price-currency">Rp</span><?= number_format((int) $d['harga_tiket'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td class="cell-action">
                                        <a
                                            href="./pages/detail.php?id_film=<?= (int) $d['id_film'] ?>"
                                            class="btn-book"
                                        >
                                            <ion-icon name="eye"></ion-icon>
                                            <span>Lihat Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr class="empty-state">
                                <td colspan="5">
                                    <ion-icon name="film-outline"></ion-icon>
                                    <p>Belum ada jadwal film yang tersedia.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="menu-control">
                    <?php if ($halaman > 1): ?>
                        <a id="prevBtn" class="pager-btn" href="?page=<?= $halaman - 1 ?>#rekomendasi" aria-label="Halaman sebelumnya">
                            <ion-icon name="chevron-back-outline" aria-hidden="true"></ion-icon>
                            <span>Sebelumnya</span>
                        </a>
                    <?php else: ?>
                        <button id="prevBtn" class="pager-btn" type="button" disabled aria-label="Halaman sebelumnya">
                            <ion-icon name="chevron-back-outline" aria-hidden="true"></ion-icon>
                            <span>Sebelumnya</span>
                        </button>
                    <?php endif; ?>

                    <span class="page-indicator" aria-live="polite">
                        <span><?= $halaman ?></span><span class="page-sep">/</span><span><?= $total_pages ?></span>
                    </span>

                    <?php if ($halaman < $total_pages): ?>
                        <a id="nextBtn" class="pager-btn" href="?page=<?= $halaman + 1 ?>#rekomendasi" aria-label="Halaman berikutnya">
                            <span>Berikutnya</span>
                            <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                        </a>
                    <?php else: ?>
                        <button id="nextBtn" class="pager-btn" type="button" disabled aria-label="Halaman berikutnya">
                            <span>Berikutnya</span>
                            <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>