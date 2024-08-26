<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Koneksi ke database
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
    
    // Pastikan direktori uploads ada dan bisa ditulis
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // Cek error saat upload file
    if ($_FILES['payment-proof']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error uploading file: " . $_FILES['payment-proof']['error']);
    }

    // Menggunakan nama file asli tanpa pengacakan
    $target_file = $target_dir . basename($_FILES['payment-proof']['name']);

    if (!move_uploaded_file($_FILES["payment-proof"]["tmp_name"], $target_file)) {
        throw new Exception("Gagal meng-upload file bukti pembayaran.");
    } else {
        // Logging untuk memastikan file di-upload
        error_log("File berhasil di-upload ke: " . $target_file);
    }

    // Masukkan data ke tabel payments
    $query = "INSERT INTO payments (user_id, order_id, shipping_cost, product_total_price, total_price, payment_proof, payment_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiiiss", $user_id, $order_id, $shipping_cost, $product_total_price, $total_price, $payment_proof);

    if ($stmt->execute()) {
        
        // Masukkan produk ke dalam kolom 'products' di tabel orders
        $products_json = json_encode($cart);
        $update_order_query = "UPDATE orders SET products = ? WHERE id = ?";
        $update_order_stmt = $conn->prepare($update_order_query);
        if (!$update_order_stmt) {
            throw new Exception("Error preparing update statement for orders: " . $conn->error);
        }
        $update_order_stmt->bind_param("si", $products_json, $order_id);
        if (!$update_order_stmt->execute()) {
            throw new Exception("Gagal menyimpan produk dalam pesanan: " . $update_order_stmt->error);
        }
        $update_order_stmt->close();
        
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
