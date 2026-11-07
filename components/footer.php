<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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

</body>
</html>