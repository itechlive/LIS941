function buy() {
    Swal.fire({
        title: 'La transaccion ha sido realizada existosamente',
        text: 'Desea imprimir comprobante?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            printReceipt();
            localStorage.clear();
            location.reload();
        }
    });
}

function printReceipt() {
    let doc = new jsPDF();
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let y = 20;
    cart.forEach((item, index) => {
        doc.text(20, y, `Item ${index + 1}: ${item.title}`);
        doc.text(20, y + 10, `Detalle: ${item.description}`);
        doc.text(20, y + 20, `Precio: ${item.price}`);
        doc.text(20, y + 30, `Descuento: ${item.discount}`);
        doc.text(20, y + 40, `Cantidad: ${item.quantity}`);
        y += 50;
    });
    doc.save('receipt.pdf');
}
