<?php
session_start();

include('includes/conn.php');

// Check if user is authenticated as a regular user
if (isset($_SESSION['user_auth']) || $_SESSION['user_auth'] == true) {
    $username = $_SESSION['user']['username'];
    // Set session variables for status message
    $_SESSION['status'] = "Logged Out Successfully!";
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";

    // Unset session variables
    session_destroy();
    
    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}

// Check if user is authenticated as an admin
if (isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] == true) {
    // Set session variables for status message
    $_SESSION['status'] = "Logged Out Successfully!";
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";

    // Unset session variables
    session_destroy();
    
    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}

// Check if user is authenticated as an admin
if (isset($_SESSION['sub_admin_auth']) || $_SESSION['sub_admin_auth'] == true) {
    // Set session variables for status message
    $_SESSION['status'] = "Logged Out Successfully!";
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";

    // Unset session variables
    session_destroy();
    
    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}

?>