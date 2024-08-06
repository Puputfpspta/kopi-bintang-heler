<?php
session_start();
include 'db.php';

$error = '';

// Tambahkan pengecekan koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Pilih tabel berdasarkan role
    if ($role === 'admin') {
        $query = "SELECT id, username AS email, password FROM admin WHERE username = ?";
    } else {
        $query = "SELECT id, email, password FROM users WHERE email = ?";
    }

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->error) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            if ($role === 'admin') {
                $_SESSION['username'] = $email;
                $_SESSION['role'] = $role;
                header("Location: admin.php");
            } else {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_email'] = $email;
                $_SESSION['role'] = $role;
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = 'Email atau password salah';
        }
    } else {
        $error = 'Email atau password salah';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-form">
                <i data-feather="coffee" class="logo"></i>
                <h2>Silakan login</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="role">Login sebagai:</label>
                        <select name="role" id="role" onchange="toggleRoleFields()">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" maxlength="30" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button type="submit" name="login" class="button">Login</button>
                </form>
                <p>Belum punya akun? <a href="register.php">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
    <script>
        feather.replace();
        function toggleRoleFields() {
            // Tidak ada field khusus yang perlu disembunyikan
        }

        // Panggil fungsi saat halaman dimuat pertama kali
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
        });
    </script>
</body>
</html>
