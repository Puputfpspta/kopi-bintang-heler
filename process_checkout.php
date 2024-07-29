<?php
session_start();
include 'db.php';

function processCheckout($conn) {
    if (isset($_POST['order_id']) && isset($_POST['shipping_cost']) && isset($_POST['product_total_price']) && isset($_POST['total_price'])) {
        $order_id = $_POST['order_id'];
        $shipping_cost = $_POST['shipping_cost'];
        $product_total_price = $_POST['product_total_price'];
        $total_price = $_POST['total_price'];
        $cart = json_decode($_POST['cart'], true);

        // Ambil user_id dan email dari sesi
        $user_id = $_SESSION['user_id'];
        $user_email = $_SESSION['user_email'];

        // Proses file bukti pembayaran
        if (isset($_FILES['payment-proof']) && $_FILES['payment-proof']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['payment-proof']['tmp_name'];
            $fileName = $_FILES['payment-proof']['name'];
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $fileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $payment_proof = $fileName;
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengupload bukti pembayaran']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Bukti pembayaran tidak valid']);
            return;
        }

        // Memulai transaksi
        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO payments (order_id, shipping_cost, product_total_price, total_price, payment_proof, payment_date) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iidis", $order_id, $shipping_cost, $product_total_price, $total_price, $payment_proof);

            if ($stmt->execute()) {
                foreach ($cart as $item) {
                    $product_id = $item['id'];
                    $quantity = $item['quantity'];

                    $updateStockSql = "UPDATE products SET stock = stock - ? WHERE id = ?";
                    $updateStmt = $conn->prepare($updateStockSql);
                    $updateStmt->bind_param("ii", $quantity, $product_id);
                    $updateStmt->execute();
                }

                // Update tabel orders dengan user_id dan email
                $updateOrderSql = "UPDATE orders SET user_id = ?, email = ? WHERE id = ?";
                $updateOrderStmt = $conn->prepare($updateOrderSql);
                $updateOrderStmt->bind_param("isi", $user_id, $user_email, $order_id);
                $updateOrderStmt->execute();

                // Commit transaksi jika semua berhasil
                $conn->commit();
                echo json_encode(['success' => true, 'cart' => $cart]);
            } else {
                throw new Exception('Gagal menyimpan pembayaran');
            }

            $stmt->close();
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    }
}

processCheckout($conn);
$conn->close();
?>
