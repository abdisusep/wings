<?php  

$sql = "SELECT a.*, b.user FROM transaction_header a LEFT JOIN login b ON a.user_id=b.id";
$result = $conn->query($sql);

$list = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $list .= " <tr>
            <td>{$row['document_code']}{$row['document_number']}</td>
            <td>{$row['user']}</td>
            <td>Rp. " .formatRp($row['total']). "</td>
            <td>{$row['date']}</td>
            <td>
                <span>- 1 x 1</span><br>
                <span>- Product 2 x 1</span><br>
            </td>
        </tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'layout/navbar.php'; ?>
    
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-6">
                <h4>Report Penjualan</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $list; ?>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html> 