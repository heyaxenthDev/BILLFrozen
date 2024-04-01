<?php
include 'authentication.php';
include_once 'includes/header.php';

include "alert.php";

?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="home.php">
                <i class="bi bi-house"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="cart.php">
                <i class="bi bi-cart3"></i>
                <span>Cart</span>
            </a>
        </li><!-- End Cart Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li><!-- End Inventory Page Nav -->

        <li class="nav-item">
            <a class="nav-link " href="my-order.php">
                <i class="bi bi-bag-check"></i>
                <span>My Orders</span>
            </a>
        </li><!-- End Orders Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle mb-3">
        <h1></h1>
    </div><!-- End Page Title -->

    <section class="p-2">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-12">
                <!-- Checkout Card -->
                <div class="card">
                    <a href="">
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
                            if (isset($_SESSION['order_items'])) {
                            ?>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Items (<?php echo $_GET['Items'] ?>)
                                    <span>₱<?php echo $_GET['Price'] ?></span> <!-- Display total items -->
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Order Code
                                    <span><?php echo $_GET['Order'] ?></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                        <strong>
                                            <p class="mb-0">(including VAT)</p>
                                        </strong>
                                    </div>
                                    <span><strong>₱<?php echo $_GET['Price'] ?></strong></span>
                                    <!-- Display total price -->
                                </li>
                            </ul>

                            <div class="d-grid gap-2 col-md-6 mt-3 mx-auto">
                                <button class="btn text-white" type="submit" name="placeOrder"
                                    style="background-color: #0f1b48;">Place
                                    Order</button>
                            </div>

                            <?php
                            } else {
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
                                    style="background-color: #0f1b48;">Place
                                    Order</button>
                            </div>
                            <?php
                            } ?>

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