<?php
include 'authentication.php';
include_once 'includes/header.php';

include "includes/conn.php";

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
            <div class="col-lg-6 col-md-6">
                <!--Checkout Card -->
                <div class="card">
                    <a href="">
                        <h5 class="card-title cart px-3"><i class="bi bi-chevron-left"></i>Check Out</h5>
                    </a>
                    <div class="card-body m-3">
                        <h6 class="card-subtitle mb-2 text-muted">Delivery Address</h6>
                        <input type="text" class="form-control mt-2 mb-4">

                        <div class="d-grid gap-2 col-md-6 mx-auto">
                            <a href="#" class="btn text-white" style="background-color: #0f1b48;">Place
                                Order</a>
                        </div>

                    </div>
                </div><!-- EndCheckout Card -->
            </div>
        </div>
    </section>

</main><!-- End #main -->


<?php
include 'includes/footer.php';
?>