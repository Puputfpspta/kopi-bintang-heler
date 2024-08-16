<?php
if (isset($_GET['file']) && isset($_GET['order_id'])) {
    $file = htmlspecialchars($_GET['file']);
    $order_id = htmlspecialchars($_GET['order_id']);
} else {
    die('Akses tidak valid');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Bukti Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .image-container {
            max-width: 80%;
            max-height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ffcc00;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="uploads/<?php echo $file; ?>" alt="Bukti Pembayaran">
    </div>
    <a href="pembayaran.php?highlight_id=<?php echo $order_id; ?>" class="back-button">Kembali</a>
</body>
</html>
