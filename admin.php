<?php
session_start();
include 'db.php';
include 'function.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Menangani penambahan produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image_url = $_POST['image_url'];

    addProduct($name, $weight, $price, $stock, $image_url);

    header("Location: admin.php");
    exit();
}

// Menangani penambahan stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $id = $_POST['id'];
    $stock = $_POST['stock'];

    updateProductStock($id, $stock);

    header("Location: admin.php");
    exit();
}

// Menangani pengurangan stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decrease_stock'])) {
    $id = $_POST['id'];
    $stock = $_POST['stock'];

    decreaseProductStock($id, $stock);

    header("Location: admin.php");
    exit();
}

// Fetch data for the admin dashboard
$products = getProducts();
$ordersCount = getOrdersCount();
$productsCount = getProductsCount();
$customersCount = getCustomersCount();
$historyCount = getHistoryCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kopi Bintang Heler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .cards-horizontal {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .card-single {
            background: #333;
            padding: 20px;
            border-radius: 5px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 280px;
            color: #fff;
        }

        .card-single div:first-child {
            flex-grow: 1;
        }

        .card-single div:last-child {
            font-size: 50px;
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
                    <a href="admin.php" class="active"><span class="fas fa-coffee"></span>
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
                Admin Dashboard
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
            <div class="cards-horizontal">
                <div class="card-single">
                    <div>
                        <h1><?php echo htmlspecialchars($productsCount); ?></h1>
                        <span>Produk</span>
                    </div>
                    <div>
                        <span class="fas fa-coffee"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo htmlspecialchars($ordersCount); ?></h1>
                        <span>Pesanan</span>
                    </div>
                    <div>
                        <span class="fas fa-shopping-cart"></span>
                    </div>
                </div>
            </div>

            <div class="cards-horizontal">
                <div class="card-single">
                    <div>
                        <h1><?php echo htmlspecialchars($customersCount); ?></h1>
                        <span>Pelanggan</span>
                    </div>
                    <div>
                        <span class="fas fa-user"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo htmlspecialchars($historyCount); ?></h1>
                        <span>Riwayat</span>
                    </div>
                    <div>
                        <span class="fas fa-history"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Kelola Produk Kopi</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nama Produk</td>
                                            <td>Berat</td>
                                            <td>Harga</td>
                                            <td>Stok</td>
                                            <td>Gambar</td>
                                            <td>Tambah Stok</td>
                                            <td>Kurangi Stok</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product) : ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['weight']); ?></td>
                                                    <td>Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                                    <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" width="100" height="100"></td>
                                                    <td>
                                                        <form action="admin.php" method="post" style="display:inline;">
                                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                                            <input type="number" name="stock" min="1" required style="width: 70px;">
                                                            <button type="submit" name="update_stock" class="button">Tambah</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="admin.php" method="post" style="display:inline;">
                                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                                            <input type="number" name="stock" min="1" required style="width: 70px;">
                                                            <button type="submit" name="decrease_stock" class="button">Kurangi</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">Tidak ada produk ditemukan.</td>
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

    <div id="addProductForm" style="display: none;">
        <form action="admin.php" method="post">
            <label for="name">Nama Produk:</label><br>
            <input type="text" id="name" name="name" required style="width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"><br>
            <label for="weight">Berat:</label><br>
            <input type="number" id="weight" name="weight" required style="width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"><br>
            <label for="price">Harga:</label><br>
            <input type="number" id="price" name="price" required style="width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"><br>
            <label for="stock">Stok:</label><br>
            <input type="number" id="stock" name="stock" required style="width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"><br>
            <label for="image_url">Gambar URL:</label><br>
            <input type="text" id="image_url" name="image_url" required style="width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;"><br><br>
            <input type="submit" name="add_product" value="Submit" class="button">
        </form>
    </div>

    <script>
        // Script untuk menampilkan form tambah produk
        function showAddProductForm() {
            document.getElementById('addProductForm').style.display = 'block';
        }
    </script>
</body>
</html>
