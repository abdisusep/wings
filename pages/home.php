<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'layout/navbar.php'; ?>

    <div class="container">
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <form action="">
                                    <input type="text" class="form-control" id="searchProduct" placeholder="Search...">
                                </form>
                            </div>
                        </div>
                        <div class="row" id="productList">
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5><a href="?p=detail" class="text-decoration-none text-dark">Soklin Pewangi</a></h5>
                                        <p><span>Rp. 150000</span></p>
                                        <button class="btn btn-sm btn-primary" onclick="addToCart(1)">Buy</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5><a href="?p=detail" class="text-decoration-none text-dark">Soklin Lantai</a></h5>
                                        <p><span>Rp. 150000</span></p>
                                        <button class="btn btn-sm btn-primary" onclick="addToCart(2)">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Checkout</h5>
                        <hr>
                        <div id="listCart"></div>
                        <div class="mb-3">
                            <h5>Total : Rp. <span id="total"></span></h5>
                        </div>
                        <button class="btn btn-primary" onclick="confirmCheckout()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        loadProduct();
        loadCart();

        $('#searchProduct').on('input', function() {
            loadProduct();
            console.log('a')
        });

        function loadProduct(params) {
            let searchValue = $('#searchProduct').val();

            $.ajax({
                url: 'json/product.php',
                dataType: 'json',
                data: { search: searchValue }, 
                success: function(data) {
                    $('#productList').empty();
                    data.forEach(function(product) {
                        // Buat elemen HTML untuk setiap produk
                        let html = '<div class="col-sm-4">';
                        html += '<div class="card border-0 shadow-sm">';
                        html += '<div class="card-body">';
                        html += '<h5><a href="?p=detail" class="text-decoration-none text-dark">' + product.product_name + '</a></h5>';
                        html += '<p><span>Rp. ' + product.price + '</span></p>';
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

            cart.forEach(function(item, index) {
                    let row = '<div class="row">';
                    row += '<div class="col-10">';
                    row += '<h6>' + item.name + '</h6>';
                    row += '<input type="number" style="width:50px;" value="' + item.qty + '" data-index="' + index + '"> <span>' + item.unit + '</span>';
                    row += '<p>Subtotal : Rp. ' + (item.price * item.qty) + '</p>';
                    row += '</div>';
                    row += '<div class="col-2 pt-4">';
                    row += '<span class="text-danger fw-bold" onclick="deleteFromCart(' + item.id + ')">X</span>';
                    row += '</div>';
                    row += '</div>';

                    $('#listCart').append(row);
                });

                $('#listCart input[type="number"]').change(function() {
                    let index = $(this).data('index');
                    let newQty = parseInt($(this).val());
                    updateCartQuantity(index, newQty);
                });
        }   

        function addToCart(id) {
            let product = {
                id: id,
                name: 'Product ' + id,
                price: 100000,
                qty: 1,
                unit: 'PCS'
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
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem('cart');
                        $('#listCart').empty();
                        loadCart();
                    }
                });
        }
    </script>
</body>
</html> 