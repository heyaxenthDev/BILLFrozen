<?php
include 'includes/conn.php';
// Check if product code is provided in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM product_list WHERE `id` = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Product code not provided";
}