<?php 
session_start();

include 'includes/conn.php';

if (isset($_POST["userSignUp"])) {

    // Sanitize inputs
    $emailOrPhoneNumber = mysqli_real_escape_string($conn, $_POST['yourEmailOrPhoneNumber']);
    $fullName = mysqli_real_escape_string($conn, $_POST['yourFullName']);
    $username = mysqli_real_escape_string($conn, $_POST['yourUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['yourPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        // Handle password mismatch error
        $_SESSION['status'] = "Password Error";
        $_SESSION['status_text'] = "Passwords do not match. Please try again.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a unique user id
    $userId = "BFU" . mt_rand(100000, 999999); // BFU + random 6-digit number

    // Insert data into the database
    $sql = "INSERT INTO users (user_id, email_or_phone_number, full_name, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $userId, $emailOrPhoneNumber, $fullName, $username, $hashedPassword);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // User registered successfully
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "User registered successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        // Error registering user
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error registering new user.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Close the database connection
    $conn->close();
}
?>