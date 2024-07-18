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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">Kopi<span>BintangHeler</span>.</a>
        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#product">Product</a>
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
                <h3>Kenapa harus Bintang Heler?</h3>
                <p style="text-align: justify;">Bintang Heler, berdiri sejak 21 Juni 2023, berlokasi di Bumi Ratu, RT/RW 001/003 Bedeng Alang-alang, Kecamatan Blambangan Umpu, Kelurahan Bumi Ratu, Kabupaten Way Kanan Lampung. Bintang Heler menawarkan dua macam kopi, yaitu Robusta Petik Merah dan Robusta Premium.</p>
                <p style="text-align: justify;">Robusta Petik Merah adalah kopi robusta yang dipanen ketika biji kopi telah matang sempurna, dikenal sebagai "petik merah". sedangkan Robusta Premium adalah jenis kopi robusta yang diproses dan dipilih dengan standar kualitas lebih tinggi dibandingkan robusta biasa. Kami memproduksi kopi dengan memilih biji kopi berkualitas tinggi untuk menghasilkan cita rasa yang nikmat. Melalui proses roasting yang tepat, kami meningkatkan keunikan rasa kopi asli Way Kanan ini menjadi semakin mantap.</p>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- Product Section -->
    <section id="product" class="product">
        <h2><span>Produk</span> Kami</h2>
        <p>Nikmati keistimewaan kopi bubuk Robusta Lampung kami yang diproduksi secara homemade dengan dedikasi tinggi. Dengan cita rasa khas yang tak tertandingi, setiap sajian memberikan pengalaman tiada duanya. Temukan kepuasan dalam setiap tegukan kopi Bintang Heler asli Waykanan.</p>
        <div class="row">
            <!-- Product Card 1 -->
            <div class="product-card" data-name="Robusta Petik Merah 200g" data-price="45000" data-weight="200">
                <div class="product-icons">
                    <a href="#" class="add-to-cart"><i data-feather="shopping-cart"></i></a>
                    <a href="#" class="item-detail-button"><i data-feather="eye"></i></a>
                </div>
                <div class="product-image">
                    <img src="img/product/robutsa petik merah.jpg" alt="Robusta Petik Merah" class="product-card-img">
                    <div class="deskripsi-overlay">
                        <p>Kopi Petik Merah adalah varian dari kopi Bintang Heler yang terbuat dari biji kopi pilihan yang berwarna merah seluruhnya. Rasanya pun lebih premium dan sudah diakui oleh penikmat kopi Indonesia.</p>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="product-card-title">Robusta Petik Merah</h3>
                    <h4 class="product-card-subtitle">200g</h4>
                    <div class="product-price">Rp.45.000</div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card" data-name="Robusta Premium 200g" data-price="35000" data-weight="200">
                <div class="product-icons">
                    <a href="#" class="add-to-cart"><i data-feather="shopping-cart"></i></a>
                    <a href="#" class="item-detail-button"><i data-feather="eye"></i></a>
                </div>
                <div class="product-image">
                    <img src="img/product/robutsa premium.jpg" alt="Robusta Premium 200g" class="product-card-img">
                    <div class="deskripsi-overlay">
                        <p>Kopi Robusta Premium dari Kopi Bintang Heler, menyuguhkan keistimewaan rasa yang memukau, mempersembahkan kekuatan dan karakter yang tak tertandingi dalam setiap sajian.</p>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="product-card-title">Robusta Premium</h3>
                    <h4 class="product-card-subtitle">200g</h4>
                    <div class="product-price">Rp.35.000</div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card" data-name="Robusta Premium 500g" data-price="70000" data-weight="500">
                <div class="product-icons">
                    <a href="#" class="add-to-cart"><i data-feather="shopping-cart"></i></a>
                    <a href="#" class="item-detail-button"><i data-feather="eye"></i></a>
                </div>
                <div class="product-image">
                    <img src="img/product/robutsa premium 500g.jpg" alt="Robusta Premium 500g" class="product-card-img">
                    <div class="deskripsi-overlay">
                        <p>Kopi Robusta Premium dari Kopi Bintang Heler, menyuguhkan keistimewaan rasa yang memukau, mempersembahkan kekuatan dan karakter yang tak tertandingi dalam setiap sajian.</p>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="product-card-title">Robusta Premium</h3>
                    <h4 class="product-card-subtitle">500g</h4>
                    <div class="product-price">Rp.70.000</div>
                </div>
            </div>
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

            <div id="shipping-cost">
                <strong>Ongkos Kirim:</strong> <span id="shipping-price">Rp.0</span>
            </div>

            <div id="total-payment">
                <strong>Total Pembayaran:</strong> <span id="final-total-price">Rp.0</span>
            </div>

            <form id="payment-form" enctype="multipart/form-data">
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
    <!-- End Keranjang Belanja Section -->

    <!-- Modal for Shipping Address -->
    <div id="alamatPengirimanModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="shipping-form">
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" placeholder="Nama lengkap Anda" required>
                </div>
                <div class="form-group">
                    <label for="phone">No. Handphone:</label>
                    <input type="text" id="phone" name="phone" placeholder="Nomor HP Anda" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat:</label>
                    <input type="text" id="address" name="address" placeholder="Alamat Anda" required>
                </div>
                <div class="form-group">
                    <label for="house-number">No. Rumah:</label>
                    <input type="text" id="house-number" name="house-number" placeholder="Nomor Rumah Anda" required>
                </div>
                <div class="form-group">
                    <label for="postal-code">Kode Pos:</label>
                    <input type="text" id="postal-code" name="postal-code" placeholder="Kode Pos Anda" required>
                </div>
                <div class="form-group">
                    <label for="destination">Kota Tujuan:</label>
                    <input type="text" id="destination" name="destination" placeholder="Nama Kota Tujuan" required>
                </div>
                <div class="form-group">
                    <label for="courier">Kurir:</label>
                    <select id="courier" name="courier" required>
                        <!-- Opsi kurir akan dimuat di sini oleh JavaScript -->
                    </select>
                </div>
                <button type="button" id="calculate-shipping">Hitung Ongkir</button>
            </form>
        </div>
    </div>

    <div id="shipping-cost"></div>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="header">
            <h2>Kontak <span>Kami</span></h2>
            <h4>Jika Anda memiliki pertanyaan atau ingin mendapatkan informasi lebih lanjut tentang layanan kami,</h4>
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
</body>
</html>
