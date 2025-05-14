<?php
session_start();
include 'includes/conn.php';


// Check if form is submitted
if (isset($_POST['addNewProduct'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $desc = mysqli_real_escape_string($conn, $_POST['ProductDesc']);

    // Validate image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["productImage"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        unlink($target_file); // Delete the existing file
    }

    // Check file size
    if ($_FILES["productImage"]["size"] > 500000) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Sorry, your file is too large.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Sorry, your file was not uploaded.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["productImage"]["name"]). " has been uploaded.";

            // Prepare and bind SQL statement
            $product_picture = $target_file;
            $stmt = $conn->prepare("INSERT INTO product_list (product_name, description, category, price, product_picture) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssds", $product_name, $desc, $category, $price, $product_picture);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                $_SESSION['status'] = "Success";
                $_SESSION['status_text'] = "New Product added!";
                $_SESSION['status_code'] = "success";
                $_SESSION['status_btn'] = "Done";
                header("Location: {$_SERVER['HTTP_REFERER']}");
            } else {
                $_SESSION['status'] = "Error";
                $_SESSION['status_text'] = $stmt->error;
                $_SESSION['status_code'] = "error";
                $_SESSION['status_btn'] = "Back";
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }

            // Close statement
            $stmt->close();
        } else {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Sorry, there was an error uploading your file.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
}

if (isset($_POST['addInventoryProduct'])) {
    // Generate a random 6-digit number
    $productCode = 'PROD' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $id = mysqli_real_escape_string($conn, $_POST['product_name']);

    // Fetch category and product_picture for the selected product
    $query = "SELECT * FROM `product_list` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $productName = $row['product_name'];
    $category = $row['category'];
    $productPicture = $row['product_picture'];
    $price = $row['price'];

    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiryDate = mysqli_real_escape_string($conn, $_POST['expiry-date']);


    $query = "INSERT INTO `inventory`(`product_code`, `product_name`, `price`, `category`, `quantity`, `expiry_date`, `product_picture`) VALUES ('$productCode', '$productName', '$price', '$category', '$quantity', '$expiryDate', '$productPicture')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Product added successfully";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = $query . "<br>" . mysqli_error($conn);
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}


