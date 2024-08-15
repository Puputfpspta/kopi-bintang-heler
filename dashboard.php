<?php
include 'db.php';
include 'function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi Bintang Heler</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700&family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/common.css">
    <style>
        /* Tambahkan gaya untuk latar belakang putih dan teks hitam di item navbar */
        .navbar-nav a {
            background-color: white;
            color: black;
            padding: 10px;
            display: block;
            text-decoration: none;
            margin: 5px 0;
        }
        
        .navbar-nav a:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        .navbar-nav.active {
            display: block;
        }

        .navbar-nav {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            width: 200px;
            text-align: right;
        }

        /* Khusus untuk tampilan mobile */
        @media (max-width: 768px) {
            .navbar-nav {
                background-color: white;
                width: 100%;
                position: absolute;
                top: 50px;
                right: 0;
                text-align: left;
            }

            .navbar-nav a {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">Kopi<span>BintangHeler</span>.</a>
        <div class="hamburger-menu" id="hamburger-menu">
            <i data-feather="menu"></i>
        </div>
        <div class="navbar-nav" id="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#howtoorder">Cara Order</a>
            <a href="#product">Produk</a>
            <a href="#contact">Kontak</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="navbar-extra">
            <a href="#" id="search-icon"><i data-feather="search"></i></a>
            <a href="#" id="shopping-cart-icon"><i data-feather="shopping-cart"></i></a>
        </div>
        <div class="search-form">
            <input type="search" id="search-box" placeholder="Cari produk...">
            <button type="button" id="search-submit-button">Cari</button>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Selamat Datang Section -->
    <section class="welcome">
       <div class="content">
           <h2>Selamat <span>Datang</span> di Web Kami</h2>
           <p>Selamat berbelanja di Kopi Bintang Heler. Temukan kopi terbaik untuk Anda!</p>
       </div>
    </section>
    <!-- End Selamat Datang Section -->

    <!-- section hero start -->
    <section class="hero" id="home">
        <div class="content">
            <h1>Mari Nikmati Secangkir <span>Kopi</span></h1>
            <p>Dibuat Secara Homemade dengan Biji Kopi Pilihan, Menyajikan Pengalaman Yang Personal dan Autentik.</p>
            <a href="#product" class="button">Beli Sekarang</a>
        </div>
    </section>
    <!-- section hero end -->

    <!-- About Section -->
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>
        <div class="row">
            <div class="about-img">
                <img src="img/tentang.jpg" alt="Tentang Kami">
            </div>
            <div class="content">
                <h3>Kenapa harus memilih Bintang Heler?</h3>
                <p style="text-align: justify;">Bintang Heler didirikan pada 21 Juni 2023 di Bumi Ratu, Way Kanan, Lampung. Kami menawarkan dua varian kopi premium, yaitu Robusta Petik Merah dan Robusta Premium. Robusta Petik Merah dipanen saat biji kopi telah matang sempurna, yang memastikan rasa yang optimal. Sementara itu, Robusta Premium diproses dengan standar kualitas tertinggi, untuk memberikan pengalaman rasa yang luar biasa. Kami memastikan setiap biji kopi yang kami produksi memenuhi standar kualitas.</p>
                <p style="text-align: justify;">Kami berkomitmen untuk menghasilkan kopi berkualitas terbaik. Melalui proses roasting yang cermat, kami menjaga keunikan dan kekayaan cita rasa kopi kami. Nikmati perbedaan kualitas di setiap cangkir kopi Bintang Heler.</p>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- How to Order Section -->
    <section id="howtoorder" class="howtoorder">
        <div class="container">
            <h2 class="title"><span>Cara</span> Order</h2>
            <div class="steps">
                <div class="step">
                    <div class="number">1</div>
                    <div class="step-content">
                        <div class="step-header">
                            <i data-feather="log-in" class="step-icon"></i>
                            <h3>Login atau Daftar</h3>
                        </div>
                        <p>Login menggunakan akun yang sudah terdaftar. Jika belum memiliki akun, daftar terlebih dahulu.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="number">2</div>
                    <div class="step-content">
                        <div class="step-header">
                            <i data-feather="shopping-cart" class="step-icon"></i>
                            <h3>Pilih Produk</h3>
                        </div>
                        <p>Pilih produk yang ingin dipesan dan masukkan ke dalam keranjang belanja, selanjutnya pilih keranjang belanja yang ada di sebelah search.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="number">3</div>
                    <div class="step-content">
                        <div class="step-header">
                            <i data-feather="map-pin" class="step-icon"></i>
                            <h3>Isi Form Alamat Pengiriman</h3>
                        </div>
                        <p>Isi form alamat pengiriman dengan lengkap dan benar. Jika sudah terisi maka rekening owner akan muncul.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="number">4</div>
                    <div class="step-content">
                        <div class="step-header">
                            <i data-feather="upload" class="step-icon"></i>
                            <h3>Upload Bukti Pembayaran</h3>
                        </div>
                        <p>Lakukan Pembayaran melalui rekening owner kemudian Upload bukti pembayaran melalui form yang disediakan.</p>
                    </div>
                </div>
                <div class="step center">
                    <div class="number">5</div>
                    <div class="step-content">
                        <div class="step-header">
                            <i data-feather="check-circle" class="step-icon"></i>
                            <h3>Checkout</h3>
                        </div>
                        <p>Lakukan checkout untuk menyelesaikan pemesanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section id="product" class="product">
        <h2><span>Produk</span> Kami</h2>
        <p>Nikmati keistimewaan kopi bubuk Robusta Lampung kami yang diproduksi secara homemade dengan dedikasi tinggi. Dengan cita rasa khas yang tak tertandingi, setiap sajian memberikan pengalaman tiada duanya. Temukan kepuasan dalam setiap tegukan kopi Bintang Heler asli Waykanan.</p>
        <div class="row">
            <?php
           $products = getProducts();
           foreach ($products as $product) {
               echo '<div class="product-card" data-id="' . htmlspecialchars($product['id']) . '" data-name="' . htmlspecialchars($product['name']) . '" data-price="' . htmlspecialchars($product['price']) . '" data-weight="' . htmlspecialchars($product['weight']) . '" data-stock="' . htmlspecialchars($product['stock']) . '">';
               echo '    <div class="product-icons">';
               echo '        <a href="#" class="add-to-cart"><i data-feather="shopping-cart"></i></a>';
               echo '        <a href="#" class="item-detail-button"><i data-feather="eye"></i></a>';
               echo '    </div>';
               echo '    <div class="product-image">';
               echo '        <img src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '" class="product-card-img">';
               echo '        <div class="deskripsi-overlay">';
               echo '            <p>' . htmlspecialchars($product['description']) . '</p>';
               echo '        </div>';
               echo '    </div>';
               echo '    <div class="product-content">';
               echo '        <h3 class="product-card-title">' . htmlspecialchars($product['name']) . '</h3>';
               echo '        <h4 class="product-card-subtitle">' . htmlspecialchars($product['weight']) . 'g</h4>';
               echo '        <div class="product-price">Rp.' . number_format($product['price'], 0, ',', '.') . '</div>';
               echo '        <div class="product-stock">Stok: ' . htmlspecialchars($product['stock']) . '</div>'; // Menampilkan stok produk
               echo '    </div>';
               echo '</div>';
           }
           ?>
        </div>
    </section>
    <!-- End Product Section -->

    <!-- Keranjang Belanja Section -->
    <section class="shopping-container">
        <div id="shopping-cart" class="shopping-cart">
            <h2>Keranjang Belanja</h2>
            <div class="cart-items">
                <!-- Daftar item akan dimuat di sini oleh JavaScript -->
            </div>
            <button type="button" id="enter-shipping-details">Masukkan Alamat Pengiriman</button>

            <div id="product-total-price">
                <strong>Total Harga Produk:</strong> <span id="total-price">Rp.0</span>
            </div>

            <div id="shipping-cost">
                <strong>Ongkos Kirim:</strong> <span id="shipping-price">Rp.0</span>
            </div>

            <div id="total-payment">
                <strong>Total Pembayaran:</strong> <span id="final-total-price">Rp.0</span>
            </div>

            <div id="bank-account" class="highlighted-text">
                <!-- Nomor rekening akan dimuat di sini oleh JavaScript -->
            </div>
            <style>
                .highlighted-text {
                    color: yellow; /* Warna terang */
                    font-weight: bold;
                    background-color: black; /* Background yang kontras */
                    padding: 8px;
                    border-radius: 5px;
                }
            </style>

            <!-- Bagian form pembayaran di dashboard.php -->
            <form id="payment-form" action="process_checkout.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="order-id" name="order_id">
                <input type="hidden" id="hidden-shipping-cost" name="shipping_cost">
                <input type="hidden" id="hidden-product-total-price" name="product_total_price">
                <input type="hidden" id="hidden-final-total-price" name="total_price">
                <div class="form-group">
                    <label for="payment-proof">UPLOAD BUKTI PEMBAYARAN:</label>
                    <input type="file" id="payment-proof" name="payment-proof" accept="image/*" required>
                </div>
                <button type="submit" id="checkout-button">Checkout</button>
            </form>

            <div class="cart-bottom">
                <a href="#product" id="back-to-products" class="back-to-products">
                    <i data-feather="arrow-left" class="icon"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Modal for Shipping Address -->
    <div id="alamatPengirimanModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="shipping-form">
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" placeholder="Nama lengkap Anda" required autocomplete="name">
                </div>
                <div class="form-group">
                    <label for="phone">No. Handphone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nomor HP Anda" required autocomplete="tel">
                </div>
                <div class="form-group">
                    <label for="address">Alamat:</label>
                    <input type="text" id="address" name="address" placeholder="Alamat Lengkap Anda" required autocomplete="street-address">
                </div>
                <div class="form-group">
                    <label for="house-number">No. Rumah:</label>
                    <input type="text" id="house-number" name="house-number" placeholder="Nomor Rumah Anda" required autocomplete="address-line1">
                </div>
                <div class="form-group">
                    <label for="postal-code">Kode Pos:</label>
                    <input type="text" id="postal-code" name="postal-code" placeholder="Kode Pos Anda" required autocomplete="postal-code">
                </div>
                <div class="form-group">
                    <label for="destination">Kota Tujuan:</label>
                    <input type="text" id="destination" name="destination" placeholder="Nama Kota Tujuan" required autocomplete="address-level2">
                </div>
                <div class="form-group">
                    <label for="courier">Kurir:</label>
                    <select id="courier" name="courier" required autocomplete="shipping">
                        <!-- Opsi kurir akan dimuat di sini oleh JavaScript -->
                    </select>
                </div>
                <button type="button" id="calculate-shipping">Hitung Ongkir</button>
            </form>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="header">
            <h2>Kontak <span>Kami</span></h2>
            <h4>Jika Anda memiliki pertanyaan atau ingin mendapatkan informasi lebih lanjut tentang layanan atau produk kami,</h4>
            <p>jangan ragu untuk menghubungi kami melalui formulir di bawah ini. Kami siap membantu Anda dengan senang hati!</p>
        </div>
        <div class="row">
            <div class="google-maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127454.52702722342!2d104.57496335916517!3d-4.638088605149792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e37529f5e68148f%3A0x2e4aef29dbd62cfd!2sBumi%20Ratu%2C%20Blambangan%20Umpu%2C%20Kabupaten%20Way%20Kanan%2C%20Lampung!5e0!3m2!1sid!2sid!4v1624983371847!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="form-wrapper">
                <form id="contact-form" class="form" onsubmit="submitForm(event)">
                    <div class="form-group">
                        <label for="nama" class="label">Nama lengkap</label>
                        <input type="text" id="nama" name="name" class="input input-name" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label">Alamat email</label>
                        <input type="email" id="email" name="email" class="input input-email" placeholder="Alamat email" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor" class="label">Nomor telepon</label>
                        <input type="tel" id="nomor" name="phone" class="input input-nomor" placeholder="No.telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="pertanyaan" class="label">Pertanyaan</label>
                        <textarea id="pertanyaan" name="pertanyaan" class="input input-pertanyaan" placeholder="Tulis pertanyaan Anda di sini" required></textarea>
                    </div>
                    <button type="submit" class="button btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Kopi Bintang Heler. Owner Wiwien Andriani.</p>
    </footer>
    <!-- End Footer -->

    <!-- Scripts -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="js/script.js"></script>

    <!-- JavaScript untuk Mengatur Hamburger Menu -->
    <script>
        // Mengatur hamburger menu toggle
        document.getElementById('hamburger-menu').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('navbar-nav').classList.toggle('active');
        });

        // Feather icons replace
        feather.replace();

        // Tutup hamburger menu saat item di klik dan navigasi ke bagian yang diinginkan
        document.querySelectorAll('.navbar-nav a').forEach(function(link) {
            link.addEventListener('click', function() {
                document.getElementById('hamburger-menu').classList.remove('active');
                document.getElementById('navbar-nav').classList.remove('active');
            });
        });
    </script>
</body>
</html>
