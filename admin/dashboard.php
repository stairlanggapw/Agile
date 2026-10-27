<?php
    require_once dirname(__DIR__) . '/auth/admin_auth.php';
    require_once dirname(__DIR__) . '/koneksi.php';

    $query = mysqli_query($koneksi, "SELECT id, nama_lengkap, username, email, role, created_at FROM pengguna");

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

        .hero-section h1{
            color: white;
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
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="film.php">Pengaturan Film</a></li>
            <li><a href="jadwal.php">Pengaturan Jadwal</a></li>
            <li><a href="berita.php">Pengaturan Berita</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <button type="button" id="keluar" onclick="konfirmasiLogout()"><a href="../logout.php">Keluar</a></button>
        </ul>
    </nav>

    <section class="hero-section">
        <h1><b>Selamat Datang Di Dashboard Admin <i><?php echo $username?></b></h1>
        <div class="data-users">
            <table>
                <colgroup>
                    <col style="width: 42%;">
                    <col style="width: 19%;">
                    <col style="width: 13%;">
                    <col style="width: 14%;">
                    <col style="width: 12%;">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">username</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="col-role">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="users">
                        <td> </td>
                    </tr>
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