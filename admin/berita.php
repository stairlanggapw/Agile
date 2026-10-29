<?php

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
</body>
</html>