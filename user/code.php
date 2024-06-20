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
    mysqli_stmt_bind_param($check_stmt, "sss", $user_id, $product_code, $product_name);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Update the quantity if the item exists
        $new_quantity = $row['added_quantity'] + $quantity;
        $update_query = "UPDATE `cart` SET `added_quantity` = ? WHERE `user_id` = ? AND `product_code` = ? AND `product_name` = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "ssss", $new_quantity, $user_id, $product_code, $product_name);
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

if (isset($_POST['BuyNowBtn'])) {
    // Generate a unique order code
    $order_code = "ORD" . date("m-d-Y") . rand(1000, 9999);

    $total_price = $_POST['quantity'] * $_POST['price'];

    $_SESSION['order'] = [
        'product_code' => $_POST['product_code'],
        'product_name' => $_POST['product_name'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
        'order_code' => $order_code,
        'total_price' => $total_price
    ];
    header("Location: check-out.php");
    exit();
}

if (isset($_POST['placeOrderBtn'])) {
    // Assuming you have already sanitized the input data
    $order_code = $_SESSION['order']['order_code'];
    $user_id = $_SESSION['user']['user_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $product_code = $_SESSION['order']['product_code'];
    $product_name = $_SESSION['order']['product_name'];
    $quantity = $_SESSION['order']['quantity'];
    $total_price = $_SESSION['order']['total_price'];
    $delivery_address = $_POST['brgy'] . ', ' . $_POST['municipality'] . ', ' . $_POST['zip'];
    $order_status = 'Pending'; // Assuming the default order status is 'Pending'

    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO `orders` (`order_code`, `user_id`, `name`, `contact`, `product_code`, `product_name`, `quantity`, `total_price`, `delivery_address`, `order_status`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssssidss", $order_code, $user_id, $name, $contact, $product_code, $product_name, $quantity, $total_price, $delivery_address, $order_status);

    // Execute the statement
    if ($stmt->execute()) {

        unset($_SESSION['order']);
        header("Location: order-placed.html");
        // echo "Order placed successfully!";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        // echo "Error: " . $stmt->error;
        header("Location: home.php");
    }
    exit();
    unset($_SESSION['order']);
}

// Initialize the session variable if it doesn't exist
if (!isset($_SESSION['order_items'])) {
    $_SESSION['order_items'] = array();
}

if (isset($_POST['checkOutBtn'])) {
    // Generate order code
    $order_code = "ORD" . date("m-d-Y") . rand(1000, 9999);

    // Store order information in session
    $_SESSION['orders'] = [
        'order_code' => $order_code,
        'price_summary' => $_POST['price_summary'],
        'total_items' => $_POST['total_items']
    ];

    // Store order items in session
    $_SESSION['order_items'] = [];
    foreach ($_POST['product_code'] as $key => $product_code) {
        $product_name = $_POST['product_name'][$key];
        $quantity = $_POST['quantity'][$key];
        $price = $_POST['price'][$key];

        $_SESSION['order_items'][] = [
            'product_code' => $product_code,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'price' => $price
        ];
    }

    // Redirect to the checkout page
    header('Location: check-out.php');
    exit();
}


if (isset($_POST['placeOrder'])) {
    // Assuming you have already sanitized the input data
    $order_code = $_SESSION['orders']['order_code'];
    $user_id = $_SESSION['user']['user_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $delivery_address = $_POST['brgy'] . ', ' . $_POST['municipality'] . ', ' . $_POST['zip'];
    $order_status = 'Pending'; // Assuming the default order status is 'Pending'

    // Prepare the statement for inserting into the orders table
    $stmt = $conn->prepare("INSERT INTO `orders` (`order_code`, `user_id`, `name`, `contact`, `product_code`, `product_name`, `quantity`, `total_price`, `delivery_address`, `order_status`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssidss",
        $order_code,
        $user_id,
        $name,
        $contact,
        $product_code,
        $product_name,
        $quantity,
        $total_price,
        $delivery_address,
        $order_status
    );

    // Prepare the statement for updating the inventory quantity
    $updateStmt = $conn->prepare("UPDATE `inventory` SET `quantity` = `quantity` - ? WHERE `product_code` = ?");
    $updateStmt->bind_param("is", $quantity, $product_code);

    // Insert each order item into the orders table and update the inventory
    foreach ($_SESSION['order_items'] as $item) {
        $product_code = $item['product_code'];
        $product_name = $item['product_name'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total_price = $quantity * $price;

        // Execute the insert statement
        if (!$stmt->execute()) {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Error: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            // echo "Error: " . $stmt->error;
            header("Location: cart.php");
            exit;
        }

        // Execute the update statement
        if (!$updateStmt->execute()) {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Error: " . $updateStmt->error;
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            // echo "Error: " . $updateStmt->error;
            header("Location: cart.php");
            exit;
        }
    }

    // Close the statements
    $stmt->close();
    $updateStmt->close();

    // Remove cart items after placing the order
    $deleteStmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
    $deleteStmt->bind_param("s", $user_id);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Close the database connection
    mysqli_close($conn);

    // Clear the order items from the session
    unset($_SESSION['order_items']);
    unset($_SESSION['orders']);

    // Redirect to a thank you page or order summary page
    header("Location: order-placed.html");
    exit;
}