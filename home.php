<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT id, username, email FROM users");

    $username = $_SESSION['username'] ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
        }

        body{
            font-family: 'Times New Roman', Times, serif;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Selamat Datang di Web Mu <?php echo $username?></h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr style="text-align: center;">
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        
        while ($data = mysqli_fetch_assoc($query)){
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data['username']); ?></td>
                <td><?= htmlspecialchars($data['email']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <br>

    <button><a href="logout.php">Keluar</a></button>
</body>
</html>