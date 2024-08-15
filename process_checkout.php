<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Ganti 'database_name' dengan nama database yang benar
    $conn = new mysqli("localhost", "u140589105_kopi", "Kopi12345.", "u140589105_kopi");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Ambil `order_id` dari POST
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : null;
    
    if (!$order_id) {
        throw new Exception("Order ID tidak ditemukan.");
    }

    // Query untuk mendapatkan user_id dari tabel orders berdasarkan order_id
    $query = "SELECT user_id FROM orders WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && isset($row['user_id'])) {
        $user_id = $row['user_id'];
    } else {
        echo json_encode(["success" => false, "message" => "User ID tidak ditemukan untuk order_id ini."]);
        exit();
    }

    // Ambil data lain dari POST
    $shipping_cost = isset($_POST['shipping_cost']) ? (int)$_POST['shipping_cost'] : null;
    $product_total_price = isset($_POST['product_total_price']) ? (int)$_POST['product_total_price'] : null;
    $total_price = isset($_POST['total_price']) ? (int)$_POST['total_price'] : null;
    $payment_proof = isset($_FILES['payment-proof']['name']) ? $_FILES['payment-proof']['name'] : null;
    $cart = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : null;

    if (!$shipping_cost || !$product_total_price || !$total_price || !$payment_proof || !$cart) {
        throw new Exception("Data tidak lengkap.");
    }

    // Upload file bukti pembayaran
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($payment_proof);

    if (!move_uploaded_file($_FILES["payment-proof"]["tmp_name"], $target_file)) {
        throw new Exception("Gagal meng-upload file bukti pembayaran.");
    }

    // Masukkan data ke tabel payments
    $query = "INSERT INTO payments (user_id, order_id, shipping_cost, product_total_price, total_price, payment_proof, payment_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiiiss", $user_id, $order_id, $shipping_cost, $product_total_price, $total_price, $payment_proof);

    if ($stmt->execute()) {
        // Kurangi stok produk di tabel products berdasarkan cart
        foreach ($cart as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $update_stock_query = "UPDATE products SET stock = stock - ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_stock_query);
            if (!$update_stmt) {
                throw new Exception("Error preparing update statement: " . $conn->error);
            }
            $update_stmt->bind_param("ii", $quantity, $product_id);
            if (!$update_stmt->execute()) {
                throw new Exception("Gagal mengurangi stok: " . $update_stmt->error);
            }
            $update_stmt->close();
        }

        echo json_encode([
            "success" => true,
            "message" => "Pembayaran berhasil disimpan dan stok produk telah dikurangi.",
            "cart" => $cart // Mengembalikan data keranjang untuk konfirmasi di frontend
        ]);
    } else {
        throw new Exception("Gagal menyimpan pembayaran: " . $stmt->error);
    }

} catch (Exception $e) {
    // Tangkap semua error dan kembalikan dalam format JSON
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    // Tutup statement dan koneksi
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
