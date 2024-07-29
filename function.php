<?php
require 'db.php'; // Pastikan file db.php di-include untuk koneksi database

function addProduct($name, $weight, $price, $stock, $image_url) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO products (name, weight, price, stock, image_url) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sdids", $name, $weight, $price, $stock, $image_url);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function updateProductStock($id, $stock) {
    global $conn;
    $stmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $stock, $id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function decreaseProductStock($id, $stock) {
    global $conn;
    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $stock, $id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM products");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getOrdersCount() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as count FROM orders");
    if ($result) {
        return $result->fetch_assoc()['count'];
    } else {
        return 0;
    }
}

function getProductsCount() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    if ($result) {
        return $result->fetch_assoc()['count'];
    } else {
        return 0;
    }
}

function getCustomersCount() {
    global $conn;
    $result = $conn->query("SELECT COUNT(DISTINCT phone) as count FROM orders");
    if ($result) {
        return $result->fetch_assoc()['count'];
    } else {
        return 0;
    }
}

function purchaseProduct($product_id, $quantity) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity) VALUES (?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $product_id, $quantity);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();

    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $quantity, $product_id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function addOrder($user_id, $name, $email, $phone, $address, $house_number, $postal_code, $city, $courier) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, phone, address, house_number, postal_code, city, courier, status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("issssssss", $user_id, $name, $email, $phone, $address, $house_number, $postal_code, $city, $courier);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function getOrders() {
    global $conn;
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);
    $orders = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    return $orders;
}

function getPayments() {
    global $conn;
    $result = $conn->query("SELECT * FROM payments");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function updateOrderStatus($order_id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("si", $status, $order_id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

function getCompletedOrders() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE status = 'Done'");
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $orders;
}

function moveOrderToHistory($order_id) {
    global $conn;

    // Ambil data pesanan
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if ($order) {
        // Masukkan data ke tabel riwayat dengan status 'Done'
        $stmt = $conn->prepare("INSERT INTO riwayat (user_id, name, phone, address, house_number, postal_code, city, courier, status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Done', ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("issssssss", $order['user_id'], $order['name'], $order['phone'], $order['address'], $order['house_number'], $order['postal_code'], $order['city'], $order['courier'], $order['order_date']);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        // Hapus data dari tabel orders
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $order_id);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    }
}

function getHistory() {
    global $conn;
    $result = $conn->query("SELECT * FROM riwayat");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHistoryCount() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as count FROM riwayat");
    if ($result) {
        return $result->fetch_assoc()['count'];
    } else {
        return 0;
    }
}

function reduceProductStock($product_id, $quantity) {
    global $conn;
    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $quantity, $product_id);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log('Database error: ' . $conn->error);
    }
}
?>
