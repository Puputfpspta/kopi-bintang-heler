<?php
require 'db.php'; // Pastikan file db.php di-include untuk koneksi database

function addProduct($name, $weight, $price, $stock, $image_url) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO products (name, weight, price, stock, image_url) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sdids", $name, $weight, $price, $stock, $image_url);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false; // atau kembalikan pesan JSON sesuai kebutuhan
    }
    return true;
}

function updateProductStock($id, $stock) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $stock, $id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function decreaseProductStock($id, $stock) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $stock, $id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function getProducts() {
    global $conn;
    try {
        $result = $conn->query("SELECT * FROM products");
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

function getOrdersCount() {
    global $conn;
    try {
        $result = $conn->query("SELECT COUNT(*) as count FROM orders");
        if ($result) {
            return $result->fetch_assoc()['count'];
        } else {
            throw new Exception("Query failed: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function getProductsCount() {
    global $conn;
    try {
        $result = $conn->query("SELECT COUNT(*) as count FROM products");
        if ($result) {
            return $result->fetch_assoc()['count'];
        } else {
            throw new Exception("Query failed: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function getCustomersCount() {
    global $conn;
    try {
        $result = $conn->query("SELECT COUNT(DISTINCT phone) as count FROM orders");
        if ($result) {
            return $result->fetch_assoc()['count'];
        } else {
            throw new Exception("Query failed: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function purchaseProduct($product_id, $quantity) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $product_id, $quantity);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $quantity, $product_id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function addOrder($user_id, $name, $email, $phone, $address, $house_number, $postal_code, $city, $courier) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, phone, address, house_number, postal_code, city, courier, status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("issssssss", $user_id, $name, $email, $phone, $address, $house_number, $postal_code, $city, $courier);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function getOrders() {
    global $conn;
    try {
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Query failed or no data found: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

function getPayments() {
    global $conn;
    try {
        $sql = "SELECT p.id, p.order_id, p.shipping_cost, p.product_total_price, p.total_price, p.payment_proof, p.payment_date, 
                IFNULL(o.user_id, 1) AS user_id
                FROM payments p
                JOIN orders o ON p.order_id = o.id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Query failed or no data found: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

function updateOrderStatus($order_id, $status) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $status, $order_id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function getCompletedOrders() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE status = 'Done'");
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

function moveOrderToHistory($order_id) {
    global $conn;
    try {
        // Ambil data pesanan
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
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
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("issssssss", $order['user_id'], $order['name'], $order['phone'], $order['address'], $order['house_number'], $order['postal_code'], $order['city'], $order['courier'], $order['order_date']);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            // Hapus data dari tabel orders
            $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function getHistory() {
    global $conn;
    try {
        $result = $conn->query("SELECT * FROM riwayat");
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

function getHistoryCount() {
    global $conn;
    try {
        $result = $conn->query("SELECT COUNT(*) as count FROM riwayat");
        if ($result) {
            return $result->fetch_assoc()['count'];
        } else {
            throw new Exception("Query failed: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return 0;
    }
}

function reduceProductStock($product_id, $quantity) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $quantity, $product_id);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function deleteProduct($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
    return true;
}



?>