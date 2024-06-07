<?php  
	session_start();
	header('Content-Type: application/json');

	include "../config/db.php";
    include "../config/func.php";

	$data = json_decode(file_get_contents('php://input'), true);
	$items = $data['items'];
	$total = $data['total'];


	if (empty($items)) {
	    $response = ['status' => 'failed', 'message' => 'Your cart is empty.'];
	    echo json_encode($response);
	}else{
		$sqlCount = "SELECT COUNT(*) AS count FROM transaction_header";
		$resultCount = $conn->query($sqlCount);
		$rowCount = $resultCount->fetch_assoc();

		$docCode   = 'TRX';
		$docNumber = $rowCount['count'] + 1;

		$user = $_SESSION['user'];
		$sqlUser = "SELECT id FROM login WHERE user='$user'";
		$resultUser = $conn->query($sqlUser);
		$rowUser = $resultUser->fetch_assoc();

		$user_id = $rowUser['id'];
		$date = date('Y-m-d');
		$sqlHeader = "INSERT INTO transaction_header (document_code, document_number, user_id, total, date) 
		VALUES ('$docCode', '$docNumber', '$user_id', '$total', '$date')";
		$resultHeader = $conn->query($sqlHeader);

		$sqlId = "SELECT id FROM transaction_header WHERE document_number='$docNumber'";
		$resultId = $conn->query($sqlId);
		$rowId = $resultId->fetch_assoc();
		$idHeader = $rowId['id'];

		if ($resultHeader) {
			foreach ($items as $item) {
			    $total += $item['price'] * $item['qty'];

			    $subtotal = $item['price'] * $item['qty'];
			    $sqlDetail = "INSERT INTO transaction_detail (transaction_header_id, document_code, document_number, product_id, price, quantity, unit, subtotal, currency)	VALUES ('$idHeader', '$docCode', '$docNumber', '{$item['id']}', '{$item['price']}', '{$item['qty']}', '{$item['unit']}', '$subtotal', '{$item['currency']}')";
				$resultDetail = $conn->query($sqlDetail);
			}
		}

		echo json_encode(['status' => 'success']);
	}

?>