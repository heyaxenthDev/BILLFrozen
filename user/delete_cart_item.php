<?php
session_start();

include 'includes/conn.php';
// Check if product code is provided in the POST request
if (isset($_POST['product_code'])) {
    $productCode = $_POST['product_code'];
    $user_id = $_SESSION['user']['user_id'];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM cart WHERE `product_code` = ? AND `user_id` = ?");
    $stmt->bind_param("ss", $productCode, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Item deleted successfully";
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Product code not provided";
}