// Feather Icons
feather.replace();

// untuk menambahkan kelas aktif pada navbar saat digulir
window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('active');
    } else {
        navbar.classList.remove('active');
    }
});

// Toggle class active untuk form pencarian
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('search-box');
    const searchIcon = document.getElementById('search-icon');
    const searchSubmitButton = document.getElementById('search-submit-button');

    // Event listener untuk klik pada ikon pencarian
    searchIcon.addEventListener('click', function() {
        const searchForm = document.querySelector('.search-form');
        searchForm.classList.toggle('active');
    });

    // Event listener untuk klik pada tombol pencarian
    searchSubmitButton.addEventListener('click', function() {
        const searchTerm = searchBox.value.trim().toLowerCase();
        const products = document.querySelectorAll('.product-card');

        products.forEach(function(product) {
            const productName = product.querySelector('.product-card-title').textContent.toLowerCase();

            if (productName.includes(searchTerm)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        searchBox.value = '';
    });

    // Event listener untuk menambahkan produk ke keranjang
    const cart = [];
    const cartElement = document.getElementById('shopping-cart');

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            const productName = productCard.getAttribute('data-name');
            const productPrice = productCard.getAttribute('data-price');

            cart.push({ name: productName, price: productPrice });
            updateCart();
        });
    });

    // Fungsi untuk memperbarui keranjang belanja
    function updateCart() {
        cartElement.innerHTML = '';
        cart.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <div class="item-detail">
                    <h3>${item.name}</h3>
                    <div class="item-price">Rp.${item.price}</div>
                </div>
                <i data-feather="trash-2" class="remove-item"></i>
            `;
            cartElement.appendChild(cartItem);
        });
        feather.replace(); // Refresh feather icons
    }

    // Event listener untuk menampilkan deskripsi produk
    document.querySelectorAll('.item-detail-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.product-card');
            productCard.classList.toggle('show-description');
        });
    });
});


// Menghubungkan form kontak ke WhatsApp
function submitForm(event) {
    event.preventDefault();

    const name = document.getElementById('nama').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('nomor').value;
    const question = document.getElementById('pertanyaan').value;

    const message = `Halo, saya ${name}. Email saya adalah ${email}, nomor telepon saya adalah ${phone}. Pertanyaan saya adalah: ${question}`;

    const whatsappURL = `https://wa.me/6281288111722?text=${encodeURIComponent(message)}`;

    window.open(whatsappURL, '_blank');
}
