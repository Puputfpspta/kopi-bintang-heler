<?php
session_start();
include 'db.php';

$error = '';

if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['admin-username']) ? $_POST['admin-username'] : '';
    $password = $_POST['password'];

    if ($role === 'admin') {
        $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
    } else {
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
    }

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->execute();

    if ($stmt->error) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        if ($role === 'admin') {
            $stmt->bind_result($id, $username, $hashed_password);
        } else {
            $stmt->bind_result($id, $email, $hashed_password);
        }
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            if ($role === 'admin') {
                $_SESSION['username'] = $username;
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
            $error = 'Username atau password salah';
        }
    } else {
        $error = 'Username atau password salah';
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
                    <div id="user-fields" class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div id="admin-fields" class="form-group" style="display: none;">
                        <label for="admin-username">Username</label>
                        <input type="text" id="admin-username" name="admin-username">
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
                <p><a href="register.php">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
    <script>
        feather.replace();
        function toggleRoleFields() {
            var role = document.getElementById('role').value;
            if (role === 'admin') {
                document.getElementById('user-fields').style.display = 'none';
                document.getElementById('admin-fields').style.display = 'block';
                document.getElementById('email').required = false;
                document.getElementById('admin-username').required = true;
            } else {
                document.getElementById('user-fields').style.display = 'block';
                document.getElementById('admin-fields').style.display = 'none';
                document.getElementById('email').required = true;
                document.getElementById('admin-username').required = false;
            }
        }
    </script>
</body>
</html>
