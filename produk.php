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

// Tambah produk
if (isset($_POST['tambah_produk'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "INSERT INTO produk (nama_produk, kategori, harga, status) VALUES ('$nama_produk', '$kategori', '$harga', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Produk baru berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus produk
if (isset($_POST['hapus_produk'])) {
    $id_produk = $_POST['id_produk'];

    $sql = "DELETE FROM produk WHERE id_produk='$id_produk'";

    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data produk
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Kopi | Kopi Bintang Heler</title>
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
                    <a href="produk.php" class="active"><span class="fas fa-coffee"></span>
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
                Kelola Produk
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
                            <h3>Kelola Produk Kopi</h3>
                            <button onclick="document.getElementById('modalTambah').style.display='block'">Tambah Produk <span class="fas fa-plus"></span></button>
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
                                            <td>Status</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $row['id_produk']; ?></td>
                                                    <td><?php echo $row['nama_produk']; ?></td>
                                                    <td><?php echo $row['kategori']; ?></td>
                                                    <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                                    <td><span class="status <?php echo strtolower($row['status']); ?>"></span> <?php echo $row['status']; ?></td>
                                                    <td>
                                                        <form action="produk.php" method="post" style="display:inline-block;">
                                                            <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                                                            <button type="submit" name="hapus_produk" class="button">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6">Tidak ada data produk</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah Produk -->
                <div id="modalTambah" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="document.getElementById('modalTambah').style.display='none'">&times;</span>
                        <h3>Tambah Produk Baru</h3>
                        <form action="produk.php" method="post">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" id="nama_produk" name="nama_produk" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" id="kategori" name="kategori" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" id="harga" name="harga" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" required>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Habis">Habis</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah_produk" class="button">Tambah Produk</button>
                        </form>
                    </div>
                </div>

                <style>
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgb(0,0,0);
                    background-color: rgba(0,0,0,0.4);
                    padding-top: 60px;
                }

                .modal-content {
                    background-color: #fefefe;
                    margin: 5% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                }

                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
                </style>

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
