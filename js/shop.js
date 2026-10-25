// Script simple para incrementar el contador de la cesta al hacer clic

let cartCount = 0;
function addToCart() {
    cartCount++;
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.innerText = cartCount;
    }
}
