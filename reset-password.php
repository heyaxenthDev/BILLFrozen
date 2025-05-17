<?php
session_start();
include "includes/conn.php";
include "./admin/includes/phpmailer_cred.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendPasswordResetEmail($email, $code, $bf_email, $bf_password) {
    // Setup PHPMailer
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $bf_email;
    $mail->Password = $bf_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($bf_email, 'BillFrozen Website');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = "
    <html>
        <head>
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                    border-radius: 5px;
                }
                .header {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                }
                .otp {
                    font-size: 22px;
                    font-weight: bold;
                    color: #0F1B48;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <p class='header'>Hello</p>
                <p>We received a request to reset your password. Please use the following One-Time Password (OTP) to complete your email verification process:</p>
                <p class='otp'>$code</p>
                <p>If you did not request a password reset, please ignore this email or contact support immediately.</p>
                <p class='footer'>Best regards,<br><strong>BillFrozen</strong></p>
            </div>
        </body>
    </html>
    ";

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function resetPasswordSuccess($email, $bf_email, $bf_password) {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $bf_email;
    $mail->Password = $bf_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($bf_email, 'BillFrozen Website');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Successful';
    $mail->Body = "
    <html>
        <head>
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                    border-radius: 5px;
                }
                .header {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                }
                .message {
                    font-size: 16px;
                    color: #555;
                }
                .success {
                    font-size: 22px;
                    font-weight: bold;
                    color: #0F1B48;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <p class='header'>Hello</p>
                <p class='message'>Your password has been successfully reset. You can now log in to your account using your new password.</p>
                <p class='success'>If you did not request this change, please contact our support team immediately.</p>
                <p class='message'>For any questions or further assistance, feel free to reach out to our support team.</p>
                <p class='footer'>Best regards,<br><strong>BillFrozen</strong></p>
            </div>
        </body>
    </html>
    ";

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle initial password reset request
if (isset($_POST['passwordReset']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['resetEmail']);

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email_or_phone_number = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate the reset code
        $row = $result->fetch_assoc();
        $userId = $row['user_id'];
        $code = mt_rand(100000, 999999);

        // Insert the reset code into the database
        $sql = "UPDATE users SET password_token = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $code, $userId);
        
        if ($stmt->execute() && sendPasswordResetEmail($email, $code, $bf_email, $bf_password)) {
            // Return JSON response for AJAX request
            echo json_encode([
                'status' => 'success',
                'message' => 'Reset code has been sent to your email.'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send reset code. Please try again.'
            ]);
            exit();
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email not found in our records.'
        ]);
        exit();
    }
}

// Handle reset code verification
if (isset($_POST['verifyResetCode']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['resetEmail']);
    $code = $conn->real_escape_string($_POST['resetCode']);

    // Verify the code
    $sql = "SELECT * FROM users WHERE email_or_phone_number = ? AND password_token = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Code is valid, redirect to password reset page
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code'] = $code;
        header("Location: new-password.php");
        exit();
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Invalid reset code. Please try again.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Try Again";
        header("Location: forgot-password.php");
        exit();
    }
}

// Handle new password submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resetPassword'])) {
    $newPassword = $conn->real_escape_string($_POST['newPassword']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);
    $email = $conn->real_escape_string($_POST['email']);

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password and clear reset token
        $stmt = $conn->prepare("UPDATE users SET password = ?, password_token = NULL WHERE email_or_phone_number = ? LIMIT 1");
        $stmt->bind_param("ss", $hashedPassword, $email);
        
        if ($stmt->execute()) {
            // Send success email
            resetPasswordSuccess($email, $bf_email, $bf_password);
            
            $_SESSION['status'] = "Success!";
            $_SESSION['status_text'] = "Your password has been successfully reset.";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_btn'] = "Done";
            header("Location: index.php");
            exit();
        }
    }
    
    // If we get here, something went wrong
    $_SESSION['status'] = "Error!";
    $_SESSION['status_text'] = "Failed to reset the password.";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_btn'] = "Try Again";
    header("Location: new-password.php");
    exit();
}
?>