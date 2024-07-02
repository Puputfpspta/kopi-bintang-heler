<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi_bintang_heler";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
