<?php
// Include your database connection file
include 'includes/conn.php';

// Get the order_code from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$orderCode = $data['order_code'];

// Query to fetch order information
$query = "SELECT * FROM `orders` WHERE order_code = '$orderCode'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Fetch order items information
    $itemQuery = "SELECT `product_name`, `quantity`, `total_price`, `order_status` FROM `orders` WHERE `order_code` = ?";
    $stmt = $conn->prepare($itemQuery);
    $stmt->bind_param("s", $orderCode);
    $stmt->execute();
    $itemResult = $stmt->get_result();
    $items = [];
    while ($itemRow = $itemResult->fetch_assoc()) {
        $items[] = $itemRow;
    }

    // Calculate grand total
    $grandTotal = 0;
    foreach ($items as $item) {
        $grandTotal += $item['total_price'];
    }

    // Construct the response data
    $responseData = [
        'user_id' => $row['user_id'],
        'order_status' => $row['order_status'],
        'order_code' => $row['order_code'],
        'name' => $row['name'],
        'contact' => $row['contact'],
        'delivery_address' => $row['delivery_address'],
        'delivery_date' => $row['delivery_date'],
        'items' => $items,
        'grand_total' => number_format($grandTotal, 2)
    ];


    // Return the response data as JSON
    echo json_encode($responseData);
} else {
    // If no order found, return an empty response
    echo json_encode([]);
}

// Close the database connection
mysqli_close($conn);
?>