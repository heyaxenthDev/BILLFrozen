<?php
session_start();
include 'includes/conn.php';


// Check if form is submitted
if (isset($_POST['addNewProduct'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

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
            $stmt = $conn->prepare("INSERT INTO product_list (product_name, category, price, product_picture) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $product_name, $category, $price, $product_picture);

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
    
// Determine the product status
    $productStatus = '';
    if (strtotime($expiryDate) < strtotime('now')) {
        $productStatus = 'Expired';
    } elseif (strtotime($expiryDate) < strtotime('+1 month')) {
        $productStatus = 'Expiring Soon';
    } else {
        $productStatus = 'Good';
    }

    $query = "INSERT INTO `inventory`(`product_code`, `product_name`, `price`, `category`, `quantity`, `product_status`, `expiry_date`, `product_picture`, `date_created`) VALUES ('$productCode', '$productName', '$price', '$category', '$quantity', '$productStatus', '$expiryDate', '$productPicture', NOW())";

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


// Close connection
$conn->close();
?>