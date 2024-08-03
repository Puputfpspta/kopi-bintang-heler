<?php
session_start();
include 'db.php';
include 'function.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pembayaran
$payments = getPayments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran | Kopi Bintang Heler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="fab fa-accusoft"></span> <span>Kopi Bintang Heler</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="admin.php"><span class="fas fa-coffee"></span>
                        <span>Produk</span></a>
                </li>
                <li>
                    <a href="pesanan.php"><span class="fas fa-shopping-cart"></span>
                        <span>Pesanan</span></a>
                </li>
                <li>
                    <a href="riwayat.php"><span class="fas fa-history"></span>
                        <span>Riwayat</span></a>
                </li>
                <li>
                    <a href="pembayaran.php" class="active"><span class="fas fa-money-check-alt"></span>
                        <span>Pembayaran</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="fas fa-sign-out-alt"></span>
                        <span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="fas fa-bars"></span>
                </label>
                Pembayaran
            </h2>

            <div class="user-wrapper">
                <img src="img/bag.jpg" width="40px" height="40px" alt="Admin">
                <div>
                    <h4>Admin Kopi Bintang Heler</h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Kelola Pembayaran</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>User ID</td>
                                            <td>Order ID</td>
                                            <td>Ongkos Kirim</td>
                                            <td>Harga Produk</td>
                                            <td>Total Harga</td>
                                            <td>Bukti Pembayaran</td>
                                            <td>Tanggal Pembayaran</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($payments)): ?>
                                            <?php foreach ($payments as $payment) : ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($payment['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($payment['user_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($payment['order_id']); ?></td>
                                                    <td>Rp. <?php echo number_format($payment['shipping_cost'], 0, ',', '.'); ?></td>
                                                    <td>Rp. <?php echo number_format($payment['product_total_price'], 0, ',', '.'); ?></td>
                                                    <td>Rp. <?php echo number_format($payment['total_price'], 0, ',', '.'); ?></td>
                                                    <td>
                                                        <a href="uploads/<?php echo htmlspecialchars($payment['payment_proof']); ?>" target="_blank">Lihat Bukti</a>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" style="text-align:center;">Tidak ada pembayaran.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
