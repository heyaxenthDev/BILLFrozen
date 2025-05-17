<?php
session_start();
include 'includes/conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Forgot Password - Bill Frozen</title>
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
            <?php
            include 'alert.php';
            ?>
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
                                </div><!-- End Logo -->

                                <div class="pt-4 pb-2">
                                    <h1 class="card-title pb-0 fw-bold" id="welcome">Forgot<br>
                                        Password?</h1>
                                    <p class="small fw-semibold" id="welcome-span">Please enter your <i>registered
                                            email</i>
                                        for a reset code.</p>
                                </div>
                                <form class="row g-3" id="myForm" action="reset-password.php" method="POST">
                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <input type="email" class="form-control transparent-input" id="resetEmail"
                                                name="resetEmail" placeholder=" " required>
                                            <label for="resetEmail" class="fw-semibold">Email</label>
                                            <small id="email-status" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3 mt-5">
                                        <button class="btn w-100 text-white" type="submit"
                                            style="background-color: #0F1B48;" name="passwordReset">Send Reset
                                            Code</button>
                                    </div>
                                </form>


                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="resetCodeModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="resetCodeModalLabel">Reset Code</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Please enter the reset code sent to your email.</p>
                                <form id="resetCodeForm" action="reset-password.php" method="POST">
                                    <input type="hidden" name="resetEmail" id="modalResetEmail">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="resetCode" name="resetCode"
                                                placeholder=" " required>
                                            <label for="resetCode">Reset Code</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3 mt-5">
                                        <button class="btn w-100 text-white" type="submit"
                                            style="background-color: #0F1B48;" name="verifyResetCode">Verify
                                            Code</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="js/reset-password.js"></script>

</body>

</html>