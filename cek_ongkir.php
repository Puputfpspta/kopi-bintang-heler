<?php
$api_key = '9f93fe2cf091da12574d09e01b99dca4';

if (isset($_POST['get_couriers'])) {
    $couriers = ["jne", "tiki", "pos"];
    echo json_encode(['couriers' => $couriers]);
    exit();
}

if (isset($_POST['cek_ongkir'])) {
    $origin = '496'; // ID kota Way Kanan
    $destination_name = $_POST['destination'];
    $weight = 1000; // Default weight
    $courier = $_POST['courier']; // Get selected courier

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
        CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination_id&weight=$weight&courier=$courier",
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
        echo json_encode($response_data);
    }
}
?>
