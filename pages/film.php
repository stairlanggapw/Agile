<?php
    require_once __DIR__ . '/../koneksi.php';

    $query = mysqli_query($koneksi, "SELECT judul_film, durasi, genre FROM master_film");
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

        .navigation{
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #b80710;
            padding: 8px 10px;
            top: 0;
        }

        .logo{
            font-size: 15px;
            font-weight: bold;
            color: #fff;
        }

        .nav-content{
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;	
        }

        .nav-content li{
            padding-left: 0;
	        margin-right: 10px;
        }

        .nav-content li a{
            padding: 10px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .nav-content button{
            border: none;
            border-radius: 5px;
            padding: 10px;
            background-color: white;
        }

        .nav-content button a{
            text-decoration: none;
            list-style: none;
            font-size: 12px;
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>
    <nav class="navigation">
        <div class="logo">
            <h2>Bioskop Stefanus Suka Mundur</h2>
        </div>
        <ul class="nav-content">
            <li><a href="../home.php">Dashboard</a></li>
            <li><a href="./film.php">Film</a></li>
            <li><a href="./jadwal.php">Jadwal</a></li>
            <li><a href="./berita.php">Berita</a></li>
            <button><a href="../logout.php">Keluar</a></button>
        </ul>
    </nav>

    <div class="film-content">
        
    </div>
</body>
</html>