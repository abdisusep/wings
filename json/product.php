<?php
    header('Content-Type: application/json');

    include "../config/db.php";
    
    $search = $_GET['search'];
    $sql = "SELECT id, product_name, price FROM product WHERE product_name LIKE '%$search%'";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    echo json_encode($products);
?>
