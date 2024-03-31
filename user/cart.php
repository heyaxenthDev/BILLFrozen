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
            <a class="nav-link " href="cart.php">
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
            <a class="nav-link collapsed" href="my-order.php">
                <i class="bi bi-bag-check"></i>
                <span>My Orders</span>
            </a>
        </li><!-- End Orders Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle mb-3">
        <a href="home.php">
            <h1><i class="ri ri-arrow-left-s-line"></i> Continue Shopping</h1>
        </a>
    </div><!-- End Page Title -->

    <section class="">
        <div class="row">
            <div class="col-md-8">
                <h1 class="card-title">Shop Cart</h1>

                <?php
                // Fetch cart items
                $user_id = $_SESSION['user']['user_id'];

                $count = "SELECT COUNT(added_quantity) AS total_items FROM cart WHERE `user_id` = '$user_id'";

                $result = mysqli_query($conn, $count);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $total_items = $row['total_items'];
                ?>
                <span class="">You have <?= $total_items ?> items in your Cart</span>
                <hr>
                <?php
                } else {
                    echo "No items in cart.";
                }
                ?>

                <?php
                // Fetch cart items
                $sql = "SELECT c.user_id, c.username, c.product_code, c.product_name, c.added_quantity, c.date_created, i.price, i.category, i.product_picture
                FROM cart c
                JOIN inventory i ON c.product_code = i.product_code";

                $result = mysqli_query($conn, $sql);
                $total_price = 0; // Initialize total price variable

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $product_price = $row['price'] * $row['added_quantity'];
                        $total_price += $product_price; // Add to total price
                ?>
                <form action="code.php" method="POST">
                    <!-- Below is for the Browser layout -->
                    <div class="d-none d-md-block card mb-3">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 col-2">
                                <img src="<?= $src . $row['product_picture'] ?>"
                                    class="img-fluid rounded-start cart-img" alt="...">
                            </div>
                            <div class="col-md-5 col-5">
                                <div class="cart-body">
                                    <h5 class="cart-title"><?= $row['product_name'] ?></h5>
                                    <p class="cart-text"><?= $row['category'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="cart-body">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary decrement-btn">-</button>
                                        <input type="number" class="form-control quantity" name="quantity"
                                            value="<?= $row['added_quantity'] ?>">
                                        <button class="btn btn-outline-secondary increment-btn">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="cart-body text-center">
                                    <!-- <p class="cart-text">per Qty.</p> -->
                                    <h5 class="cart-price">₱<?= $row['price'] ?></h5>
                                </div>
                            </div>
                            <div class="col-md-1 col-1">
                                <div class="cart-body">
                                    <a href="#" class="text-danger cart"
                                        data-product-code="<?= $row['product_code'] ?>"><i
                                            class="bi bi-trash-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End cart item -->

                    <!-- Below is for the mobile layout -->
                    <div class="d-md-none card mb-3 position-relative">
                        <a href="#" class="text-danger cart position-absolute top-0 end-0 p-3"
                            data-product-code="<?= $row['product_code'] ?>"><i class="bi bi-trash-fill"></i></a>
                        <div class="row g-0 align-items-center">
                            <div class="col-3">
                                <img src="<?= $src . $row['product_picture'] ?>"
                                    class="img-fluid rounded-start cart-img" alt="...">
                            </div>
                            <div class="col-9">
                                <div class="cart-body">
                                    <h5 class="cart-title"><?= $row['product_name'] ?></h5>
                                    <p class="cart-text"><?= $row['category'] ?></p>
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- <p class="cart-text">per Qty.</p> -->
                                            <h5 class="cart-price">₱<?= $row['price'] ?></h5>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary decrement-btn">-</button>
                                                <input type="number" class="form-control quantity" name="quantity"
                                                    value="<?= $row['added_quantity'] ?>">
                                                <button class="btn btn-outline-secondary increment-btn">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End cart item -->
                    <?php
                    }
                } else {
                    echo "No items in cart.";
                }
                    ?>


            </div>


            <div class="summary col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Products
                                <span>₱<?= number_format($total_price, 2) ?></span> <!-- Display total price -->
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Shipping
                                <span>Gratis</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total amount</strong>
                                    <strong>
                                        <p class="mb-0">(including VAT)</p>
                                    </strong>
                                </div>
                                <span><strong>₱<?= number_format($total_price, 2) ?></strong></span>
                                <!-- Display total price -->
                            </li>
                        </ul>

                        <button type="Submit" class="btn btn-lg btn-block text-white" name="checkOutBtn"
                            style="background-color: #0f1b48;">
                            Go to checkout
                        </button>
                    </div>
                </div>
            </div>

            </form>

        </div>
    </section>

    <script>
    document.querySelectorAll(".cart").forEach((item) => {
        item.addEventListener("click", function(e) {
            e.preventDefault();
            const productCode = this.getAttribute("data-product-code");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success",
                                    showConfirmButton: false, // Prevents the user from closing the alert manually
                                    timer: 1500 // Show the alert for 1.5 seconds
                                }).then(() => {
                                    // Reload page after the alert is closed
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete item.",
                                    icon: "error"
                                });
                            }


                        }
                    };
                    xhr.open("POST", "code.php");
                    xhr.setRequestHeader(
                        "Content-Type",
                        "application/x-www-form-urlencoded"
                    );
                    xhr.send(`product_code=${productCode}`);
                }
            });
        });
    });
    </script>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>