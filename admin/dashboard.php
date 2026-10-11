<?php
    require_once dirname(__DIR__) . '/admin_auth.php';
    require_once dirname(__DIR__) . '/koneksi.php';

    $query = mysqli_query($koneksi, "SELECT id, username, email FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>TES HALO HALO</h1>
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
    <button><a href="../logout.php">Keluar</a></button>
</body>
</html>