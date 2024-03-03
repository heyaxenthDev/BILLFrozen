<?php
session_start();

include('admin/includes/conn.php');

// Check if user is authenticated as a regular user
if (isset($_SESSION['authenticated'])) {
    $username = $_SESSION['auth_user']['username'];
    // Set session variables for status message
    $_SESSION['status'] = "Logged Out Successfully!";
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";

    // Unset session variables
    unset($_SESSION['authenticated']);
    unset($_SESSION['auth_user']);
    
    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}

// Check if user is authenticated as an admin
if (isset($_SESSION['admin_auth'])) {
    // Set session variables for status message
    $_SESSION['status'] = "Logged Out Successfully!";
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";

    // Unset session variables
    unset($_SESSION['admin_auth']);
    
    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}

?>