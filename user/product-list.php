<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
include_once 'includes/header.php';

include "alert.php";

?>

<main id="main" class="main">

    <section class="p-2">
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="pagetitle mb-3">
                    <div class="row">

                        <div class="col-md-6 mb-3 ">
                            <a href="home.php">
                                <h1><i class="ri ri-arrow-left-s-line"></i>
                                    Product List</h1>
                            </a>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="gap-2 d-md-flex justify-content-md-end">
                                <div class="search-bar">
                                    <form class="search-form d-flex align-items-center" id="productSearchForm"
                                        method="POST">
                                        <input type="text" name="query" id="productSearchInput" placeholder="Search"
                                            title="Enter search keyword" autocomplete="off">
                                        <!-- <button type="submit" title="Search"><i class="bi bi-search"></i></button> -->
                                    </form>
                                </div><!-- End Search Bar -->
                            </div>
                        </div>

                    </div>
                </div><!-- End Page Title -->

                <hr>

                <!-- Additional content for the product list -->
                <div class="row position-relative" id="productListContainer">
                    <div id="productListLoading"
                        style="display:none;position:absolute;left:50%;top:30%;transform:translate(-50%, -50%);z-index:10;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <?php
                    // Perform database query to fetch product information
                    $search = '';
                    if (isset($_POST['query']) && !empty(trim($_POST['query']))) {
                        $search = trim($_POST['query']);
                        $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
                                FROM product_list pl
                                JOIN inventory inv ON pl.product_name = inv.product_name
                                WHERE inv.quantity > 0 AND (pl.product_name LIKE ? OR pl.category LIKE ? )";
                        $stmt = $conn->prepare($sql);
                        $like = "%$search%";
                        $stmt->bind_param("ss", $like, $like);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
                                FROM product_list pl
                                JOIN inventory inv ON pl.product_name = inv.product_name 
                                WHERE inv.quantity > 0";
                        $result = $conn->query($sql);
                    }

                    // Check if query was successful
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-2 col-6">
                        <!-- Card with an image on top -->
                        <a href="#" class="product-link" data-product-id="<?= $row['product_code']; ?>">
                            <div class="card h-100">
                                <img src="<?= rtrim($src, '/') . '/' . $row['product_picture']; ?>" class="card-img-top"
                                    alt="<?= $row['product_name']; ?>">
                                <div class="card-body">
                                    <h6 class="fw-bold"><?= $row['product_name']; ?></h6>
                                    <p class="card-text">Price: ₱<?= $row['price']; ?></p>
                                    <?php if ($row['quantity'] == 0) : ?>
                                    <p class="card-text"><span class="badge bg-danger">Sold Out</span></p>
                                    <?php else : ?>
                                    <p class="card-text">Qty: <?= $row['quantity']; ?>
                                        <span class="badge bg-success">Available</span>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        }
                    } else {
                        echo "No products found.";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </div><!-- row end -->

            </div>
        </div>

    </section>

    <!-- Modal -->
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-disabled="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="d-grid d-md-flex justify-content-md-end px-3 py-3">
                    <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class=" modal-body m-4 pb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <img id="modalImage" src="" class="rounded mx-auto d-block img-thumbnail"
                                    alt="Product Image">
                            </div>

                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-9">
                                        <h1 class="modal-title" id="modalProductName">Product Name</h1>
                                        <input type="hidden" name="product_name" id="modalProductNameInput" value="">
                                        <input type="hidden" name="product_code" id="modalProductCode" value="">
                                    </div>
                                    <div class="col-3">
                                        <h2 class="modal-title"><span class="badge text-bg-primary"
                                                id="modalPrice">Price</span>
                                            <input type="hidden" name="price" id="modalPriceRaw" value="">
                                        </h2>
                                    </div>
                                </div>

                                <small id="modalDesc"></small><br>
                                <small id="modalCategory"></small><br>
                                <small id="modalAvailableQty"></small><br>
                                <small id="modalExpiryDate"> <span id="modalExpiryBadge" class="badge "></span></small>

                                <div class="row">
                                    <div class="col-7 modal-title">
                                        <span class="mx-3">Quantity</span><br>
                                    </div>
                                    <div class="col-5 modal-title px-3">
                                        <div class="input-group">
                                            <button class="btn btn-outline-warning decrement-btn"
                                                type="button">-</button>
                                            <input type="number" class="form-control quantity" name="quantity"
                                                value="1">
                                            <button class="btn btn-outline-warning increment-btn"
                                                type="button">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-3">
                                    <button class="btn w-100 text-white" type="submit" name="BuyNowBtn"
                                        style="background-color: #0f1b48;">Buy
                                        Now</button>
                                    <button class="btn w-100 text-white" type="submit" name="AddtoCartBtn"
                                        style="background-color: #029bf1;">Add
                                        to
                                        Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end w-100" data-bs-scroll="true" data-bs-backdrop="static" tabindex="-1"
        id="offcanvasProduct" aria-labelledby="offcanvasProductLabel">
        <div class="offcanvas-header">
            <a href="" data-bs-dismiss="offcanvas" aria-label="Close">
                <h5 class="offcanvas-title fw-bold" id="offcanvasCategory"></h5>
            </a>
        </div>
        <form action="code.php" method="POST">
            <div class="offcanvas-body m-3">
                <img id="offcanvasImage" src="" class="rounded mx-auto d-block img-thumbnail" alt="...">

                <div class="row">
                    <div class="col-8">
                        <h1 class="canvas-title" id="offcanvasProductName">Product Name</h1>
                        <input type="hidden" name="product_name" id="offcanvasProductNameInput" value="">
                        <input type="hidden" name="product_code" id="offcanvasProductCode" value="">
                    </div>
                    <div class="col-4 text-end canvas-title px-3">
                        <span class="badge text-bg-primary" id="offcanvasPrice">Price</span>
                        <input type="hidden" name="price" id="offcanvasPriceRaw" value="">
                    </div>
                </div>

                <small id="offcanvasDesc"></small><br>
                <small id="offcanvasAvailableQty"></small><br>
                <small id="offcanvasExpiryDate"> <span id="offcanvasExpiryBadge" class="badge "></span></small>

                <div class="row mt-2">
                    <div class="col-7">
                        <span class="mx-2">Quantity</span><br>
                    </div>
                    <div class="col-5 px-3">
                        <div class="input-group">
                            <button class="btn btn-outline-warning decrement-btn" type="button">-</button>
                            <input type="number" class="form-control quantity" name="quantity" value="1">
                            <button class="btn btn-outline-warning increment-btn" type="button">+</button>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-3">
                    <button class="btn w-100 text-white" type="submit" name="BuyNowBtn"
                        style="background-color: #0f1b48;">Buy
                        Now</button>
                    <button class="btn w-100 text-white" type="submit" name="AddtoCartBtn"
                        style="background-color: #029bf1;">Add
                        to
                        Cart</button>
                </div>
            </div>
        </form>
    </div>

</main><!-- End #main -->

<!-- <script src="js/scripts.js"></script> -->

<script>
$(document).ready(function() {
    // Handle increment button click
    $(document).on('click', '.increment-btn', function() {
        let quantityInput = $(this).closest('.input-group').find('.quantity');
        let currentValue = parseInt(quantityInput.val()) || 0;
        let inventory = parseInt(quantityInput.data('inventory')) || 0;

        if (currentValue < inventory) {
            quantityInput.val(currentValue + 1);
        } else {
            Swal.fire({
                title: "Warning!",
                text: "Cannot exceed available inventory.",
                icon: "warning",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            });
        }
    });

    // Handle decrement button click
    $(document).on('click', '.decrement-btn', function() {
        let quantityInput = $(this).closest('.input-group').find('.quantity');
        let currentValue = parseInt(quantityInput.val()) || 0;
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
        } else {
            quantityInput.val(1);
        }
    });

    // Handle manual input changes
    $(document).on('input', '.quantity', function() {
        let value = parseInt($(this).val());
        let inventory = parseInt($(this).data('inventory')) || 0;

        if (isNaN(value) || value < 1) {
            $(this).val(1);
        } else if (value > inventory) {
            $(this).val(inventory);
            Swal.fire({
                title: "Warning!",
                text: "Cannot exceed available inventory.",
                icon: "warning",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
});
</script>

<?php
unset($_SESSION['order']);
unset($_SESSION['orders']);

include 'includes/footer.php';
?>