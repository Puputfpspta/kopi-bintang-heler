<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi_bintang_heler";
$apiKey = '9f93fe2cf091da12574d09e01b99dca4';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
