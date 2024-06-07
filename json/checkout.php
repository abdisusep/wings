<?php  
	header('Content-Type: application/json');

	include "../config/db.php";
    include "../config/func.php";

	$data = json_decode(file_get_contents('php://input'), true);
	$items = $data['items'];

	if (empty($items)) {
	    $response = ['status' => 'failed', 'message' => 'Your cart is empty.'];
	    echo json_encode($response);
	    exit();
	}else{
		$docCode   = 'TRX';
		$docNumber = '003';
		$sqlHeader = "INSERT INTO transaction_header (document_code, document_number, user_id, total, date) 
		VALUES ('$docCode', '$docNumber', '1', '100000000', '2024-01-01')";
		$resultHeader = $conn->query($sqlHeader);

		if ($resultHeader) {
			$idHeader = 1;
			$total = 0;
			foreach ($items as $item) {
			    $total += $item['price'] * $item['qty'];

			    $sqlDetail = "INSERT INTO transaction_detail (transaction_header_id, document_code, document_number, product_id, price, quantity, unit, subtotal, currency)	VALUES ('$idHeader', '$docCode', '$docNumber', '1', '100000000', '2024-01-01')";
				$resultDetail = $conn->query($sqlDetail);
			}
		}

		echo json_encode(['status' => 'success', 'tes' => $result]);
	}

?>