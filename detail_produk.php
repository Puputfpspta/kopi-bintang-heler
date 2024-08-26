<?php
session_start();
include 'db.php';
include 'function.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : null;

if (!$order_id) {
    echo "Order ID tidak ditemukan.";
    exit();
}

// Ambil data pesanan berdasarkan order_id
$query = "SELECT products FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit();
}

// Decode produk dari JSON
$products = json_decode($order['products'], true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk yang Dibeli | Kopi Bintang Heler</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h2>Detail Produk yang Dibeli</h2>

        <?php if (!empty($products)): ?>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100" height="100">
                        <p>Nama: <?php echo htmlspecialchars($product['name']); ?></p>
                        <p>Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada produk yang dibeli.</p>
        <?php endif; ?>

        <a href="pesanan.php" class="btn btn-secondary">Kembali ke Pesanan</a>
    </div>
</body>
</html>
