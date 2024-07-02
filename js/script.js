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


// Toggle deskripsi produk
document.querySelectorAll('.item-detail-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const productCard = this.closest('.product-card');
        const overlay = productCard.querySelector('.description-overlay');
        overlay.style.display = (overlay.style.display === 'block') ? 'none' : 'block';
    });
});

// Mematikan lampu (contoh sederhana)
document.querySelector('#turn-off-button').addEventListener('click', function(e) {
    const lampElement = document.querySelector('#lamp');
    lampElement.style.backgroundColor = '#000';
    lampElement.style.color = '#fff';
    lampElement.innerHTML = 'Lampu Mati';
    e.preventDefault();
});
