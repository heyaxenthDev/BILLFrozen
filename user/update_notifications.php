<?php
include "includes/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userID = $_POST['user_id'];
    $update_query = "UPDATE notifications SET status = 'read' WHERE user_id = '$userID' AND status = 'unread'";
    if (mysqli_query($conn, $update_query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>