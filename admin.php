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
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $status = $_POST['status'];

    addProduct($nama, $kategori, $harga, $status, $stok);

    header("Location: admin.php");
    exit();
}

// Menangani penambahan stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $id = $_POST['id'];
    $stok = $_POST['stok'];

    updateProductStock($id, $stok);

    header("Location: admin.php");
    exit();
}

// Fetch data for the admin dashboard
$products = getProducts();
$ordersCount = getOrdersCount();
$productsCount = getProductsCount();
$customersCount = getCustomersCount();
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
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo $productsCount; ?></h1>
                        <span>Produk</span>
                    </div>
                    <div>
                        <span class="fas fa-coffee"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo $ordersCount; ?></h1>
                        <span>Pesanan</span>
                    </div>
                    <div>
                        <span class="fas fa-shopping-cart"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo $customersCount; ?></h1>
                        <span>Pelanggan</span>
                    </div>
                    <div>
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Kelola Produk Kopi</h3>
                            <button onclick="document.getElementById('addProductForm').style.display='block'">Tambah Produk <span class="fas fa-plus"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nama Produk</td>
                                            <td>Kategori</td>
                                            <td>Harga</td>
                                            <td>Stok</td>
                                            <td>Status</td>
                                            <td>Tambah Stok</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) : ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                                <td><?php echo htmlspecialchars($product['nama']); ?></td>
                                                <td><?php echo htmlspecialchars($product['kategori']); ?></td>
                                                <td>Rp. <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
                                                <td><?php echo htmlspecialchars($product['stok']); ?></td>
                                                <td><span class="status <?php echo ($product['status'] == 'Tersedia' ? 'green' : 'red'); ?>"></span> <?php echo htmlspecialchars($product['status']); ?></td>
                                                <td>
                                                    <form action="admin.php" method="post" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                                        <input type="number" name="stok" min="1" required>
                                                        <button type="submit" name="update_stock" class="button">Tambah</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
            <label for="nama">Nama Produk:</label><br>
            <input type="text" id="nama" name="nama" required><br>
            <label for="kategori">Kategori:</label><br>
            <input type="text" id="kategori" name="kategori" required><br>
            <label for="harga">Harga:</label><br>
            <input type="number" id="harga" name="harga" required><br>
            <label for="stok">Stok:</label><br>
            <input type="number" id="stok" name="stok" required><br>
            <label for="status">Status:</label><br>
            <input type="text" id="status" name="status" required><br><br>
            <input type="submit" name="add_product" value="Submit">
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
