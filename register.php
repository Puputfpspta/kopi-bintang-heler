<?php
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi masukan
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'Email tidak valid.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Cek apakah email sudah terdaftar
        $check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $result = $check_email->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email sudah digunakan. Silakan login.';
        } else {
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("ss", $email, $hashed_password);
            if ($stmt->execute()) {
                header('Location: register.php?register_success=1');
                exit(); // Pastikan untuk keluar setelah redirect
            } else {
                // Tangkap pesan kesalahan dari $stmt
                $error = 'Registrasi gagal: ' . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        }
        $check_email->close();
    }
}

if (isset($_GET['register_success']) && $_GET['register_success'] == 1) {
    $success = 'Registrasi berhasil, silakan login.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kopi Bintang Heler</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: yellow;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="background-animation">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-form">
                <i data-feather="coffee" class="logo"></i>
                <h2>Register</h2>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="button">Register</button>
                </form>
                <p><a href="login.php">Sudah punya akun? Login di sini</a></p>
            </div>
        </div>
    </div>
    <script>
        feather.replace();
    </script>
</body>
</html>
