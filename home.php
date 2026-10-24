<?php
    require_once __DIR__ . '/auth/auth.php';
    require_once __DIR__ . '/koneksi.php';

    $query = mysqli_query($koneksi, "SELECT id, username, email FROM pengguna");

    $username = $_SESSION['username'] ?? 'Pengguna';
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
            background-color: #333;
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
            background-color: blue;
        }

        .nav-content button a{
            text-decoration: none;
            list-style: none;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .hero-section{
            position: relative;
            width: 100%;
            min-height: 80vh;
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

        .hero-content{
            position: relative;
            z-index: 2;
        }

        .hero-section h1{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            color: #fff;
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
            border-radius: 4px 0 0 4px; 
            outline: none;
            width: 300px;            
        }

        .hero-section .search-container button {
            padding: 10px 20px;
            background: #e50914;     
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 0 4px 4px 0; 
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .hero-section .search-container button:hover {
            background: #b80710;    
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
            <button><a href="logout.php">Keluar</a></button>
        </ul>
    </nav>

    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1><b>Selamat Datang <?php echo $username?> Di</b></h1>
            <h1><b>Website Bioskop Stefanus Suka Mundur</b></h1>
            <div class="search-container">
                <form action="home.php" method="post">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
                </form>
            </div>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>