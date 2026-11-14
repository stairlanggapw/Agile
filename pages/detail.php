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

        .top-detail{
            display: flex;
            justify-content: start;
            align-items: center;
            padding: 15px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        }

        .top-detail button{
            padding: 5px 8px;
            background-color: #b80710;
            border: none;
            border-radius: 5px;
        }

        .top-detail button a{
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .top-detail h4{
            margin-left: 10px;
        }

        .detail-container{
            display: flex;
            align-items: center;
            margin: 15px;
            gap: 20px;
        }

        .poster{
            height: 500px;
            border: 5px solid #b80710;
            border-radius: 20px;
        }

        .film-info{
            margin: 0;
            padding: 10px;
        }

        .schedule{
            margin-top: 30px;
        }

        .schedule-item{
            margin-top: 10px;
        }

        .btn-payment {
            margin-top: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: #fff;
            color: #333;
            cursor: pointer;
            transition: 
                background-color 0.3s ease,
                box-shadow 0.3s ease,
                transform 0.2s ease;
        }

        .btn-payment:hover {
            background-color: #ebebeb;
            box-shadow: 0 4px 12px rgba(152, 152, 166, 0.4);
            transform: translateY(-2px);
        }

        .btn-payment:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(152, 152, 166, 0.3);
        }

        .btn-trailer{
            margin-top: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: #fff;
            color: #333;
            cursor: pointer;
            transition: 
                background-color 0.3s ease,
                box-shadow 0.3s ease,
                transform 0.2s ease;
        }

        .btn-trailer:hover{
            background-color: #ebebeb;
            box-shadow: 0 4px 12px rgba(152, 152, 166, 0.4);
            transform: translateY(-2px);
        }

        .btn-trailer:active{
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(152, 152, 166, 0.3);
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

        .purchaseModal,
        .successModal{
            font-family: "Manrope", sans-serif;
            position:fixed;
            inset:0;
            display:none;
            justify-content:center;
            align-items:center;
            padding:20px;
            background:rgba(0,0,0,.65);
            backdrop-filter:blur(10px);
            z-index:9999;
        }

        .modalCard{
            width:100%;
            max-width:720px;
            background: #434343;
            border: none;
            padding:40px;
            position:relative;
            animation:popup .35s;
        }

        .closeModal{
            position:absolute;
            top:20px;
            right:25px;
            font-size:35px;
            cursor:pointer;
        }

        .modalSubtitle{
            color:#777;
            margin-bottom:30px;
        }

        .inputGrid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
        }

        .inputGroup{
            display:flex;
            flex-direction:column;
            margin-bottom:20px;
        }

        .inputGroup label{
            margin-bottom:8px;
            font-weight:600;
        }

        .inputGroup input,
        .inputGroup textarea,
        .inputGroup select{

            width:100%;
            padding:15px;
            border-radius:12px;
            border:1px solid #ddd;
            outline:none;
        }

        .inputGroup textarea{
            resize:none;
        }

        .purchaseBtn{
            width:100%;
            padding:18px;
            border:none;
            border-radius:50px;
            background:#b80710;
            color:white;
            font-size:17px;
            cursor:pointer;
        }

        .purchaseBtn:hover{
            background:#e03f47ff;
        }

        .successCard{
            width:100%;
            max-width:520px;
            background:#ffffff;
            border-radius:25px;
            padding:40px;
            position:relative;
            text-align:center;
            animation:popup .35s;
            box-shadow:0 20px 50px rgba(0,0,0,.25);
            overflow:hidden;
        }

        .successCard::before{
            content:"";
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:6px;
            background:linear-gradient(
                90deg,
                #2E7D32,
                #43A047,
                #66BB6A
            );
        }

        .successIcon{
            display:flex;
            justify-content:center;
            margin-bottom:20px;
        }

        .successGif{
            width:150px;
            display:block;
        }

        .successCard h2{
            font-size:34px;
            color:#2E7D32;
            margin-bottom:10px;
        }

        .successText{
            color:#666;
            margin-bottom:30px;
        }

        .paymentInfo,
        .productInfo{
            background:#f8f8f8;
            border-radius:18px;
            padding:20px;
            margin-bottom:20px;
            text-align:left;
        }

        .paymentInfo h3,
        .productInfo h3{
            color:#2E7D32;
            margin-bottom:15px;
        }

        .detailItem{
            display:flex;
            justify-content:space-between;
            margin:12px 0;
        }

        .paid{
            color:#2E7D32;
            font-weight:bold;
        }

        #closeSuccess{
            width:100%;
            padding:15px;
            border:none;
            border-radius:50px;
            background:#2E7D32;
            color:white;
            font-size:16px;
            cursor:pointer;
        }

        #closeSuccess:hover{
            background:#256628;
        }

        @media(max-width:992px){

            .pricingCards{
                grid-template-columns:1fr;
                max-width:500px;
                margin:auto;
            }

            .activeCard{
                transform:none;
            }

            .paymentTitle h1{
                font-size:44px;
            }

        }

        @media(max-width:768px){

            .paymentSection{
                padding:30px 20px;
            }

            .paymentTitle h1{
                font-size:34px;
            }

            .buttonChips{
                width:100%;
                max-width:300px;
            }

            .switch{
                width:calc(50% - 6px);
            }

            .modalCard,
            .successCard{
                padding:25px;
            }

            .inputGrid{
                grid-template-columns:1fr;
            }

            .successGif{
                width:120px;
            }

        }
    </style>
</head>
<body>
    <div class="top-detail">
        <button><a href="../home.php">Back</a></button>
        <h4>Detail Film</h4>
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

                            <button id="btn-payment" class="btn-payment">Pembayaran</button>
                            <button id="btn-trailer" class="btn-trailer">Tonton Trailer</button>
                        </div>

                <?php endwhile; ?>
                <?php else: ?>
                     <p>Belum ada jadwal tayang untuk film ini.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

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

    <div class="purchaseModal" id="purchaseModal">
        <div class="modalCard">
            <span class="closeModal">&times;</span>
            <h2>Selesaikan Pembayaran</h2>
            <p class="modalSubtitle">
                Pesan Tiket Bioskop Sekarang!
            </p>
            <form id="purchaseForm">
                <div class="inputGroup">
                    <label>Nama Panjang</label>
                    <input
                        type="text"
                        id="customerName"
                        placeholder="Nama Anda"
                        required>
                </div>
                <div class="inputGrid">
                    <div class="inputGroup">
                        <label>Email</label>
                        <input
                            type="email"
                            id="customerEmail"
                            placeholder="Example@email.com"
                            required>
                    </div>
                    <div class="inputGroup">
                        <label>Nomor Telepon</label>
                        <input
                            type="tel"
                            id="customerPhone"
                            placeholder="+62 *********"
                            required>
                    </div>
                </div>

                <div class="inputGroup">
                    <label>Payment Method</label>
                    <select id="bank">
                        <option disabled selected>
                            Select Bank
                        </option>
                        <option>BCA</option>
                        <option>Mandiri</option>
                        <option>BNI</option>
                        <option>BRI</option>
                        <option>CIMB Niaga</option>
                    </select>
                </div>
                <button class="purchaseBtn" type="submit">
                    Pesan Sekarang
                </button>
            </form>
        </div>
    </div>

    <script src="../main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</body>
</html>