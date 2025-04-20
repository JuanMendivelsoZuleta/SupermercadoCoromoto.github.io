const cartIcon = document.querySelector("#cart-icon");
const cart = document.querySelector(".cart");
const cartClose = document.querySelector("#cart-close");
const cartContent = document.querySelector(".cart-content"); 

// Mostrar carrito al hacer clic en el icono
cartIcon.addEventListener("click", () => cart.classList.add("active"));
cartClose.addEventListener("click", () => cart.classList.remove("active"));

// Botones "Comprar" que agregan productos al carrito
const addCartButtons = document.querySelectorAll(".add-cart");

addCartButtons.forEach(button => {
    button.addEventListener("click", event => {
        const productBox = event.target.closest(".product-box");
        addToCart(productBox); // Llamar a la función que agrega el producto al carrito
    });
});

// Función que agrega un producto al carrito
const addToCart = (productBox) => {
    const productImgSrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".product-title").textContent;
    const productPrice = productBox.querySelector(".price").textContent;

// Alerta de doble producto en el carrito
    const cartItems = cartContent.querySelectorAll(".cart-product-title");
    for(let item of cartItems){
        if (item.textContent === productTitle){
            alert("Este podructo ya se encuentra en el carrito.")
            return;
        }
    }

    // Crear el contenedor del producto en el carrito
    const cartBox = document.createElement("div");
    cartBox.classList.add("cart-box");
    cartBox.innerHTML = `
        <img src="${productImgSrc}" class="cart-img">
        <div class="cart-detail">
            <h2 class="cart-product-title">${productTitle}</h2>
            <span class="cart-price">${productPrice}</span>
              <div class="cart-quantity">
                <button id="decrement">-</button>
                <span class="number">1</span>
                <button id="increment">+</button>
              </div>
            </div>
            <i class="ri-delete-bin-line cart-remove"></i>
    `;

    // Agregar el producto al carrito
    cartContent.appendChild(cartBox);


    cartBox.querySelector(".cart-remove").addEventListener("click", () => {
        cartBox.remove();

        updateTotalPrice();
    })

    cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
        const numberElement = cartBox.querySelector(".number");
        const decrementButton = cartBox.querySelector("#decrement");
        let quantity = numberElement.textContent;
      
        if (event.target.id === "decrement" && quantity > 1) {
          quantity--;
          if (quantity === 1) {
            decrementButton.style.color = "#999";
          }
        } else if (event.target.id === "increment") {
          quantity++;
          decrementButton.style.color = "#333";
        }
      
        numberElement.textContent = quantity;

        updateTotalPrice();
      });

      updateTotalPrice();
};
//El total funcione
const updateTotalPrice = () => {
    const totalPriceElement = document.querySelector(".total-price");
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
    let total = 0;
    cartBoxes.forEach(cartBox => {
      const priceElement = cartBox.querySelector(".cart-price");
      const quantityElement = cartBox.querySelector(".number");
      const price = priceElement.textContent.replace("$", "")
      const quantity = quantityElement.textContent;
      total += price * quantity;
    });
  
    totalPriceElement.textContent = `$${total}`; 
  };

//Comprar
const buyNowButton = document.querySelector(".btn-buy");
buyNowButton.addEventListener("click", () => {
  const cartBoxes = cartContent.querySelectorAll(".cart-box");
  if (cartBoxes.length === 0) {
    alert("Tu carrito esta vacío, por favor ingresa productos a tu carrito antes de comprar.");
    return;
  }

  alert("Gracias por tu compra!");
  cartBoxes.forEach(cartBox => cartBox.remove());

  cartItemCount = 0;
  updateCartCount(0);
  totalPriceElement(0);
  updateTotalPrice();

});