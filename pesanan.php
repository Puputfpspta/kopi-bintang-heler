<?php
session_start();
include 'db.php';
include 'function.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pesanan
$orders = getOrders();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    if ($status === 'Done') {
        // Pindahkan pesanan ke riwayat
        moveOrderToHistory($order_id);
    } else {
        // Update status pesanan
        updateOrderStatus($order_id, $status);
    }
    
    header("Location: pesanan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan | Kopi Bintang Heler</title>
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
                    <a href="pesanan.php" class="active"><span class="fas fa-shopping-cart"></span>
                        <span>Pesanan</span></a>
                </li>
                <li>
                    <a href="riwayat.php"><span class="fas fa-history"></span>
                        <span>Riwayat</span></a>
                </li>
                <li>
                    <a href="pembayaran.php"><span class="fas fa-money-check-alt"></span>
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
                Kelola Pesanan
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
                            <h3>Kelola Pesanan</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>User ID</td>
                                            <td>Nama</td>
                                            <td>No. Handphone</td>
                                            <td>Alamat</td>
                                            <td>No. Rumah</td>
                                            <td>Kode Pos</td>
                                            <td>Kota Tujuan</td>
                                            <td>Kurir</td>
                                            <td>Status</td>
                                            <td>Tanggal Pesanan</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($orders)): ?>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['address']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['house_number']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['postal_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['city']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['courier']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                            <select name="status" onchange="this.form.submit()">
                                                                <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Done" <?php echo $order['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                                                            </select>
                                                            <input type="hidden" name="update_status" value="1">
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="12" style="text-align:center;">Tidak ada pesanan.</td>
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
