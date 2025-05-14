<?php
session_start();
include 'includes/conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Log in - Bill Frozen</title>
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
                                    <h1 class="card-title pb-0 fw-bold" id="welcome">Hi!<br>
                                        Welcome</h1>
                                    <p class="small fw-semibold" id="welcome-span">We are happy to know
                                        what is
                                        yout
                                        order</p>
                                </div>
                                <form class="row g-3" action="login-code.php" method="POST">

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control transparent-input"
                                                id="yourUsername_email" name="yourUsername_email" placeholder=" "
                                                required>
                                            <label for="yourUsername_email" class="fw-semibold">Username or
                                                Email</label>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="password" class="form-control transparent-input"
                                                id="yourPassword" name="yourPassword" placeholder=" " required>
                                            <label for="yourPassword" class="fw-semibold">Password</label>
                                            <span hidden="hidden" class="field-icon toggle-password bi bi-eye-fill"
                                                id="icon"
                                                style="position: absolute; right: 17px; transform: translate(0, -50%); top: 50%; cursor: pointer;"></span>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex align-items-center">
                                        <div class="form-check me-auto">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true"
                                                id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="forgot-password">
                                            <a href="forgot-password.php">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3 mt-5">
                                        <button class="btn w-100 text-white" type="submit"
                                            style="background-color: #0F1B48;" name="userLogin">Login</button>
                                    </div>
                                    <!-- <div class="col-12 mb-5">
                                        <p class="small mb-0 text-center">Don't have an account? <a href="user-register.php">Create
                                                an account</a></p>
                                    </div> -->
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

    <!-- Template Main JS File -->
    <script src="js/password.js"></script>

</body>

</html>