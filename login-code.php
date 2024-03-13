<?php
session_start();

include 'includes/conn.php';

// Check if the form is submitted
if (isset($_POST['loginAdmin'])) {
    // Set the default password
    $defaultPassword = "billfrozen_admin";

    // Get the entered password from the form
    $enteredPassword = $_POST["password"];

    // Check if the entered password matches the default password
    if ($enteredPassword == $defaultPassword) {
        // Password is correct, redirect to the dashboard page
        $_SESSION['admin_auth'] = true;
        $_SESSION['logged'] = "Logged in successfully";
        $_SESSION['logged_icon'] = "success";
        header("Location: admin/dashboard.php");
    } else {
        // Password is incorrect, display an error message
        $_SESSION['status'] = "Password Error";
        $_SESSION['status_text'] = "Incorrect password. Please try again.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}

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

    // Insert data into the database
    $sql = "INSERT INTO users (email_or_phone_number, full_name, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $emailOrPhoneNumber, $fullName, $username, $hashedPassword);
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

if (isset($_POST['userLogin'])) {
    
    $usernameOrEmail = $conn->real_escape_string($_POST['yourUsername_email']);
    $password = $conn->real_escape_string($_POST['yourPassword']);

    // Search for user in database
    $sql = "SELECT * FROM users WHERE username = '$usernameOrEmail' OR email_or_phone_number = '$usernameOrEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email_or_phone_number'];

            // Redirect to dashboard or home page
            header("Location: user/dashboard.php");
            exit;
        } else {
            // Password is incorrect
            $_SESSION['status'] = "Login Error";
            $_SESSION['status_text'] = "Incorrect username/email or password. Please try again.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    } else {
        // User not found
        $_SESSION['status'] = "Login Error";
        $_SESSION['status_text'] = "User not found. Please try again.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Close the database connection
    $conn->close();
}

?>