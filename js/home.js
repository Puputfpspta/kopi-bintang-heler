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

  // Pencarian produk
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
  
        const whatsappURL = `https://wa.me/6281288111722?text=${encodeURIComponent(
          message
        )}`;
  
        window.open(whatsappURL, "_blank");
      });
  }
});