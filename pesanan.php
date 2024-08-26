<?php
session_start();
include 'db.php';
include 'function.php';

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];


// Ambil data pesanan
$orders = getOrders();
$highlightId = isset($_GET['highlight_id']) ? $_GET['highlight_id'] : null;

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
    <style>
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .highlighted-row {
            background-color: #ffcc00;
        }

        .table-responsive table {
            font-size: 0.8rem;
        }

        .table-responsive th,
        .table-responsive td {
            padding: 0.4rem 0.5rem;
            text-align: left;
        }

        .table-responsive td select {
            padding: 0.2rem;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .table-responsive table {
                font-size: 0.75rem;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.3rem 0.4rem;
            }

            .table-responsive td select {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .table-responsive table {
                font-size: 0.7rem;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.3rem 0.4rem;
            }

            .table-responsive td select {
                font-size: 0.7rem;
            }
        }

        /* CSS untuk modal */
        #productsModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #productsModalContent {
            background-color: #333;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        #productsModalContent h3 {
            color: #ffc107;
            margin-bottom: 20px;
        }

        #productsList {
            color: white;
            text-align: left;
            margin-bottom: 20px;
        }

        #productsList img {
            display: block;
            margin: 5px 0;
            max-width: 100px;
        }

        .btn-close-modal {
            background-color: #ffc107;
            color: black;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-close-modal:hover {
            background-color: #e0a800;
        }

        /* Tombol "Produk yang Dibeli" */
        .btn-show-products {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-show-products:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="fab fa-accusoft"></span> <span>Kopi Bintang Heler</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="admin.php"><img src="img/coffebean.png" width="24px" height="24px" alt="kopi">
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
                                            <td>Order ID</td>
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
                                            <td>Produk yang Dibeli</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($orders)): ?>
                                            <?php foreach ($orders as $order): ?>
                                                <tr id="order-<?php echo $order['id']; ?>" <?php if ($order['id'] == $highlightId) echo 'class="highlighted-row"'; ?>>
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
                                                        <?php if (!empty($order['products'])): ?>
                                                            <button class="btn-show-products" onclick="showProductsModal('<?php echo htmlspecialchars($order['products']); ?>')">Produk yang Dibeli</button>
                                                        <?php else: ?>
                                                            Tidak ada produk.
                                                        <?php endif; ?>
                                                    </td>
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
                                                <td colspan="13" style="text-align:center;">Tidak ada pesanan.</td>
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

    <div id="productsModal" style="display:none;">
        <div id="productsModalContent">
            <h3>Produk yang Dibeli</h3>
            <div id="productsList"></div>
            <button class="btn-close-modal" onclick="closeProductsModal()">Kembali</button>
        </div>
    </div>

    <script>
        function showProductsModal(productsJson) {
            var products = JSON.parse(productsJson);

            var productsList = document.getElementById('productsList');
            productsList.innerHTML = '';

            products.forEach(function(product) {
                var productElement = document.createElement('div');
                productElement.innerHTML = '<img src="' + product.imgSrc + '" alt="' + product.name + '">' +
                    '<p>' + product.name + ' (x' + product.quantity + ')</p>';
                productsList.appendChild(productElement);
            });

            document.getElementById('productsModal').style.display = 'flex';
        }

        function closeProductsModal() {
            document.getElementById('productsModal').style.display = 'none';
        }

        <?php if ($highlightId): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var element = document.getElementById("order-<?php echo $highlightId; ?>");
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        <?php endif; ?>
    </script>
</body>

</html>
