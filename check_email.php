<?php
include "includes/conn.php";

if(isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE email_or_phone_number = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        echo "<span class='text-success'>✔ Email is associated with an account.</span>";
    } else {
        echo "<span class='text-danger'>✖ No account found with this email.</span>";
    }

    $stmt->close();
    $conn->close();
}
?>