<?php
session_start();
include 'includes/conn.php';

// Check if user has valid reset session
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_code'])) {
    header("Location: forgot-password.php");
    exit();
}

$email = $_SESSION['reset_email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Reset Password - Bill Frozen</title>
    <meta content name="description">
    <meta content name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style-login.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <main>
        <div class="container">
            <?php include 'alert.php'; ?>
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-3 p-4">
                                <div class="d-flex justify-content-end">
                                    <a href="index.php" class="logo d-flex align-items-center w-auto">
                                        <img src="assets/img/Bill-Frozen-Logo.png" alt>
                                    </a>
                                </div>

                                <div class="pt-4 pb-2">
                                    <h1 class="card-title pb-0 fw-bold" id="welcome">Reset<br>Password</h1>
                                    <p class="small fw-semibold" id="welcome-span">Please enter your new password below.
                                    </p>
                                </div>

                                <form class="row g-3" action="reset-password.php" method="POST" id="resetPasswordForm">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control transparent-input"
                                                id="newPassword" name="newPassword" placeholder=" " required
                                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                            <label for="newPassword" class="fw-semibold">New Password</label>
                                            <small id="password-status" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control transparent-input"
                                                id="confirmPassword" name="confirmPassword" placeholder=" " required>
                                            <label for="confirmPassword" class="fw-semibold">Confirm Password</label>
                                            <small id="confirm-status" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3 mt-5">
                                        <button class="btn w-100 text-white" type="submit"
                                            style="background-color: #0F1B48;" name="resetPassword">Reset
                                            Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script>
    $(document).ready(function() {
        // Password validation
        $("#newPassword").on('input', function() {
            var password = $(this).val();
            var status = $("#password-status");

            if (password.length < 8) {
                status.html("Password must be at least 8 characters long");
            } else if (!password.match(/[A-Z]/)) {
                status.html("Password must contain at least one uppercase letter");
            } else if (!password.match(/[a-z]/)) {
                status.html("Password must contain at least one lowercase letter");
            } else if (!password.match(/[0-9]/)) {
                status.html("Password must contain at least one number");
            } else {
                status.html("");
            }
        });

        // Confirm password validation
        $("#confirmPassword").on('input', function() {
            var password = $("#newPassword").val();
            var confirm = $(this).val();
            var status = $("#confirm-status");

            if (password !== confirm) {
                status.html("Passwords do not match");
            } else {
                status.html("");
            }
        });

        // Form submission validation
        $("#resetPasswordForm").on('submit', function(e) {
            var password = $("#newPassword").val();
            var confirm = $("#confirmPassword").val();

            if (password !== confirm) {
                e.preventDefault();
                $("#confirm-status").html("Passwords do not match");
            }
        });
    });
    </script>
</body>

</html>