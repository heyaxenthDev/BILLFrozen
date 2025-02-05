<?php
// Include your database connection file
include 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the statement
    $stmt = $conn->prepare("UPDATE `product_list` SET `product_name` = ?, `category` = ?, `price` = ? WHERE `id` = ?");
    $stmt->bind_param("ssdi", $productName, $productCategory, $productPrice, $productId);

    // Set the product details from the form
    $productId = $_POST['editProductId'];
    $productName = $_POST['editProductName'];
    $productPrice = $_POST['editProductPrice'];
    $productCategory = $_POST['editProductCategory'];

    // Execute the statement
    if ($stmt->execute()) {
        // Set the success message in session status
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Product updated successfully";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        // Set the error message in session status
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error updating product: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
}

// Close the database connection
$conn->close();