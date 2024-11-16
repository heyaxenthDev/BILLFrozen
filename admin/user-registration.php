<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in

include "includes/conn.php";
include_once 'includes/header.php';
include 'includes/sidebar.php';
include "alert.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Registration</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                <li class="breadcrumb-item active">User Registration</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row justify-content-center">

            <!-- Left side columns -->
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add a new User Account here:</h5>

                        <form class="row g-3" action="login-code.php" method="POST">

                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control transparent-input"
                                        id="yourEmailOrPhoneNumber" name="yourEmailOrPhoneNumber" placeholder=" "
                                        required>
                                    <label for="yourEmailOrPhoneNumber" class="fw-semibold">Email or Phone
                                        Number</label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control transparent-input" id="yourFullName"
                                        name="yourFullName" placeholder=" " required>
                                    <label for="yourFullName" class="fw-semibold">Full Name</label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control transparent-input" id="yourUsername"
                                        name="yourUsername" placeholder=" " required>
                                    <label for="yourUsername" class="fw-semibold">Username</label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control transparent-input" id="yourPassword"
                                        name="yourPassword" placeholder=" " required>
                                    <label for="yourPassword" class="fw-semibold">Password</label>
                                    <span hidden="hidden" class="field-icon toggle-password bi bi-eye-fill" id="icon"
                                        style="position: absolute; right: 17px; transform: translate(0, -50%); top: 50%; cursor: pointer;"></span>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control transparent-input" id="confirmPassword"
                                        name="confirmPassword" placeholder=" " required>
                                    <label for="confirmPassword" class="fw-semibold">Confirm Password</label>
                                    <span hidden="hidden" class="field-icon toggle-confirm bi bi-eye-fill" id="icon-c"
                                        style="position: absolute; right: 17px; transform: translate(0, -50%); top: 50%; cursor: pointer;"></span>
                                </div>
                            </div>


                            <div class="col-12 mb-3 mt-5">
                                <button class="btn w-100 text-white" type="submit" style="background-color: #0F1B48;"
                                    name="userSignUp">Sign
                                    Up</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>

    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>