<?php
session_start();
include 'includes/conn.php';


if (isset($_POST['AddtoCartBtn'])) {
    $user_id = $_SESSION['user']['user_id'];
    $username = $_SESSION['user']['username'];
    $product_code = mysqli_real_escape_string($conn, $_POST['product_code']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Check if the item already exists in the cart
    $check_query = "SELECT * FROM `cart` WHERE `user_id` = ? AND `product_code` = ? AND `product_name` = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "iss", $user_id, $product_code, $product_name);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Update the quantity if the item exists
        $new_quantity = $row['added_quantity'] + $quantity;
        $update_query = "UPDATE `cart` SET `added_quantity` = ? WHERE `user_id` = ? AND `product_code` = ? AND `product_name` = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "isss", $new_quantity, $user_id, $product_code, $product_name);
        mysqli_stmt_execute($update_stmt);
        $_SESSION['cart'] = "success";
        $_SESSION['cart_text'] = "Item quantity updated in cart.";
    } else {
        // Insert a new record if the item does not exist
        $insert_query = "INSERT INTO `cart`(`user_id`, `username`, `product_code`, `product_name`, `added_quantity`) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "ssssi", $user_id, $username, $product_code, $product_name, $quantity);
        mysqli_stmt_execute($insert_stmt);
        $_SESSION['cart'] = "success";
        $_SESSION['cart_text'] = "Item added to cart successfully.";
    }

    // mysqli_stmt_close($check_stmt);
    // mysqli_stmt_close($update_stmt);
    // mysqli_stmt_close($insert_stmt);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Check if product code is provided in the POST request
if (isset($_POST['product_code'])) {
    $productCode = $_POST['product_code'];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM cart WHERE product_code = ?");
    $stmt->bind_param("s", $productCode);

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

if (isset($_POST['checkOutBtn'])) {
    // Generate the order code (you can use any method to generate this)
    $order_code = generate_order_code(); // Function to generate order code

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO orders (order_code, quantity, product_name, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $order_code, $quantity, $product_name, $total_price);

    // Set parameters and execute
    $total_items = $_POST["total_items"];
    $quantity = $_POST["quantity"];
    $product_name = $_POST["product_name"];
    $total_price = $_POST["total_price"];
    // Add other necessary fields

    if ($stmt->execute()) {
        header ("Location: check-out.php?Order=".$order_code."&Items=".$total_items."&Price=".$total_price);
    } else {
        $_SESSION['status'] = "Failed!";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

function generate_order_code()
{
    // Generate your order code here (e.g., using timestamp and random numbers)
    return "ORD" . date("YmdHis") . rand(1000, 9999);
}