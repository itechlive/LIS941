let cart = JSON.parse(localStorage.getItem('cart')) || [];

function createTable() {
    let table = document.createElement('table');
    let thead = document.createElement('thead');
    let tbody = document.createElement('tbody');

    ['Nombre', 'Detalle', 'Precio', 'Descuento', 'Cantidad', 'Subtotal', 'Acciones'].forEach(headerText => {
        let th = document.createElement('th');
        th.appendChild(document.createTextNode(headerText));
        thead.appendChild(th);
    });

    cart.forEach((item, index) => {
        let tr = document.createElement('tr');

        ['title', 'description', 'price', 'discount', 'quantity'].forEach(key => {
            let td = document.createElement('td');
            td.appendChild(document.createTextNode(item[key]));
            tr.appendChild(td);
        });

        let subtotal = item.price * item.quantity * (1 - item.discount / 100);
        let tdSubtotal = document.createElement('td');
        tdSubtotal.appendChild(document.createTextNode(subtotal.toFixed(2)));
        tr.appendChild(tdSubtotal);

        let tdActions = document.createElement('td');
        let removeButton = document.createElement('button');
        removeButton.innerHTML = '<i class="fas fa-trash"></i>';
        removeButton.addEventListener('click', () => removeFromCart(index));
        tdActions.appendChild(removeButton);

        let decreaseButton = document.createElement('button');
        decreaseButton.innerHTML = '<i class="fas fa-minus"></i>';
        decreaseButton.addEventListener('click', () => decreaseQuantity(index));
        tdActions.appendChild(decreaseButton);

        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    });

    table.appendChild(thead);
    table.appendChild(tbody);
    document.body.appendChild(table);

    let totalAmount = document.createElement('p');
    totalAmount.className = 'amount';
    totalAmount.textContent = 'Monto Total: $' + calculateTotal();
    document.body.appendChild(totalAmount);

    let iva = document.createElement('p');
    iva.className = 'amount';
    iva.textContent = 'IVA (13%): $' + calculateIVA();
    document.body.appendChild(iva);

    let totalWithIVA = document.createElement('p');
    totalWithIVA.className = 'amount';
    totalWithIVA.textContent = 'Monto Total/IVA: $' + calculateTotalWithIVA();
    document.body.appendChild(totalWithIVA);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload();
}

function decreaseQuantity(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
    }
}

function calculateTotal() {
    let total = cart.reduce((sum, item) => sum + item.price * item.quantity * (1 - item.discount / 100), 0);
    return total.toFixed(2);
}

function calculateIVA() {
    let iva = calculateTotal() * 0.13;
    return iva.toFixed(2);
}

function calculateTotalWithIVA() {
    let totalWithIVA = parseFloat(calculateTotal()) + parseFloat(calculateIVA());
    return totalWithIVA.toFixed(2);
}

createTable();
