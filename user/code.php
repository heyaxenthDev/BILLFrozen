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
        mysqli_stmt_bind_param($update_stmt, "iiss", $new_quantity, $user_id, $product_code, $product_name);
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