if (isset($_POST['confirmBtn'])) {
    $orderCode = $_POST['orderCode'];
    $deliveryDate = $_POST['deliveryDate'];

    // Update the delivery date and order status in the database
    $updateQuery = "UPDATE orders SET delivery_date = '$deliveryDate', order_status = 'For Delivery' WHERE order_code = '$orderCode'";
    if (mysqli_query($conn, $updateQuery)) {
        // Fetch user_id and username from the orders table
        $fetchOrderInfoQuery = "SELECT user_id, name FROM orders WHERE order_code = '$orderCode'";
        $result = mysqli_query($conn, $fetchOrderInfoQuery);
        $row = mysqli_fetch_assoc($result);
        $userId = $row['user_id'];
        $username = $row['name'];

        // Insert notification into the notifications table
        $description = "Your order with order code $orderCode has been confirmed and is now scheduled for delivery on $deliveryDate.";
        $status = 'unread';
        $order_status = "Order Confirmed";

        $insertNotificationQuery = "INSERT INTO `notifications`(`user_id`, `username`, `description`, `order_status`, `status`) VALUES ('$userId','$username','$description', '$order_status', '$status')";
        mysqli_query($conn, $insertNotificationQuery);

        $_SESSION['alert'] = "success";
        $_SESSION['alert_text'] = "Order successfully confirmed.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['alert'] = "error";
        $_SESSION['alert_text'] = "Error updating order: " . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}


if (isset($_POST['decline_order_code']) && isset($_POST['decline_reason'])) {
    $orderCode = $_POST['decline_order_code'];
    $reason = trim($_POST['decline_reason']);

    // Update order status for declining
    $updateQuery = "UPDATE orders SET delivery_date = null, order_status = 'Order Declined' WHERE order_code = '$orderCode'";
    if (mysqli_query($conn, $updateQuery)) {
        // Fetch user_id and username from the orders table
        $fetchOrderInfoQuery = "SELECT user_id, name FROM orders WHERE order_code = '$orderCode'";
        $result = mysqli_query($conn, $fetchOrderInfoQuery);
        $row = mysqli_fetch_assoc($result);
        $userId = $row['user_id'];
        $username = $row['name'];

        // Insert notification into the notifications table with the custom reason
        $description = "Your order with order code $orderCode has been declined. Reason: $reason";
        $status = "unread";
        $order_status = "Order Declined";

        $insertNotificationQuery = "INSERT INTO `notifications`(`user_id`, `username`, `description`, `order_status`, `status`) VALUES ('$userId','$username','$description', '$order_status', '$status')";
        mysqli_query($conn, $insertNotificationQuery);

        $_SESSION['alert'] = "warning";
        $_SESSION['alert_text'] = "Order has been declined.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['alert'] = "error";
        $_SESSION['alert_text'] = "Error updating order: " . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}


if(isset($_GET['order']) == 'Delivered'){
    
    $status = $_GET['order'];
    $orderCode = $_GET['OrderCode'];
    
    $updateQuery = "UPDATE orders SET order_status = '$status' WHERE order_code = '$orderCode'";
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['alert'] = "success";
        $_SESSION['alert_text'] = "Order has been Delivered";
        // echo "Order updated successfully.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['alert'] = "error";
        $_SESSION['alert_text'] = "Error updating order: " . mysqli_error($conn);
        // echo "Error updating order: " . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}

if (isset($_POST['editProduct']) && isset($_POST['editProductId'])) {
   // Get the form data
    $productId = $_POST['editProductId'];
    $productName = $_POST['editProductName'];
    $productPrice = $_POST['editProductPrice'];
    $productCategory = $_POST['editProductCategory'];
    $productDesc = $_POST['editProductDesc'];

    // Prepare the SQL query
    $query = "UPDATE `product_list` SET `product_name`=?, `description`=?, `price`=?, `category`=? WHERE `id`=?";
    
    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'ssdsi', $productName, $productDesc, $productPrice, $productCategory, $productId);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Product updated successfully";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error updating product: " . mysqli_error($conn);
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If the form was not submitted, redirect back
    header("Location: {$_SERVER['HTTP_REFERER']}");
}

if (isset($_POST['editInventory'])) {
    // Get the form data
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $expiry_date = $_POST['expiry_date'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE `inventory` SET `product_name`=?, `price`=?, `quantity`=?, `expiry_date`=? WHERE `id`=?");
    $stmt->bind_param("sdiss", $product_name, $price, $quantity, $expiry_date, $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Inventory item updated successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");

    } else {
        // Handle the error
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");

    }

    // Close the statement
    $stmt->close();
}


if (isset($_POST['saveChangeBtn'])) { // Check correct form name

    $orderCode = trim($_POST['orderCode']); // Trim input to remove spaces
    $newDate = trim($_POST['deliveryDate']);
    $user_id = trim($_POST['userID']);
    $name = $_POST['customerName'];

    if (!empty($orderCode) && !empty($newDate)) { // Validate inputs
        $stmt = $conn->prepare('UPDATE orders SET delivery_date = ? WHERE order_code = ?');
        $stmt->bind_param('ss', $newDate, $orderCode);

        if ($stmt->execute()) {
            // Insert notification into the notifications table
            $description = "Your order with order code $orderCode has been rescheduled for delivery on $newDate.";
            $status = 'unread';
            $order_status = "Order Rescheduled";

            $insertNotificationQuery = "INSERT INTO `notifications`(`user_id`, `username`, `description`, `order_status`, `status`) VALUES ('$user_id','$name','$description', '$order_status', '$status')";
            mysqli_query($conn, $insertNotificationQuery);
            
            $_SESSION['status'] = "Success";
            $_SESSION['status_text'] = "Delivery Date updated successfully.";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_btn'] = "Back";
        } else {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Error: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
        }

        $stmt->close(); // Close the statement
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Invalid input. Please try again.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
    exit; // Stop further execution
}

// Close the database connection
$conn->close();
?>