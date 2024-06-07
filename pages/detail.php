<?php  

$id = $_GET['id'];
$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$detail = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'layout/navbar.php'; ?>
    
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-6">
                <a href="index.php" class="btn btn-sm btn-primary">< Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5><a href="?p=detail" class="text-decoration-none text-dark"><?= $detail['product_name']; ?></a></h5>
                        <p><span>Rp. <?= formatRp($detail['price']); ?></span></p>
                        <p class="mb-0"><span>Dimension : <?= $detail['dimension']; ?></span></p>
                        <p><span>Price Unit : <?= $detail['unit']; ?></span></p>
                        <button class="btn btn-sm btn-primary" onclick="addToCart(3)">Buy</button>
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
    <script src="assets/js/script.js"></script>
</body>
</html> 