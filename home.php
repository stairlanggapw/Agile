<?php
    require_once __DIR__ . '../auth/auth.php';
    require_once __DIR__ . '/koneksi.php';

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

        .hero-section{
            position: relative;
            width: 100%;
            min-height: 95vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .hero-background{
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('assets/Cinima.jpg');
            background-size: cover;
            background-position: center;
            z-index: 1;
        }

        .hero-background::after{
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 10, 13, .15) 0%, rgba(10, 10, 13, .55) 100%);
        }

        .hero-content{
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 0 24px;
        }

        .hero-section h1{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            color: #fff;
            text-align: center;
            text-shadow: 0 4px 24px rgba(0, 0, 0, .5);
        }

        .hero-section .search-container {
            display: flex;
            justify-content: center; 
            align-items: center;     
            margin-top: 20px;        
        }

        .hero-section input[type=text] {
            padding: 10px 15px;      
            font-size: 16px;
            border: none;
            border-radius: 5px 0 0 5px; 
            outline: none;
            width: 300px;            
        }

        .hero-section .search-container button {
            padding: 10px 20px;
            background: #e50914;     
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 0 5px 5px 0; 
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .hero-section .search-container button:hover {
            background: #b80710;    
        }

        .content-section{
            position: relative;
            padding: 68px clamp(20px, 5vw, 72px) 88px;
            background: #0a0a0d;
            color: #fff;
            scroll-margin-top: 88px;
        }

        .section-heading {
            max-width: 1240px;
            margin: 0 auto 28px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0;
            text-align: center;
        }

        .section-eyebrow {
            display: inline-block;
            margin-bottom: 10px;
            color: #ff4b55;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .section-heading h2 {
            font-size: clamp(26px, 3.2vw, 38px);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -.02em;
            color: #fff;
        }

        .section-heading p {
            margin-top: 8px;
            color: #9898a6;
            font-size: 14px;
            line-height: 1.6;
        }

        .date-badge{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 999px;
            background: rgba(255, 255, 255, .04);
            color: #d7d7e0;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .date-badge ion-icon{
            color: #ff4b55;
            font-size: 15px;
        }

        .table-card{
            max-width: 1240px;
            margin: 0 auto;
            background: #121218;
            border: 1px solid rgba(255, 255, 255, .08);
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .42);
        }

        .table-scroll{
            overflow-x: auto;
        }

        .table-scroll::-webkit-scrollbar{
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-thumb{
            background: #2b2b37;
            border-radius: 99px;
        }

        .schedule-table{
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
        }

        .schedule-table thead th{
            padding: 16px 20px;
            background: #b80710;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            color: white;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .16em;
            text-align: left;
            text-transform: uppercase;
        }

        .schedule-table thead th.col-price,
        .schedule-table thead th.col-action{
            text-align: right;
        }

        .schedule-table tbody td{
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
            color: #d7d7e0;
            font-size: 13.5px;
            vertical-align: middle;
        }

        .schedule-table tbody tr{
            animation: rowFade .35s ease both;
            transition: background .2s ease;
        }

        .schedule-table tbody tr:hover{
            background: rgba(255, 255, 255, .03);
        }

        .schedule-table tbody tr:last-child td{
            border-bottom: none;
        }

        @keyframes rowFade{
            from{
                opacity: 0;
            }
            to{
                opacity: 1;
            }
        }

        .film-info{
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .poster{
            position: relative;
            flex: 0 0 auto;
            width: 56px;
            height: 78px;
            border-radius: 10px;
            overflow: hidden;
            background: linear-gradient(135deg, #2a2a36, #14141b);
            box-shadow: 0 8px 18px rgba(0, 0, 0, .35);
        }

        .poster img{
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .poster.poster-fallback::after{
            content: attr(data-initial);
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 30% 20%, rgba(229, 9, 20, .35), transparent 62%),
                linear-gradient(135deg, #23232e, #101016);
            color: rgba(255, 255, 255, .75);
            font-size: 22px;
            font-weight: 800;
        }

        .film-meta{
            min-width: 0;
        }

        .film-title{
            display: block;
            margin-bottom: 4px;
            color: #fff;
            font-size: 14.5px;
            font-weight: 700;
            line-height: 1.35;
        }

        .film-sub{
            color: #8d8d9b;
            font-size: 12px;
        }

        .schedule-date{
            display: block;
            margin-bottom: 6px;
            color: #f4f4f7;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .time-chip{
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 9px;
            border-radius: 7px;
            background: rgba(229, 9, 20, .14);
            color: #ff6b72;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .time-chip ion-icon{
            font-size: 13px;
        }

        .studio-badge{
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 999px;
            background: rgba(255, 255, 255, .03);
            color: #c9c9d4;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .studio-badge ion-icon{
            color: #8d8d9b;
            font-size: 13px;
        }

        .schedule-table td.cell-price{
            text-align: right;
        }

        .price{
            text-decoration: none;
            color: #fff;
            font-size: 14.5px;
            font-weight: 800;
            white-space: nowrap;
        }

        .price-currency{
            margin-right: 3px;
            color: #8d8d9b;
            font-size: 11px;
            font-weight: 600;
        }

        .schedule-table td.cell-action{
            text-align: right;
        }

        .schedule-table td.cell-action a{
            text-decoration: none;
            color: white;
        }

        .btn-book{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 16px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #e50914, #b80710);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(229, 9, 20, .25);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .btn-book ion-icon{
            font-size: 14px;
        }

        .btn-book:hover{
            transform: translateY(-1px);
            filter: brightness(1.08);
            box-shadow: 0 10px 22px rgba(229, 9, 20, .35);
        }

        .btn-book:active{
            transform: translateY(0);
        }

        .empty-state td{
            padding: 52px 20px !important;
            text-align: center;
            color: #8d8d9b;
        }

        .empty-state ion-icon{
            margin-bottom: 10px;
            color: #3a3a46;
            font-size: 34px;
        }

        .table-footer{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 18px 20px;
            background: #101016;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .menu-control {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin: 24px auto 0;
            position: relative;
            left: 0;
            transform: none;
        }

        .pager-btn{
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 40px;
            padding: 9px 16px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 999px;
            background: rgba(255, 255, 255, .04);
            color: #f1f1f5;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .22s ease, border-color .22s ease, box-shadow .22s ease, color .22s ease, opacity .22s ease;
        }

        .pager-btn ion-icon{
            font-size: 16px;
            transition: transform .22s ease;
        }

        #prevBtn:hover:not(:disabled) ion-icon{
            transform: translateX(-2px);
        }

        #nextBtn:hover:not(:disabled) ion-icon{
            transform: translateX(2px);
        }

        .pager-btn:hover:not(:disabled){
            border-color: transparent;
            background: linear-gradient(135deg, #e50914, #b80710);
            box-shadow: 0 8px 20px rgba(229, 9, 20, .28);
        }

        .pager-btn:focus-visible{
            outline: 2px solid #ff6b72;
            outline-offset: 3px;
        }

        .pager-btn:disabled{
            opacity: .35;
            cursor: not-allowed;
        }

        .page-indicator{
            min-width: 58px;
            padding: 8px 12px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 999px;
            background: rgba(255, 255, 255, .05);
            color: #fff;
            font-size: 12.5px;
            font-weight: 800;
            text-align: center;
        }

        .page-sep{
            margin: 0 4px;
            color: #6f6f7d;
            font-weight: 500;
        }

        .toast{
            position: fixed;
            left: 50%;
            bottom: 28px;
            z-index: 999;
            max-width: calc(100% - 32px);
            padding: 12px 18px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-left: 3px solid #e50914;
            border-radius: 12px;
            background: #1c1c25;
            color: #fff;
            font-size: 13px;
            line-height: 1.5;
            box-shadow: 0 20px 44px rgba(0, 0, 0, .5);
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, 16px);
            transition: opacity .3s ease, transform .3s ease;
        }

        .toast.show{
            opacity: 1;
            transform: translate(-50%, 0);
        }

        .footer {
            width: 100%;
            background: #0b0b10;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px 6%;
            color: #9898a6;
            font-family: inherit;
        }

        .footer-content {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .footer-content span:first-child {
            font-size: 12px;
            line-height: 1.6;
        }

        .footer-content span:last-child {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .footer-content ion-icon {
            font-size: 19px;
            color: #9898a6;
            cursor: pointer;
        }

        @media (max-width: 900px){
            .navigation{
                flex-wrap: wrap;
                gap: 8px;
                padding: 10px 14px;
            }

            .logo h2{
                font-size: 15px;
            }

            .nav-content{
                width: 100%;
                justify-content: space-between;
                gap: 2px;
            }

            .nav-content li a{
                padding: 8px;
                font-size: 12px;
            }

            .nav-content button{
                margin-left: 2px;
                padding: 8px 11px;
            }

            .hero-section{
                min-height: 82vh;
            }

            .hero-section h1{
                font-size: 1.4rem;
            }

            .hero-section input[type=text]{
                width: min(300px, 62vw);
            }

            .content-section{
                padding: 52px 18px 64px;
                scroll-margin-top: 96px;
            }

            .section-heading{
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                margin-bottom: 22px;
            }

            .table-scroll{
                overflow: visible;
            }

            .schedule-table{
                display: block;
                min-width: 0;
            }

            .schedule-table colgroup,
            .schedule-table thead{
                display: none;
            }

            .schedule-table tbody{
                display: block;
                padding: 6px 14px 16px;
            }

            .schedule-table tbody tr.film-row{
                display: grid;
                grid-template-columns: 1fr auto;
                grid-template-areas:
                    "film film"
                    "schedule studio"
                    "price action";
                gap: 12px 14px;
                margin-top: 12px;
                padding: 14px;
                border: 1px solid rgba(255, 255, 255, .07);
                border-radius: 16px;
                background: #17171f;
            }

            .schedule-table tbody tr.film-row:hover{
                background: #191922;
            }

            .schedule-table tbody td{
                display: block;
                padding: 0;
                border: none;
            }

            .cell-film{
                grid-area: film;
            }

            .cell-schedule{
                grid-area: schedule;
                align-self: center;
            }

            .cell-studio{
                grid-area: studio;
                justify-self: end;
                align-self: center;
            }

            .cell-price{
                grid-area: price;
                align-self: center;
                text-align: left !important;
            }

            .cell-action{
                grid-area: action;
                justify-self: end;
            }

            .poster{
                width: 50px;
                height: 70px;
            }

            .table-footer{
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 14px;
            }

            .table-info{
                text-align: center;
            }

            .menu-control{
                justify-content: space-between;
            }

            .footer-content{
                justify-content: center;
                text-align: center;
            }
        }

        @media (max-width: 420px){
            .pager-btn{
                padding: 9px 12px;
                font-size: 11px;
            }

            .page-indicator{
                min-width: 50px;
                padding: 8px 10px;
                font-size: 11px;
            }

            .btn-book{
                padding: 9px 13px;
            }

            .film-title{
                font-size: 13.5px;
            }
        }
    </style>
</head>
<body>
    <nav class="navigation">
        <div class="logo">
            <h2>Bioskop Stefanus Suka Mundur</h2>
        </div>
        <ul class="nav-content">
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="./pages/film.php">Film</a></li>
            <li><a href="./pages/jadwal.php">Jadwal</a></li>
            <li><a href="./pages/berita.php">Berita</a></li>
            <button type="button" id="keluar" onclick="konfirmasiLogout()"><a href="./logout.php">Keluar</a></button>
        </ul>
    </nav>

    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1><b>Selamat Datang <i><?php echo $username?></i> Di</b></h1>
            <h1><b>Website Bioskop Stefanus Suka Mundur</b></h1>
            <div class="search-container">
                <form action="home.php" method="post">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
                </form>
            </div>
        </div>
    </section>

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

    <footer class="footer">
        <div class="footer-content">
            <span>&copy; <?= date('Y') ?> stairlanggapw. All rights reserved.</span>
            <span>
                <ion-icon name="logo-instagram"></ion-icon> 
                <ion-icon name="logo-facebook"></ion-icon> 
                <ion-icon name="logo-x"></ion-icon>
            </span>
        </div>
    </footer>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script src="./main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>
