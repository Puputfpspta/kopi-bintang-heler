<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi_bintang_heler";
$apiKey = '72dc2e39b71800e5c7a4bf318177c9ea';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
