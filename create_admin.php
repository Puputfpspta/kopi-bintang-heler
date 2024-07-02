<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi_bintang_heler";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menggunakan password_hash untuk mengenkripsi password
$admin_username = 'wiwen@admin.com';
$admin_password = password_hash('12345678', PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (username, password) VALUES ('$admin_username', '$admin_password')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
