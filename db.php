<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "u140589105_kopi";
$password = "Kopi12345.";
$dbname = "u140589105_kopi";
$apiKey = '72dc2e39b71800e5c7a4bf318177c9ea';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>