document.addEventListener('DOMContentLoaded', function() {
    // Feather Icons
    feather.replace();

    // Navbar Scroll
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 0) {
            navbar.classList.add('active');
        } else {
            navbar.classList.remove('active');
        }
    });

    // Toggle Search Form
    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.querySelector('.search-form');
    searchIcon.addEventListener('click', function() {
        searchForm.classList.toggle('active');
    });

    // Cart Functionality
    let cart = [];
    const cartElement = document.getElementById('shopping-cart');
    const cartItemsElement = document.querySelector('.cart-items');
    const cartTotalPriceElement = document.getElementById('cart-total-price');

    function updateCart() {
        cartItemsElement.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartItemsElement.innerHTML = '<p>Keranjang belanja Anda kosong.</p>';
        } else {
            cart.forEach((item, index) => {
                const itemTotalPrice = item.price * item.quantity;
                total += itemTotalPrice;
                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <img src="${item.imgSrc}" alt="${item.name}" class="cart-item-image">
                    <div class="item-detail">
                        <h3>${item.name}</h3>
                        <div class="item-quantity">
                            <button class="quantity-btn minus" data-index="${index}">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn plus" data-index="${index}">+</button>
                        </div>
                        <div class="item-price">Rp.${itemTotalPrice}</div>
                    </div>
                    <i data-feather="trash-2" class="remove-item" data-index="${index}"></i>
                `;
                cartItemsElement.appendChild(cartItem);
            });
        }

        cartTotalPriceElement.innerText = `Rp.${total}`;
        feather.replace(); // Refresh feather icons

        // Event listeners for remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                cart.splice(index, 1);
                updateCart();
            });
        });

        // Event listeners for quantity buttons
        document.querySelectorAll('.quantity-btn.plus').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                cart[index].quantity++;
                updateCart();
            });
        });

        document.querySelectorAll('.quantity-btn.minus').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                } else {
                    cart.splice(index, 1);
                }
                updateCart();
            });
        });
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            const productName = productCard.getAttribute('data-name');
            const productPrice = parseInt(productCard.getAttribute('data-price'));
            const productImgSrc = productCard.querySelector('img').getAttribute('src');

            const existingItemIndex = cart.findIndex(item => item.name === productName);
            if (existingItemIndex > -1) {
                cart[existingItemIndex].quantity++;
            } else {
                cart.push({ name: productName, price: productPrice, imgSrc: productImgSrc, quantity: 1 });
            }
            updateCart();
            showNotification('Produk sudah dimasukkan ke dalam keranjang belanja');
        });
    });

    // Toggle Cart
    const cartIcon = document.getElementById('shopping-cart-icon');
    cartIcon.addEventListener('click', function() {
        cartElement.classList.toggle('active');
    });

    // Show Notification
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.classList.add('notification');
        notification.innerHTML = `
            <div class="notification-content">
                <i data-feather="check-circle"></i>
                <p>${message}</p>
                <button class="button" id="notification-ok-button">OK</button>
            </div>
        `;
        document.body.appendChild(notification);
        feather.replace();

        document.getElementById('notification-ok-button').addEventListener('click', function() {
            notification.remove();
        });
    }

    // Checkout
    const checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', function(event) {
        event.preventDefault();
        showCheckoutForm();
    });

    function showCheckoutForm() {
        const checkoutForm = document.createElement('div');
        checkoutForm.classList.add('checkout-form');
        checkoutForm.innerHTML = `
            <div class="checkout-form-content">
                <h2>Checkout</h2>
                <form id="checkout-form">
                    <label for="name">Nama Lengkap:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="address">Alamat:</label>
                    <input type="text" id="address" name="address" required>
                    <label for="phone">No. Telepon:</label>
                    <input type="text" id="phone" name="phone" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="payment-proof">Upload Bukti Pembayaran:</label>
                    <input type="file" id="payment-proof" name="payment-proof" required>
                    <button type="submit" class="button">Submit</button>
                </form>
            </div>
        `;
        document.body.appendChild(checkoutForm);

        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(form);
            processCheckout(formData);
        });
    }

    function processCheckout(formData) {
        console.log('Checkout Data:', formData);
        document.querySelector('.checkout-form').remove();
        alert('Checkout berhasil!');
    }

    // Event listener untuk menampilkan deskripsi produk
    document.querySelectorAll('.item-detail-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            productCard.classList.toggle('show-description');
        });
    });

    // Menghubungkan form kontak ke WhatsApp
    document.getElementById('contact-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('nomor').value;
        const question = document.getElementById('pertanyaan').value;

        const message = `Halo, saya ${name}. Email saya adalah ${email}, nomor telepon saya adalah ${phone}. Pertanyaan saya adalah: ${question}`;

        const whatsappURL = `https://wa.me/6281288111722?text=${encodeURIComponent(message)}`;

        window.open(whatsappURL, '_blank');
    });

    // Update cart on page load to ensure it's empty initially
    updateCart();
});
