<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
include 'includes/header.php';

include "alert.php";

$user_id = $_SESSION['user']['user_id'];

// Fetch cart items count
$count_query = "SELECT COUNT(added_quantity) AS total_items FROM cart WHERE user_id = ?";
$stmt_count = $conn->prepare($count_query);
$stmt_count->bind_param("s", $user_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_items = 0;

if ($result_count && $result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_items = $row_count['total_items'];
}

$stmt_count->close();

// Fetch cart items and calculate total price
$sql = "SELECT c.user_id, c.username, c.product_code, c.product_name, c.added_quantity, i.price, i.category, i.product_picture, i.quantity as inventory_quantity
        FROM cart c
        JOIN inventory i ON c.product_code = i.product_code WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_price = 0;
?>



<main id="main" class="main">

    <div class="pagetitle mb-3">
        <a href="home.php">
            <h1><i class="ri ri-arrow-left-s-line"></i> Continue Shopping</h1>
        </a>
    </div><!-- End Page Title -->

    <section class="">
        <!-- Browser layout form -->
        <form action="code.php" method="POST" class="d-none d-md-block">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="card-title">Shop Cart</h1>

                    <span>You have <?= $total_items ?> items in your Cart</span>
                    <input type="hidden" name="total_items" id="total_items" value="<?= $total_items ?>">
                    <hr>

                    <?php if ($result) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="d-none d-md-block card mb-3">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 col-2">
                                <img src="<?= $src . $row['product_picture'] ?>"
                                    class="img-fluid rounded-start cart-img" alt="...">
                            </div>
                            <div class="col-md-5 col-5">
                                <div class="cart-body">
                                    <h5 class="cart-title"><?= $row['product_name'] ?></h5>
                                    <input type="hidden" name="product_name[]" value="<?= $row['product_name'] ?>">
                                    <input type="hidden" name="product_code[]" value="<?= $row['product_code'] ?>">
                                    <p class="cart-text"><?= $row['category'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="cart-body">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary decrement-btn" type="button">-</button>
                                        <input type="number" class="form-control quantity p-2" name="quantity[]"
                                            value="<?= $row['added_quantity'] ?>" data-price="<?= $row['price'] ?>"
                                            data-inventory="<?= $row['inventory_quantity'] ?>"
                                            max="<?= $row['inventory_quantity'] ?>">
                                        <button class="btn btn-outline-secondary increment-btn" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="cart-body text-center">
                                    <h5 class="cart-price item-total">
                                        ₱ <?= number_format($row['price'] * $row['added_quantity'], 2) ?></h5>
                                    <input type="hidden" class="item-price" name="price[]" value="<?= $row['price'] ?>">
                                </div>
                            </div>
                            <div class="col-md-1 col-1">
                                <div class="cart-body">
                                    <a href="#" class="text-danger cart"
                                        data-product-code="<?= $row['product_code'] ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End cart item -->
                    <?php endwhile; ?>
                    <?php else : ?>
                    <p>No items in cart.</p>
                    <?php endif; ?>
                </div>

                <!-- Summary for Browser Layout -->
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
                                    <span id="product-total">₱</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                        <strong>
                                            <p class="mb-0">(including VAT)</p>
                                        </strong>
                                    </div>
                                    <span><strong id="total-price" class="itemTotal">₱</strong></span>
                                    <input type="hidden" name="price_summary" id="price_summary" value="">
                                </li>
                            </ul>

                            <button type="submit" class="btn btn-lg btn-block text-white" name="checkOutBtn"
                                style="background-color: #0f1b48;">
                                Go to checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
        $(document).ready(function() {
            let updating = false;

            function updateTotal() {
                if (updating) return;
                updating = true;

                let total = 0;
                console.log("updateTotal() triggered");

                $(".quantity:visible").each(function() {
                    let price = parseFloat($(this).data("price")) || 0;
                    let quantity = parseInt($(this).val()) || 0;
                    let inventory = parseInt($(this).data("inventory")) || 0;

                    if (isNaN(quantity) || quantity < 1) {
                        quantity = 1;
                        $(this).val(1);
                    }

                    // Ensure quantity doesn't exceed inventory
                    if (quantity > inventory) {
                        quantity = inventory;
                        $(this).val(inventory);
                        Swal.fire({
                            title: "Warning!",
                            text: "Quantity cannot exceed available inventory.",
                            icon: "warning",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                    let itemTotal = price * quantity;

                    // Update individual item total
                    $(this).closest(".card").find(".item-total").text('₱' + itemTotal.toFixed(2));

                    // Add to total
                    total += itemTotal;
                });

                // Update the total display
                $("#product-total").text('₱' + total.toFixed(2));
                $("#total-price").text('₱' + total.toFixed(2));
                $("#price_summary").val(total.toFixed(2));
                $("#mobile-total-price").text(total.toFixed(2));
                $("#mobile-price-summary").val(total.toFixed(2));

                updating = false;
            }

            // Handle increment button click
            $(document).on('click', '.increment-btn', function() {
                let quantityInput = $(this).closest(".row").find(".quantity");
                let currentValue = parseInt(quantityInput.val()) || 0;
                let inventory = parseInt(quantityInput.data("inventory")) || 0;

                if (currentValue < inventory) {
                    quantityInput.val(currentValue + 1);
                    updateTotal();
                } else {
                    Swal.fire({
                        title: "Warning!",
                        text: "Cannot exceed available inventory.",
                        icon: "warning",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });

            // Handle decrement button click
            $(document).on('click', '.decrement-btn', function() {
                let quantityInput = $(this).closest(".row").find(".quantity");
                let currentValue = parseInt(quantityInput.val()) || 0;
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);
                    updateTotal();
                }
            });

            // Handle manual input changes
            $(document).on('input', '.quantity', function() {
                let value = parseInt($(this).val());
                let inventory = parseInt($(this).data("inventory")) || 0;

                if (isNaN(value) || value < 1) {
                    $(this).val(1);
                } else if (value > inventory) {
                    $(this).val(inventory);
                    Swal.fire({
                        title: "Warning!",
                        text: "Quantity cannot exceed available inventory.",
                        icon: "warning",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }

                updateTotal();
            });

            updateTotal(); // Run once on page load
        });
        </script>



        <!-- Mobile layout form -->
        <form action="code.php" method="POST" class="d-md-none">
            <h1 class="card-title">Shop Cart</h1>

            <span>You have <?= $total_items ?> items in your Cart</span>
            <input type="hidden" name="total_items" value="<?= $total_items ?>">
            <hr>

            <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php mysqli_data_seek($result, 0); // Reset result set pointer ?>
            <?php while ($row = mysqli_fetch_assoc($result)) :
            ?>
            <div class="row">
                <div class="col-md-8 d-md-none d-block">
                    <div class="card mb-3 position-relative">
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
                                    <input type="hidden" name="product_name[]" value="<?= $row['product_name'] ?>">
                                    <input type="hidden" name="product_code[]" value="<?= $row['product_code'] ?>">
                                    <p class="cart-text"><?= $row['category'] ?></p>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="cart-price">₱<?= $row['price'] ?></h5>
                                            <input type="hidden" name="price[]" value="<?= $row['price'] ?>">
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary decrement-btn" type="button"
                                                    data-action="decrement">-</button>
                                                <input type="number" class="form-control quantity" name="quantity[]"
                                                    value="<?= $row['added_quantity'] ?>"
                                                    data-price="<?= $row['price'] ?>"
                                                    data-inventory="<?= $row['inventory_quantity'] ?>"
                                                    max="<?= $row['inventory_quantity'] ?>">
                                                <button class="btn btn-outline-secondary increment-btn" type="button"
                                                    data-action="increment">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End cart item -->
                </div>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p>No items in cart.</p>
            <?php endif; ?>

            <!-- Summary for mobile layout -->
            <nav class="navbar fixed-bottom" style="background-color: #fff394;">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="row w-100">
                        <div class="col-6 d-flex justify-content-center align-items-center">
                            <span><strong><small>Total amount:</small>
                                    ₱<span
                                        id="mobile-total-price"><?= number_format($total_price, 2) ?></span></strong></span>
                            <input type="hidden" name="price_summary" id="mobile-price-summary"
                                value="<?= number_format($total_price, 2) ?>">
                        </div>
                        <div class="col-6 d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-md btn-block text-white" name="checkOutBtn"
                                style="background-color: #0f1b48;">
                                Go to checkout
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </form>

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
                                    icon: "warning",
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
                    xhr.open("POST", "delete_cart_item.php");
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

<!-- Modal -->
<div class="modal fade" id="notificationsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-titles fs-5" id="staticBackdropLabel"><i class="bi bi-bell text-primary"></i>
                    Notifications</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if ($notifs_count != 0) {
                ?>
                <!-- Notification -->
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $desc ?>
                        <span class="badge bg-primary rounded-pill"><?= $stat ?></span>
                    </li>
                </ul><!-- End Notifications -->
                <?php
                } else {
                    echo "No notifications found.";
                }
                ?>

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
        </div>
    </div>
</div>

<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Bill Frozen</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by <a href="#">@heyaxenth</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex d-md-none align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>