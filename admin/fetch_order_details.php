<?php
// Include your database connection file
include 'includes/conn.php';

if (isset($_POST['orderCode'])) {
    $orderCode = $_POST['orderCode'];

    // Fetch order details from the database
    $query = "SELECT * FROM orders WHERE order_code = '$orderCode'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $orderDetails = mysqli_fetch_assoc($result);

        // Fetch items for the order
        $itemQuery = "SELECT * FROM order_items WHERE order_code = '$orderCode'";
        $itemResult = mysqli_query($conn, $itemQuery);
        $items = array();
        $grandTotal = 0;
        while ($itemRow = mysqli_fetch_assoc($itemResult)) {
            $itemTotal = $itemRow['unit_price'] * $itemRow['quantity'];
            $grandTotal += $itemTotal;
            $items[] = array(
                'productName' => $itemRow['product_name'],
                'unitPrice' => $itemRow['unit_price'],
                'quantity' => $itemRow['quantity'],
                'totalPrice' => $itemTotal
            );
        }

        // Prepare data to be sent back as JSON
        $response = array(
            'orderCode' => $orderDetails['order_code'],
            'customerName' => $orderDetails['customer_name'],
            'deliveryAddress' => $orderDetails['delivery_address'],
            'deliveryDate' => $orderDetails['delivery_date'],
            'items' => $items,
            'grandTotal' => $grandTotal
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Order not found'));
    }
} else {
    echo json_encode(array('error' => 'Order code not provided'));
}