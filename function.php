<?php

// Fungsi untuk mengambil data produk dari database
function getProducts() {
    global $conn;
    $sql = "SELECT id, nama, kategori, harga, status, stok FROM produk";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil data pesanan dari database
function getOrders() {
    global $conn;
    $sql = "SELECT id, nama_pelanggan, jumlah, status, tanggal_pesanan FROM pesanan";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil data pembayaran dari database
function getPayments() {
    global $conn;
    $sql = "SELECT id_pembayaran, nama_pelanggan, jumlah, bukti, tanggal_pembayaran FROM pembayaran";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk menghitung jumlah pesanan
function getOrdersCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM pesanan";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_assoc()['total'];
}

// Fungsi untuk menghitung jumlah produk
function getProductsCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM produk";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_assoc()['total'];
}

// Fungsi untuk menghitung jumlah pelanggan
function getCustomersCount() {
    global $conn;
    $sql = "SELECT COUNT(DISTINCT nama_pelanggan) AS total FROM pesanan";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_assoc()['total'];
}

// Fungsi untuk menambah produk baru
function addProduct($nama, $kategori, $harga, $status, $stok) {
    global $conn;
    $sql = "INSERT INTO produk (nama, kategori, harga, status, stok) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssisi", $nama, $kategori, $harga, $status, $stok);
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

// Fungsi untuk memperbarui stok produk
function updateProductStock($id, $stok) {
    global $conn;
    $sql = "UPDATE produk SET stok = stok + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ii", $stok, $id);
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

// Fungsi untuk mengurangi stok produk
function reduceProductStock($id, $stok) {
    global $conn;
    $sql = "UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("iii", $stok, $id, $stok);
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

?>
