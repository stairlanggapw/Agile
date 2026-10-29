<?php
    require_once dirname(__DIR__) . '/auth/admin_auth.php';
    require_once dirname(__DIR__) . '/koneksi.php';

    $sql = "SELECT id, nama_lengkap, username, email, role, created_at FROM pengguna";
    $query = mysqli_query($koneksi, $sql);

    if(!$query){
        die("Query gagal: ".mysqli_error($koneksi));
    }

    $username = $_SESSION['username'] ?? 'pengguna';
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
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .hero-top{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-top h1{
            padding-left: 24px;
            color: white;
        }

        .hero-top button{
            margin-right: 24px;
            padding: 6px 10px;
            border-radius: 5px;
            background-color: #06279d;
            border: none;
        }

        .hero-top button a{
            text-decoration: none;
            color: white;
        }     
        .data-users {
            width: 100%;
            margin: 24px auto;
            padding: 0 24px;
            overflow-x: auto;
        }

        .data-users table {
            width: 100%;
            border-collapse: collapse;
            background: #121218;
            color: #f1f1f5;
            text-align: left;
        }

        .data-users th,
        .data-users td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
        }

        .data-users th {
            background: #b80710;
            color: #fff;
            font-weight: 700;
        }

        .data-users td {
            color: #d1d1da;
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

    <section class="hero-section">
        <div class="hero-top">
            <h1><b>Selamat Datang Di Dashboard Admin <i><?php echo $username?></b></h1>
            <button><a href="users.php">Lihat Detail</a></button>  
        </div>      
        <div class="data-users">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($d = mysqli_fetch_assoc($query)): ?>
                            <tr class="users-row">
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($d['nama_lengkap']); ?></td>
                                <td><?= htmlspecialchars($d['username']); ?></td>
                                <td><?= htmlspecialchars($d['email']); ?></td>
                                <td><?= htmlspecialchars($d['role']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Belum ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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

    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</body>
</html>