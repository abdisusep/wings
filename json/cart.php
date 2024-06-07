<?php
    include "../config/db.php";

    header('Content-Type: application/json');

    $id     = $_GET['id'];

    $sql    = "SELECT * FROM product WHERE id='$id'";
    $result = $conn->query($sql);
    $row    = $result->fetch_assoc();

    $product = [
        'product_name' => $row['product_name'],
        'price' => $row['price'],
        'currency' => $row['currency'],
        'unit' => $row['unit'],
        'discount' => $row['discount'],
    ];

    echo json_encode(['status' => 'success', 'data' => $product]);
?>