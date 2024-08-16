document.addEventListener("DOMContentLoaded", function () {
    // Feather Icons replacement
    feather.replace();

    // Event scroll untuk navbar
    window.addEventListener("scroll", function () {
        var navbar = document.querySelector(".navbar");
        if (navbar) {
            if (window.scrollY > 0) {
                navbar.classList.add("active");
            } else {
                navbar.classList.remove("active");
            }
        }
    });

    // Fungsi untuk menampilkan form tambah produk
    const addProductButton = document.getElementById("addProductButton");
    if (addProductButton) {
        addProductButton.addEventListener("click", function() {
            document.getElementById("addProductForm").style.display = "flex";
        });
    }

    // Fungsi pencarian
    const searchIcon = document.getElementById("search-icon");
    const searchForm = document.querySelector(".search-form");
    const searchSubmitButton = document.getElementById("search-submit-button");
    const searchBox = document.getElementById("search-box");
    const products = document.querySelectorAll(".product-card");

    if (searchIcon && searchForm) {
        searchIcon.addEventListener("click", function (event) {
            event.preventDefault();
            searchForm.classList.toggle("active");
        });
    }

    function searchProducts() {
        const query = searchBox.value.toLowerCase();
        if (!query) return;

        let foundProduct = null;

        if (products) {
            products.forEach((product) => {
                const productName = product.getAttribute("data-name").toLowerCase();
                const productTitle = product.querySelector(".product-card-title");
                const productSubtitle = product.querySelector(".product-card-subtitle");
                const originalTitleText = productTitle.textContent;
                const originalSubtitleText = productSubtitle.textContent;
                productTitle.innerHTML = originalTitleText;
                productSubtitle.innerHTML = originalSubtitleText;

                if (productName.includes(query)) {
                    if (!foundProduct) {
                        foundProduct = product;
                    }
                    const highlightedTitle = originalTitleText.replace(
                        new RegExp(query, "gi"),
                        (match) => `<span class="highlight">${match}</span>`
                    );
                    const highlightedSubtitle = originalSubtitleText.replace(
                        new RegExp(query, "gi"),
                        (match) => `<span class="highlight">${match}</span>`
                    );
                    productTitle.innerHTML = highlightedTitle;
                    productSubtitle.innerHTML = highlightedSubtitle;
                    product.classList.add("found");
                } else {
                    product.classList.remove("found");
                }
            });

            if (foundProduct) {
                foundProduct.scrollIntoView({ behavior: "smooth" });
            }
        }
    }

    if (searchSubmitButton && searchBox) {
        searchSubmitButton.addEventListener("click", function () {
            searchProducts();
        });

        searchBox.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                searchProducts();
            }
        });
    }

    // Fungsi keranjang belanja
    let cart = [];
    const cartElement = document.getElementById("shopping-cart");
    const cartItemsElement = document.querySelector(".cart-items");
    const cartTotalPriceElement = document.getElementById("total-price");
    const totalShippingCostElement = document.getElementById("shipping-price");
    const finalTotalPriceElement = document.getElementById("final-total-price");
    const bankAccountElement = document.getElementById("bank-account");
    const productTotalPriceElement = document.getElementById("product-total-price");

    function updateCart() {
        if (cartItemsElement) {
            cartItemsElement.innerHTML = "";
            let total = 0;
            let weight = 0;

            if (cart.length === 0) {
                cartItemsElement.innerHTML = "<p>Keranjang belanja Anda kosong.</p>";
            } else {
                cart.forEach((item, index) => {
                    const itemTotalPrice = item.price * item.quantity;
                    total += itemTotalPrice;
                    weight += item.weight * item.quantity;
                    const cartItem = document.createElement("div");
                    cartItem.classList.add("cart-item");
                    cartItem.innerHTML = `
                        <img src="${item.imgSrc}" alt="${item.name}" class="cart-item-image">
                        <div class="item-detail">
                            <h3>${item.name}</h3>
                            <div class="item-quantity">
                                <button class="quantity-btn minus" data-index="${index}">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn plus" data-index="${index}">+</button>
                            </div>
                            <div class="item-price">Rp.${itemTotalPrice.toLocaleString('id-ID')}</div>
                        </div>
                        <i data-feather="trash-2" class="remove-item" data-index="${index}"></i>
                    `;
                    cartItemsElement.appendChild(cartItem);
                });
            }

            if (cartTotalPriceElement) cartTotalPriceElement.innerText = `Rp.${total.toLocaleString('id-ID')}`;
            if (productTotalPriceElement) productTotalPriceElement.innerText = `Rp.${total.toLocaleString('id-ID')}`;
            if (finalTotalPriceElement) finalTotalPriceElement.innerText = `Rp.${total.toLocaleString('id-ID')}`;
            
            feather.replace(); // Replace icons after updating the cart items

            document.querySelectorAll(".remove-item").forEach((button) => {
                button.addEventListener("click", function () {
                    const index = this.getAttribute("data-index");
                    cart.splice(index, 1);
                    updateCart();
                });
            });

            document.querySelectorAll(".quantity-btn.plus").forEach((button) => {
                button.addEventListener("click", function () {
                    const index = this.getAttribute("data-index");
                    const productCard = document.querySelector(`.product-card[data-id="${cart[index].id}"]`);
                    const stock = parseInt(productCard.getAttribute("data-stock"));

                    if (cart[index].quantity < stock) {
                        cart[index].quantity++;
                        updateCart();
                    } else {
                        showNotification("Stok tidak mencukupi untuk menambah produk.");
                    }
                });
            });

            document.querySelectorAll(".quantity-btn.minus").forEach((button) => {
                button.addEventListener("click", function () {
                    const index = this.getAttribute("data-index");
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

    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const productCard = this.closest(".product-card");
            const productId = productCard.getAttribute("data-id");
            const productName = productCard.getAttribute("data-name");
            const productPrice = parseInt(productCard.getAttribute("data-price"));
            const productWeight = parseInt(productCard.getAttribute("data-weight"));
            const productStock = parseInt(productCard.getAttribute("data-stock"));
            const productImgSrc = productCard.querySelector("img").getAttribute("src");

            const existingItemIndex = cart.findIndex((item) => item.id === productId);
            if (existingItemIndex > -1) {
                if (cart[existingItemIndex].quantity < productStock) {
                    cart[existingItemIndex].quantity++;
                } else {
                    showNotification("Stok tidak mencukupi untuk menambah produk.");
                    return; // Menghentikan eksekusi jika stok tidak mencukupi
                }
            } else {
                if (productStock > 0) {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        weight: productWeight,
                        imgSrc: productImgSrc,
                        quantity: 1,
                    });
                } else {
                    showNotification("Stok tidak mencukupi untuk menambah produk.");
                    return; // Menghentikan eksekusi jika stok tidak mencukupi
                }
            }
            updateCart();
            showNotification("Produk sudah dimasukkan ke dalam keranjang belanja");
        });
    });

    const cartIcon = document.getElementById("shopping-cart-icon");
    if (cartIcon && cartElement) {
        cartIcon.addEventListener("click", function () {
            toggleCart();
        });
    }

    function showNotification(message) {
        // Hapus notifikasi yang sudah ada sebelum menambahkan notifikasi baru
        document.querySelectorAll(".notification").forEach(notification => notification.remove());

        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.innerHTML = `
            <div class="notification-content">
                <i data-feather="info"></i>
                <p>${message}</p>
                <button class="button notification-ok-button">OK</button>
            </div>
        `;
        document.body.appendChild(notification);
        feather.replace(); // Replace icons in the notification

        // Cari tombol OK di dalam notifikasi yang baru dibuat
        const notificationOkButton = notification.querySelector(".notification-ok-button");
        if (notificationOkButton) {
            notificationOkButton.addEventListener("click", function () {
                notification.remove();
            });
        }
    }

    const courierSelect = document.getElementById('courier');
    if (courierSelect) {
        fetch('cek_ongkir.php', {
            method: 'POST',
            body: new URLSearchParams('get_couriers=true')
        })
        .then(response => response.json())
        .then(data => {
            if (data.couriers && Array.isArray(data.couriers)) {
                data.couriers.forEach(courier => {
                    var option = document.createElement('option');
                    option.value = courier;
                    option.textContent = courier.toUpperCase();
                    courierSelect.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    const calculateShippingButton = document.getElementById('calculate-shipping');
    if (calculateShippingButton) {
        calculateShippingButton.addEventListener('click', function () {
            var destination = document.getElementById('destination').value;
            var courier = document.getElementById('courier').value;
            var name = document.getElementById('name').value;
            var phone = document.getElementById('phone').value;
            var address = document.getElementById('address').value;
            var house_number = document.getElementById('house-number').value;
            var postal_code = document.getElementById('postal-code').value;
            var user_id = 1; // Ganti dengan user_id yang benar dari sesi atau variabel lain

            var totalWeight = cart.reduce((total, item) => total + (item.weight * item.quantity), 0);

            if (totalWeight <= 0) {
                alert("Total weight must be greater than zero.");
                return;
            }

            var formData = new FormData();
            formData.append('cek_ongkir', true);
            formData.append('destination', destination);
            formData.append('courier', courier);
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('address', address);
            formData.append('house_number', house_number);
            formData.append('postal_code', postal_code);
            formData.append('total_weight', totalWeight);
            formData.append('product_total_price', cartTotalPriceElement ? cartTotalPriceElement.innerText.replace('Rp.', '').replace(/\./g, '') : '0');
            formData.append('user_id', user_id); // Kirim user_id ke server

            fetch('cek_ongkir.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                var costElement = document.getElementById('shipping-cost');
                var totalShippingCostElement = document.getElementById('shipping-price');
                var finalTotalPriceElement = document.getElementById('final-total-price');
                var bankAccountElement = document.getElementById('bank-account');

                if (costElement && totalShippingCostElement && finalTotalPriceElement && bankAccountElement) {
                    if (data.error) {
                        showNotification(data.error);
                    } else {
                        var totalShippingCost = data.shipping_cost;
                        costElement.innerHTML = `<strong>Ongkos Kirim:</strong> Rp.${totalShippingCost.toLocaleString('id-ID')}`;
                        totalShippingCostElement.innerText = `Rp.${totalShippingCost.toLocaleString('id-ID')}`;
                        console.log("shippingPriceElement after calculation:", totalShippingCostElement.innerText); // Log tambahan
                        if (cartTotalPriceElement) {
                            const cartTotal = parseInt(cartTotalPriceElement.innerText.replace('Rp.','').replace(/\./g, ''));
                            const finalTotal = cartTotal + totalShippingCost;
                            finalTotalPriceElement.innerText = `Rp.${finalTotal.toLocaleString('id-ID')}`;

                            // Tampilkan nomor rekening
                            bankAccountElement.innerHTML = `
                                <strong>Nomor Rekening:</strong> ${data.bank_account}
                            `;

                            // Set order ID di form pembayaran
                            const orderIdElement = document.getElementById('order-id');
                            if (orderIdElement) {
                                orderIdElement.value = data.order_id;
                            }

                            // Update hidden form elements
                            const hiddenShippingCostElement = document.getElementById('hidden-shipping-cost');
                            const hiddenProductTotalPriceElement = document.getElementById('hidden-product-total-price');
                            const hiddenFinalTotalPriceElement = document.getElementById('hidden-final-total-price');

                            if (hiddenShippingCostElement && totalShippingCostElement) {
                                hiddenShippingCostElement.value = totalShippingCostElement.innerText.replace('Rp.', '').replace(/\./g, '');
                            }
                            if (hiddenProductTotalPriceElement && cartTotalPriceElement) {
                                hiddenProductTotalPriceElement.value = cartTotalPriceElement.innerText.replace('Rp.', '').replace(/\./g, '');
                            }
                            if (hiddenFinalTotalPriceElement && finalTotalPriceElement) {
                                hiddenFinalTotalPriceElement.value = finalTotalPriceElement.innerText.replace('Rp.', '').replace(/\./g, '');
                            }
                        }
                    }

                    // Tutup modal setelah perhitungan ongkir selesai
                    const alamatPengirimanModal = document.getElementById("alamatPengirimanModal");
                    if (alamatPengirimanModal) {
                        alamatPengirimanModal.style.display = "none";
                    }
                    if (cartElement) {
                        cartElement.scrollIntoView({ behavior: "smooth" });
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    const paymentForm = document.getElementById("payment-form");
    if (paymentForm) {
        paymentForm.addEventListener("submit", function (event) {
            event.preventDefault();
            console.log("Event submit form pembayaran dipicu"); // Log debug

            const orderIdElement = document.getElementById('order-id');
            const shippingPriceElement = document.getElementById('hidden-shipping-cost');
            const productTotalPriceElement = document.getElementById('hidden-product-total-price');
            const finalTotalPriceElement = document.getElementById('hidden-final-total-price');

            console.log("orderIdElement:", orderIdElement ? orderIdElement.value : 'null'); // Log debug
            console.log("shippingPriceElement:", shippingPriceElement ? shippingPriceElement.value : 'null'); // Log debug
            console.log("productTotalPriceElement:", productTotalPriceElement ? productTotalPriceElement.value : 'null'); // Log debug
            console.log("finalTotalPriceElement:", finalTotalPriceElement ? finalTotalPriceElement.value : 'null'); // Log debug

            // Cek ulang shippingPriceElement
            const updatedShippingPriceElement = document.getElementById('hidden-shipping-cost');
            console.log("Updated shippingPriceElement:", updatedShippingPriceElement ? updatedShippingPriceElement.value : 'null'); // Log tambahan

            if (orderIdElement && updatedShippingPriceElement && productTotalPriceElement && finalTotalPriceElement) {
                const formData = new FormData(paymentForm);
                formData.append('order_id', orderIdElement.value);
                formData.append('shipping_cost', updatedShippingPriceElement.value);
                formData.append('product_total_price', productTotalPriceElement.value);
                formData.append('total_price', finalTotalPriceElement.value);
                formData.append('cart', JSON.stringify(cart)); // Kirim data keranjang belanja

                console.log("Form Data sebelum dikirim:", ...formData.entries()); // Debugging: Log data form sebelum dikirim

                processCheckout(formData);
            } else {
                console.error("Error: Elemen form hilang"); // Log jika ada elemen form yang hilang
                showNotification("Form tidak lengkap, pastikan semua elemen tersedia."); // Notifikasi ke pengguna
            }
        });
    }

    function processCheckout(formData) {
        console.log("Proses checkout dimulai...");
        
        fetch('process_checkout.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log("Response diterima, status:", response.status);
            if (!response.ok) {
                // Jika status bukan 200, lemparkan kesalahan
                throw new Error("HTTP error, status = " + response.status);
            }
            return response.text(); // Ambil respons sebagai teks mentah
        })
        .then(text => {
            console.log("Respons mentah dari server:", text);
            let data;
            try {
                data = JSON.parse(text); // Coba parsing JSON
            } catch (error) {
                throw new Error("Kesalahan parsing JSON: " + error.message + " | Respons: " + text);
            }
            console.log("Data JSON dari server:", data);
    
            if (data.success) {
                console.log("Checkout berhasil, memperbarui stok...");
                // Kurangi stok setelah checkout berhasil
                if (data.cart && Array.isArray(data.cart)) {
                    data.cart.forEach(item => {
                        const productCard = document.querySelector(`.product-card[data-id="${item.id}"]`);
                        if (productCard) {
                            const stock = parseInt(productCard.getAttribute("data-stock")) - item.quantity;
                            productCard.setAttribute("data-stock", stock);
                            const stockElement = productCard.querySelector(".product-stock");
                            if (stockElement) {
                                stockElement.innerText = "Stok: " + stock;
                            } else {
                                console.error("Elemen stok tidak ditemukan untuk product ID:", item.id);
                            }
                        } else {
                            console.error("Product card tidak ditemukan untuk product ID:", item.id);
                        }
                    });
                } else {
                    console.error("Data cart hilang atau tidak valid:", data.cart);
                }
    
                showNotification("Checkout berhasil!");
                // Tutup keranjang belanja setelah checkout berhasil
                const cartElement = document.getElementById("shopping-cart");
                if (cartElement) {
                    cartElement.classList.remove("active");
                }
                // Kosongkan keranjang setelah checkout
                cart = [];
                updateCart();
            } else {
                console.error("Checkout gagal, pesan error dari server:", data.message);
                showNotification("Checkout gagal: " + data.message);
            }
        })
        .catch(error => {
            console.error('Kesalahan terjadi:', error);
            showNotification("Checkout gagal karena kesalahan: " + error.message);
        });
    }
    
    

    document.querySelectorAll(".item-detail-button").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const productCard = this.closest(".product-card");
            const overlay = productCard.querySelector(".deskripsi-overlay");
            if (overlay) {
                if (overlay.style.display === "none" || !overlay.style.display) {
                    overlay.style.display = "flex";
                } else {
                    overlay.style.display = "none";
                }
            }
        });
    });

    const contactForm = document.getElementById("contact-form");
    if (contactForm) {
        contactForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const name = document.getElementById("nama").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("nomor").value;
            const question = document.getElementById("pertanyaan").value;

            const message = `Halo, saya ${name}. Email saya adalah ${email}, nomor telepon saya adalah ${phone}. Pertanyaan saya adalah: ${question}`;

            const whatsappURL = `https://wa.me/6281288111722?text=${encodeURIComponent(message)}`;

            window.open(whatsappURL, "_blank");
        });
    }

    const backToProductsButton = document.getElementById("back-to-products");
    if (backToProductsButton && cartElement) {
        backToProductsButton.addEventListener("click", function (event) {
            event.preventDefault();
            cartElement.classList.remove("active");
        });
    }

    const enterShippingDetailsButton = document.getElementById("enter-shipping-details");
    if (enterShippingDetailsButton) {
        enterShippingDetailsButton.addEventListener("click", function () {
            const alamatPengirimanModal = document.getElementById("alamatPengirimanModal");
            if (alamatPengirimanModal) {
                alamatPengirimanModal.style.display = "block";
            }
        });
    }

    const modal = document.getElementById("alamatPengirimanModal");
    const span = document.getElementsByClassName("close")[0];

    if (span) {
        span.onclick = function () {
            if (modal) {
                modal.style.display = "none";
            }
        };
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    function toggleCart() {
        const cartElement = document.getElementById("shopping-cart");
        if (cartElement) {
            cartElement.classList.toggle("active");
        }
    }

    updateCart();

    const loginForm = document.getElementById('login-form');
    const loginSection = document.getElementById('login-section');
    const contentSection = document.getElementById('content-section');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === 'user' && password === 'password') {
                if (loginSection) loginSection.classList.add('hidden');
                if (contentSection) contentSection.classList.remove('hidden');
                document.body.classList.remove('locked');
            } else {
                alert('Login gagal. Silakan periksa kredensial Anda dan coba lagi.');
            }
        });
    }
});

