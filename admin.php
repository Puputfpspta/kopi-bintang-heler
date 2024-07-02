<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Kopi | Kopi Bintang Heler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="fab fa-accusoft"></span> <span>Kopi Bintang Heler</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="produk.php" class="active"><span class="fas fa-coffee"></span>
                        <span>Produk</span></a>
                </li>
                <li>
                    <a href="pesanan.php"><span class="fas fa-shopping-cart"></span>
                        <span>Pesanan</span></a>
                </li>
                <li>
                    <a href="pembayaran.php"><span class="fas fa-money-check-alt"></span>
                        <span>Pembayaran</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="fas fa-sign-out-alt"></span>
                        <span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="fas fa-bars"></span>
                </label>
                Kelola Produk
            </h2>

            <div class="user-wrapper">
                <img src="img/bag.jpg" width="150px" height="60px">
            </div>
        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>54</h1>
                        <span>Produk</span>
                    </div>
                    <div>
                        <span class="fas fa-coffee"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>79</h1>
                        <span>Pesanan</span>
                    </div>
                    <div>
                        <span class="fas fa-shopping-cart"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>124</h1>
                        <span>Pelanggan</span>
                    </div>
                    <div>
                        <span class="fas fa-user"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>6</h1>
                        <span>Review</span>
                    </div>
                    <div>
                        <span class="fas fa-comment"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Kelola Produk Kopi</h3>
                            <button>Tambah Produk <span class="fas fa-plus"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nama Produk</td>
                                            <td>Kategori</td>
                                            <td>Harga</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#KOPI001</td>
                                            <td>Robusta Petik Merah</td>
                                            <td>Robusta</td>
                                            <td>Rp. 45.000</td>
                                            <td><span class="status purple"></span> Tersedia</td>
                                        </tr>
                                        <tr>
                                            <td>#KOPI002</td>
                                            <td>Robusta Premium</td>
                                            <td>Robusta</td>
                                            <td>Rp. 35.000</td>
                                            <td><span class="status pink"></span> Tersedia</td>
                                        </tr>
                                        <tr>
                                            <td>#KOPI003</td>
                                            <td>Robusta Premium 500g</td>
                                            <td>Robusta</td>
                                            <td>Rp.Baik, berikut adalah versi terpisah dari kode CSS dan PHP untuk halaman login yang sesuai dengan yang Anda inginkan.

### File CSS: `style.css`
```css
:root {
  --primary: #007bff;
  --bg: #f5f5f5;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  outline: none;
  border: none;
  text-decoration: none;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: 'Laila', sans-serif;
  background-color: var(--bg);
  color: rgb(252, 248, 248);
}

/* Login Container */
body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-container {
  background-color: #fff;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 300px;
}

.login-container h2 {
  margin-bottom: 1rem;
  color: #333;
}

.login-container form {
  display: flex;
  flex-direction: column;
}

.login-container .form-group {
  margin-bottom: 1rem;
  text-align: left;
}

.login-container label {
  margin-bottom: 0.5rem;
  display: block;
  color: #333;
}

.login-container input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.login-container .button {
  background-color: var(--primary);
  color: #fff;
  border: none;
  padding: 0.5rem;
  border-radius: 5px;
  cursor: pointer;
}

.login-container .button:hover {
  background-color: darken(var(--primary), 10%);
}

.login-container .error {
  color: red;
  margin-bottom: 1rem;
}
