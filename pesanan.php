<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kopi_bintang_heler');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pesanan
$sql = "SELECT * FROM pesanan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan | Kopi Bintang Heler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="fab fa-accusoft"></span> <span>Kopi Bintang Heler</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="produk.php"><span class="fas fa-coffee"></span>
                        <span>Produk</span></a>
                </li>
                <li>
                    <a href="pesanan.php" class="active"><span class="fas fa-shopping-cart"></span>
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
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>54</h1>
                        <span>Produk</span>
                    </div>
                    <div>
                        <span class="fas fa-coffee"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>79</h1>
                        <span>Pesanan</span>
                    </div>
                    <div>
                        <span class="fas fa-shopping-cart"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>124</h1>
                        <span>Pelanggan</span>
                    </div>
                    <div>
                        <span class="fas fa-user"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>6</h1>
                        <span>Review</span>
                    </div>
                    <div>
                        <span class="fas fa-comment"></span>
                    </div>
                </div>
            </div>

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
                                            <td>ID Pesanan</td>
                                            <td>Nama Pelanggan</td>
                                            <td>Tanggal Pesanan</td>
                                            <td>Total Harga</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id_pesanan']; ?></td>
                                            <td><?php echo $row['nama_pelanggan']; ?></td>
                                            <td><?php echo $row['tanggal_pesanan']; ?></td>
                                            <td>Rp. <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const toggle = document.getElementById('nav-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>
