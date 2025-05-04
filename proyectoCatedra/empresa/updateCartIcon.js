document.addEventListener('DOMContentLoaded', (event) => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartPlusSign = document.getElementById('cart-plus-sign');
    if (cart.length > 0) {
        cartPlusSign.textContent = '+';
    }
});
