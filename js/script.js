document.addEventListener("DOMContentLoaded", function () {
    feather.replace();

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

    let cart = [];
    const cartElement = document.getElementById("shopping-cart");
    const cartItemsElement = document.querySelector(".cart-items");
    const cartTotalPriceElement = document.getElementById("total-price");
    const totalShippingCostElement = document.getElementById("shipping-price");
    const finalTotalPriceElement = document.getElementById("final-total-price");

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
                    cart[index].quantity++;
                    updateCart();
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
            const productName = productCard.getAttribute("data-name");
            const productPrice = parseInt(productCard.getAttribute("data-price"));
            const productWeight = parseInt(productCard.getAttribute("data-weight"));
            const productImgSrc = productCard.querySelector("img").getAttribute("src");

            const existingItemIndex = cart.findIndex((item) => item.name === productName);
            if (existingItemIndex > -1) {
                cart[existingItemIndex].quantity++;
            } else {
                cart.push({
                    name: productName,
                    price: productPrice,
                    weight: productWeight,
                    imgSrc: productImgSrc,
                    quantity: 1,
                });
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
        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.innerHTML = `
            <div class="notification-content">
                <i data-feather="check-circle"></i>
                <p>${message}</p>
                <button class="button" id="notification-ok-button">OK</button>
            </div>
        `;
        document.body.appendChild(notification);
        feather.replace();

        document.getElementById("notification-ok-button").addEventListener("click", function () {
            notification.remove();
        });
    }

    const courierSelect = document.getElementById('courier');

    fetch('cek_ongkir.php', {
        method: 'POST',
        body: new URLSearchParams('get_couriers=true')
    })
    .then(response => response.json())
    .then(data => {
        console.log("Courier Data: ", data); // Log data kurir untuk debugging
        if (data.couriers) {
            data.couriers.forEach(courier => {
                var option = document.createElement('option');
                option.value = courier;
                option.textContent = courier.toUpperCase();
                courierSelect.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Error:', error));

    document.getElementById('calculate-shipping').addEventListener('click', function () {
        var destination = document.getElementById('destination').value;
        var courier = document.getElementById('courier').value;

        var formData = new FormData();
        formData.append('cek_ongkir', true);
        formData.append('destination', destination);
        formData.append('courier', courier);

        fetch('cek_ongkir.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            return response.text().then(text => {
                console.log("Response Text: ", text); // Log respons untuk debugging
                if (text.trim() === "") {
                    throw new Error("Empty response");
                }
                try {
                    return JSON.parse(text);
                } catch (error) {
                    console.error("JSON parsing error: ", error, text); // Log detail error
                    throw new Error("Invalid JSON: " + text);
                }
            });
        })
        .then(data => {
            var costElement = document.getElementById('shipping-cost');
            var totalShippingCostElement = document.getElementById('shipping-price');
            var finalTotalPriceElement = document.getElementById('final-total-price');
            
            costElement.innerHTML = '';
            var totalShippingCost = 0;

            if (data.error) {
                costElement.innerHTML = data.error;
            } else if (data.rajaongkir && data.rajaongkir.results) {
                var results = data.rajaongkir.results;
                if (results.length > 0 && results[0].costs.length > 0) {
                    results.forEach(result => {
                        result.costs.forEach(cost => {
                            totalShippingCost += cost.cost[0].value;
                            costElement.innerHTML += `<div>
                                <strong>Kurir: ${result.name}</strong><br>
                                Service: ${cost.service}<br>
                                Description: ${cost.description}<br>
                                Cost: Rp ${cost.cost[0].value.toLocaleString('id-ID')}<br>
                                Estimated Delivery Time: ${cost.cost[0].etd} days<br><br>
                            </div>`;
                        });
                    });
                    if (totalShippingCostElement) totalShippingCostElement.innerText = `Rp.${totalShippingCost.toLocaleString('id-ID')}`;
                    if (finalTotalPriceElement && cartTotalPriceElement) finalTotalPriceElement.innerText = `Rp.${(parseInt(cartTotalPriceElement.innerText.replace('Rp.','').replace('.','')) + totalShippingCost).toLocaleString('id-ID')}`;
                } else {
                    costElement.innerHTML = "Tidak ada hasil yang ditemukan.";
                    if (totalShippingCostElement) totalShippingCostElement.innerText = "Rp.0";
                    if (finalTotalPriceElement && cartTotalPriceElement) finalTotalPriceElement.innerText = `Rp.${parseInt(cartTotalPriceElement.innerText.replace('Rp.','').replace('.','')).toLocaleString('id-ID')}`;
                }
            } else {
                costElement.innerHTML = "Tidak ada hasil yang ditemukan.";
                if (totalShippingCostElement) totalShippingCostElement.innerText = "Rp.0";
                if (finalTotalPriceElement && cartTotalPriceElement) finalTotalPriceElement.innerText = `Rp.${parseInt(cartTotalPriceElement.innerText.replace('Rp.','').replace('.','')).toLocaleString('id-ID')}`;
            }
        })
        .catch(error => console.error('Error:', error));
    });

    const paymentForm = document.getElementById("payment-form");
    if (paymentForm) {
        paymentForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(paymentForm);
            processCheckout(formData);
        });
    }

    function processCheckout(formData) {
        console.log("Checkout Data:", formData);
        const checkoutForm = document.querySelector(".checkout-form");
        if (checkoutForm) checkoutForm.remove();
        alert("Checkout berhasil!");
    }

    document.querySelectorAll(".item-detail-button").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const productCard = this.closest(".product-card");
            const overlay = productCard.querySelector(".deskripsi-overlay");
            if (overlay.style.display === "none" || !overlay.style.display) {
                overlay.style.display = "flex";
            } else {
                overlay.style.display = "none";
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
            document.getElementById("alamatPengirimanModal").style.display = "block";
        });
    }

    var modal = document.getElementById("alamatPengirimanModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function () {
        modal.style.display = "none";
    };

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
                loginSection.classList.add('hidden');
                contentSection.classList.remove('hidden');
                document.body.classList.remove('locked');
            } else {
                alert('Login gagal. Silakan periksa kredensial Anda dan coba lagi.');
            }
        });
    }
});
