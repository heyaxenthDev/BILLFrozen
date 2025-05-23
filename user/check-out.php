<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
include_once 'includes/header.php';

include "alert.php";
?>

<main id="main" class="main">

    <div class="pagetitle mb-3">
        <h1></h1>
    </div><!-- End Page Title -->

    <section class="p-2">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-12">
                <!-- Checkout Card -->
                <div class="card">
                    <a href="#" onclick="history.back();">
                        <h5 class="card-title cart px-3"><i class="bi bi-chevron-left"></i>Check Out</h5>
                    </a>

                    <form action="code.php" method="POST">
                        <div class="card-body m-2">
                            <h6 class="card-subtitle mb-2 text-muted fw-semibold">Delivery Information</h6>
                            <input type="text" class="form-control mt-3 mb-2" placeholder="Name" name="name"
                                value="<?php echo $_SESSION['user']['name'] ?>" required>
                            <input type="text" class="form-control mt-3 mb-4" placeholder="Mobile No." name="contact"
                                value="<?php echo $_SESSION['user']['email_phone'] ?>" required>

                            <hr class="text-primary">

                            <h6 class="card-subtitle mb-2 mt-3 text-muted fw-semibold">Delivery Address</h6>
                            <input type="text" class="form-control mt-3 mb-3" name="brgy" placeholder="Street/Barangay"
                                required>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control mb-3" name="municipality"
                                        placeholder="Municipality" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="zip"
                                        placeholder="Zip Code (Optional)">
                                </div>
                            </div>

                            <hr class="text-primary">

                            <h6 class="card-subtitle mb-2 mt-3 text-muted fw-semibold">Order Summary</h6>
                            <?php
                            if (isset($_SESSION['orders'])) {
                            ?>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Order Code
                                    <span><?php echo $_SESSION['orders']['order_code'] ?></span>
                                    <!-- Display total items -->
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Items (<?php echo $_SESSION['orders']['total_items'] ?>)
                                    <span>₱<?php echo $_SESSION['orders']['price_summary'] ?></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                        <strong>
                                            <p class="mb-0">(including VAT)</p>
                                        </strong>
                                    </div>
                                    <span><strong>₱<?php echo $_SESSION['orders']['price_summary'] ?></strong></span>
                                    <!-- Display total price -->
                                </li>
                            </ul>

                            <div class="d-grid gap-2 col-md-6 mt-3 mx-auto">
                                <button class="btn text-white" type="submit" name="placeOrder"
                                    style="background-color: #0f1b48;">Place
                                    Order</button>
                            </div>

                            <?php
                            } elseif (isset($_SESSION['order'])) {
                            ?>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Order Code
                                    <span><?php echo $_SESSION['order']['order_code'] ?></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Product Name
                                    <small><?php echo $_SESSION['order']['product_name'] ?></small>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Unit Price
                                    <small>₱<?php echo $_SESSION['order']['price'] ?></small>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Qty.
                                    <small><?php echo $_SESSION['order']['quantity'] ?></small>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                        <strong>
                                            <p class="mb-0">(including VAT)</p>
                                        </strong>
                                    </div>
                                    <span><strong>₱<?php echo (number_format($_SESSION['order']['total_price'], 2)) ?></strong></span>
                                    <!-- Display total price -->
                                </li>
                            </ul>

                            <div class="d-grid gap-2 col-md-6 mt-3 mx-auto">
                                <button class="btn text-white" type="submit" name="placeOrderBtn"
                                    style="background-color: #0f1b48;">Place Order</button>
                            </div>
                            <?php
                            } else {
                                echo "No order details found.";
                            }
                            ?>
                        </div>
                    </form>
                </div><!-- End Checkout Card -->
            </div>
        </div>
    </section>

</main><!-- End #main -->


<?php
include 'includes/footer.php';
?>