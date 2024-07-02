<?php
// Script untuk menghasilkan hash password
$password = "12345"; // Ganti dengan password yang ingin Anda hash
$hash = password_hash($password, PASSWORD_BCRYPT);

echo "Password: " . $password . "<br>";
echo "Hashed Password: " . $hash;
?>
