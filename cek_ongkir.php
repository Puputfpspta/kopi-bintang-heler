<?php
include 'db.php'; // Pastikan ini mengarah ke file koneksi database Anda

header('Content-Type: application/json'); // Set header JSON

try {
    $api_key = '72dc2e39b71800e5c7a4bf318177c9ea'; // Ganti dengan API key baru

    if (isset($_POST['get_couriers'])) {
        $couriers = ["pos", "tiki", "jne"]; // Tambahkan JNE
        echo json_encode(['couriers' => $couriers]);
        exit();
    }

    if (isset($_POST['cek_ongkir'])) {
        $origin = '496'; // ID kota Way Kanan
        $destination_name = trim($_POST['destination']); // Trim white spaces
        $courier = $_POST['courier']; // Get selected courier

        // Hitung total berat berdasarkan jumlah produk
        $total_weight = intval($_POST['total_weight']);
        $product_total_price = intval($_POST['product_total_price']);
        $user_id = intval($_POST['user_id']); // Ambil user_id dari POST

        // First, get the destination city ID
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "key: $api_key"
            ),
        ));
        $city_response = curl_exec($curl);
        $city_err = curl_error($curl);
        curl_close($curl);

        if ($city_err) {
            echo json_encode(["error" => $city_err]);
            exit();
        } else {
            $city_data = json_decode($city_response, true);
            if (isset($city_data['rajaongkir']['results'])) {
                $cities = $city_data['rajaongkir']['results'];
                $destination_id = null;

                foreach ($cities as $city) {
                    if (strtolower($city['city_name']) == strtolower($destination_name)) {
                        $destination_id = $city['city_id'];
                        break;
                    }
                }

                if ($destination_id == null) {
                    echo json_encode(["error" => "City not found"]);
                    exit();
                }
            } else {
                echo json_encode(["error" => "Invalid response from city API", "response" => $city_data]);
                exit();
            }
        }

        // Then, calculate shipping cost
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination_id&weight=$total_weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo json_encode(["error" => $err]);
        } else {
            $response_data = json_decode($response, true);
            if (isset($response_data['rajaongkir']['results']) && !empty($response_data['rajaongkir']['results'][0]['costs'])) {
                $shipping_cost = $response_data['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];

                $total_cost = $shipping_cost + $product_total_price;

                // Insert order data into the orders table
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $house_number = $_POST['house_number'];
                $postal_code = $_POST['postal_code'];
                $city = $destination_name;
                $order_date = date('Y-m-d H:i:s');

                $stmt = $conn->prepare("INSERT INTO orders (user_id, name, phone, address, house_number, postal_code, city, courier, order_date, status, shipping_cost, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("issssssssii", $user_id, $name, $phone, $address, $house_number, $postal_code, $city, $courier, $order_date, $shipping_cost, $total_cost);
                    $stmt->execute();
                    $order_id = $stmt->insert_id; // Get the ID of the inserted order
                    $stmt->close();
                } else {
                    echo json_encode([
                        'error' => 'Database error: ' . $conn->error
                    ]);
                    exit();
                }

                echo json_encode([
                    'order_id' => $order_id,
                    'shipping_cost' => $shipping_cost,
                    'total_cost' => $total_cost,
                    'bank_account' => '5651 0101 3495 535 BRI a.n Wiwien Andriani'
                ]);
            } else {
                echo json_encode(["error" => "Tidak ada kurir tersedia untuk kota tujuan yang dipilih. Silakan pilih kurir atau kota tujuan yang berbeda."]);
            }
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Internal server error']);
}
?>
