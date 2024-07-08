document.addEventListener('DOMContentLoaded', function() {
    feather.replace();

    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (navbar) {
            if (window.scrollY > 0) {
                navbar.classList.add('active');
            } else {
                navbar.classList.remove('active');
            }
        }
    });

    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.querySelector('.search-form');
    if (searchIcon && searchForm) {
        searchIcon.addEventListener('click', function() {
            searchForm.classList.toggle('active');
        });
    }

    let cart = [];
    const cartElement = document.getElementById('shopping-cart');
    const cartItemsElement = document.querySelector('.cart-items');
    const cartTotalPriceElement = document.getElementById('cart-total-price');
    const totalShippingCostElement = document.getElementById('total-shipping-cost');
    const finalTotalPriceElement = document.getElementById('final-total-price');

    function updateCart() {
        if (cartItemsElement) {
            cartItemsElement.innerHTML = '';
            let total = 0;
            let weight = 0;

            if (cart.length === 0) {
                cartItemsElement.innerHTML = '<p>Keranjang belanja Anda kosong.</p>';
            } else {
                cart.forEach((item, index) => {
                    const itemTotalPrice = item.price * item.quantity;
                    total += itemTotalPrice;
                    weight += item.weight * item.quantity;
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

            if (cartTotalPriceElement) cartTotalPriceElement.innerText = `Rp.${total}`;
            if (finalTotalPriceElement) finalTotalPriceElement.innerText = `Rp.${total}`;
            feather.replace();

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    cart.splice(index, 1);
                    updateCart();
                });
            });

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
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            const productName = productCard.getAttribute('data-name');
            const productPrice = parseInt(productCard.getAttribute('data-price'));
            const productWeight = parseInt(productCard.getAttribute('data-weight'));
            const productImgSrc = productCard.querySelector('img').getAttribute('src');

            const existingItemIndex = cart.findIndex(item => item.name === productName);
            if (existingItemIndex > -1) {
                cart[existingItemIndex].quantity++;
            } else {
                cart.push({ name: productName, price: productPrice, weight: productWeight, imgSrc: productImgSrc, quantity: 1 });
            }
            updateCart();
            showNotification('Produk sudah dimasukkan ke dalam keranjang belanja');
        });
    });

    const cartIcon = document.getElementById('shopping-cart-icon');
    if (cartIcon && cartElement) {
        cartIcon.addEventListener('click', function() {
            cartElement.classList.toggle('active');
        });
    }

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

    const checkoutButton = document.getElementById('checkout-button');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            showCheckoutForm();
        });
    }

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
                    <label for="postal-code">Kode Pos:</label>
                    <input type="text" id="postal-code" name="postal-code" required>
                    <button type="button" id="calculate-shipping-button">Hitung Ongkir</button>
                    <div id="shipping-cost-result"></div>
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
        const checkoutForm = document.querySelector('.checkout-form');
        if (checkoutForm) checkoutForm.remove();
        alert('Checkout berhasil!');
    }

    document.querySelectorAll('.item-detail-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            const overlay = productCard.querySelector('.deskripsi-overlay');
            if (overlay.style.display === 'none' || !overlay.style.display) {
                overlay.style.display = 'flex';
            } else {
                overlay.style.display = 'none';
            }
        });
    });
    
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('nomor').value;
            const question = document.getElementById('pertanyaan').value;

            const message = `Halo, saya ${name}. Email saya adalah ${email}, nomor telepon saya adalah ${phone}. Pertanyaan saya adalah: ${question}`;

            const whatsappURL = `https://wa.me/6281288111722?text=${encodeURIComponent(message)}`;

            window.open(whatsappURL, '_blank');
        });
    }

    const calculateShippingButton = document.getElementById('calculate-shipping-button');
    if (calculateShippingButton) {
        calculateShippingButton.addEventListener('click', function(event) {
            event.preventDefault();

            const origin = '501'; // Way Kanan, Lampung
            const destination = document.getElementById('postal-code').value; // Menggunakan Kode Pos
            const weight = cart.reduce((acc, item) => acc + (item.weight * item.quantity), 0); // Total weight of items in cart
            const courier = 'jne'; // Menggunakan JNE sebagai kurir

            fetch('cek_ongkir.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'origin': origin,
                    'destination': destination,
                    'weight': weight,
                    'courier': courier
                })
            })
            .then(response => response.json())
            .then(data => {
                const shippingOptions = data.rajaongkir.results[0].costs;
                const shippingOptionsElement = document.getElementById('shipping-cost-result');
                shippingOptionsElement.innerHTML = '';

                shippingOptions.forEach(cost => {
                    const optionElement = document.createElement('div');
                    optionElement.classList.add('shipping-option');
                    optionElement.innerHTML = `
                        <input type="radio" name="shipping-option" value="${cost.cost[0].value}" data-service="${cost.service}">
                        <label>${cost.service} (${cost.description}): Rp.${cost.cost[0].value}</label>
                    `;
                    shippingOptionsElement.appendChild(optionElement);
                });

                document.querySelectorAll('input[name="shipping-option"]').forEach(option => {
                    option.addEventListener('change', function() {
                        const selectedCost = parseInt(this.value);
                        const total = parseInt(cartTotalPriceElement.innerText.replace('Rp.', '').replace(',', ''));
                        totalShippingCostElement.innerHTML = `Ongkos Kirim: Rp. ${selectedCost}`;
                        finalTotalPriceElement.innerHTML = `Rp. ${total + selectedCost}`;
                    });
                });
            })
            .catch(error => console.error('Error:', error));
        });
    }

    updateCart();
});
