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
?>