loadProduct();
loadCart();

$('#searchProduct').on('input', function() {
    loadProduct();
});

function loadProduct(params) {
    let searchValue = $('#searchProduct').val();

    $.ajax({
        url: 'json/product.php',
        dataType: 'json',
        data: {
            search: searchValue
        },
        success: function(data) {
            $('#productList').empty();
            data.forEach(function(product) {
                let price = 0;
                if (product.discount > 0) {
                    let discountedPrice = product.price - (product.price * (product.discount / 100)).toFixed(3);
                    discountedPrice = discountedPrice.toFixed(3);
                    price = '<p><span style="text-decoration: line-through;">Rp. ' + product.price + '</span> <span>Rp. ' + discountedPrice + '</span></p>';
                } else {
                    price = '<p><span>Rp. ' + product.price + '</span></p>';
                }

                let html = '<div class="col-sm-4 mb-3">';
                html += '<div class="card border-0 shadow-sm">';
                html += '<div class="card-body">';
                html += '<h5><a href="?p=detail&id=' + product.id + '" class="text-decoration-none text-dark">' + product.product_name + '</a></h5>';
                html += price;
                html += '<button class="btn btn-sm btn-primary" onclick="addToCart(' + product.id + ')">Buy</button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#productList').append(html);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error loading products:', error);
        }
    });
}

function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalCart = 0;
    let totalPrice = 0;
    cart.forEach(function(item, index) {
        let row = '<div class="row">';
        row += '<div class="col-10">';
        row += '<h6>' + item.name + '</h6>';
        row += '<input type="number" style="width:50px;" value="' + item.qty + '" data-index="' + index + '"> <span>' + item.unit + '</span>';
        row += '<p>Subtotal : Rp. ' + formatRp(item.price * item.qty) + '</p>';
        row += '</div>';
        row += '<div class="col-2 pt-4">';
        row += '<span class="text-danger fw-bold" onclick="deleteFromCart(' + item.id + ')">X</span>';
        row += '</div>';
        row += '</div>';

        $('#listCart').append(row);
        totalCart = totalCart + 1;
        totalPrice = totalPrice + (item.price * item.qty);
    });

    $('#listCart input[type="number"]').change(function() {
        let index = $(this).data('index');
        let newQty = parseInt($(this).val());
        updateCartQuantity(index, newQty);
    });

    $('#totalCheckoutShow').text(formatRp(totalPrice));
    $('#totalCheckout').text(totalPrice);

    if (totalCart > 0) {
        $('#totalCart').removeClass('d-none');
    } else {
        $('#totalCart').addClass('d-none');
    }
}

function addToCart(id) {
    console.log(id)
    $.ajax({
        url: 'json/cart.php',
        dataType: 'json',
        data: {
            id: id
        },
        success: function(response) {
            console.log(response.data.product_name)
            if (response.status === 'success') {
                let discountedPrice = response.data.price - (response.data.price * (response.data.discount / 100)).toFixed(3);
                let product = {
                    id: id,
                    name: response.data.product_name,
                    price: discountedPrice,
                    discount: response.data.discount,
                    qty: 1,
                    unit: response.data.unit,
                    currency: response.data.currency
                };

                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                let existingProductIndex = cart.findIndex(item => item.id === product.id);

                if (existingProductIndex === -1) {
                    cart.push(product);
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                $('#listCart').empty();
                loadCart();
            }
        }
    });
}

function updateCartQuantity(index, newQty) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (Array.isArray(cart)) {
        if (index >= 0 && index < cart.length) {
            cart[index].qty = newQty;
            localStorage.setItem('cart', JSON.stringify(cart));

            // Memperbarui subtotal di tampilan
            let subtotal = cart[index].price * newQty;
            $('#listCart .row').eq(index).find('.subtotal').text('Subtotal : Rp. ' + subtotal);
        } else {
            console.log('Index item tidak valid.');
        }
    } else {
        console.log('Data keranjang belanja tidak ditemukan atau bukan dalam format yang benar.');
    }

    $('#listCart').empty();
    loadCart();
}

function deleteFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let index = cart.findIndex(item => item.id === id);

    if (index !== -1) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        $('#listCart').empty();
        loadCart();
    } else {
        console.log('Not found');
    }
}

function confirmCheckout() {
    Swal.fire({
        title: "Are you sure?",
        text: "Save transaction",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const total = $('#totalCheckout').text();

            const transactionData = {
                total: total,
                items: cart
            };

            $.ajax({
                url: 'json/checkout.php',
                method: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                success: function(response) {
                    console.log(response)
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: 'Success',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        localStorage.removeItem('cart');
                        $('#listCart').empty();
                        loadCart();
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });
        }
    });
}

function formatRp(angka) {
    var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
}