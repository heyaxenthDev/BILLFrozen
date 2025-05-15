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
                        <a href="" class="product-link" data-product-id="<?php echo $row['product_code']; ?>">
                            <div class="card">
                                <img src="<?php echo $src . $row['product_picture']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h6 class="fw-bold"><?php echo $row['product_name']; ?></h6>
                                    <p class="card-text">Price: <?php echo $row['price']; ?></p>
                                    <?php if ($row['quantity'] == 0) : ?>
                                    <p class="card-text"><span class="badge bg-danger">Sold Out</span></p>
                                    <?php else : ?>
                                    <p class="card-text"><span class="badge bg-success">Available</span></p>
                                    <?php endif; ?>
                                </div>
                            </div><!-- End Card with an image on top -->
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
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true"
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
                                        <input type="hidden" name="product_name" id="modProductName" value="">
                                        <input type="hidden" name="product_code" id="productCode" value="">
                                    </div>
                                    <div class="col-3">
                                        <h2 class="modal-title"><span class="badge text-bg-primary"
                                                id="modalPrice">Price</span>
                                            <input type="hidden" name="price" id="modalPriceRaw" value="">

                                    </div>
                                </div>

                                <small id="modalCategory">Category: Frozen Foods</small><br>
                                </h2>

                                <div class="row">
                                    <div class="col-7 modal-title">
                                        <span class="mx-3">Quantity</span><br>
                                    </div>
                                    <div class="col-5 modal-title px-3">
                                        <div class="input-group">
                                            <button class="btn btn-outline-warning decrement-btn">-</button>
                                            <input type="number" class="form-control quantity" name="quantity" value="1"
                                                data-inventory="">
                                            <button class="btn btn-outline-warning increment-btn">+</button>
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
                        <input type="hidden" name="product_name" id="offProductName" value="">
                        <input type="hidden" name="product_code" id="offproductCode" value="">
                    </div>
                    <div class="col-4 text-end canvas-title px-3">
                        <span class="badge text-bg-primary" id="offcanvasPrice">Price</span>
                        <input type="hidden" name="price" id="offcanvasPriceRaw" value="">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-7">
                        <span class="mx-2">Quantity</span><br>
                    </div>
                    <div class="col-5 px-3">
                        <div class="input-group">
                            <button class="btn btn-outline-warning decrement-btn">-</button>
                            <input type="number" class="form-control quantity" name="quantity" value="1">
                            <button class="btn btn-outline-warning increment-btn">+</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearchInput');
    const productListContainer = document.getElementById('productListContainer');
    const loadingSpinner = document.getElementById('productListLoading');
    let timer;
    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            const query = searchInput.value;
            loadingSpinner.style.display = 'block';
            fetch('search_products_list.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'query=' + encodeURIComponent(query)
                })
                .then(response => response.text())
                .then(html => {
                    // Remove all children except the spinner
                    Array.from(productListContainer.children).forEach(child => {
                        if (child.id !== 'productListLoading') {
                            child.remove();
                        }
                    });
                    // Insert the new product cards or message after the spinner
                    productListContainer.insertAdjacentHTML('beforeend', html);
                })
                .finally(() => {
                    loadingSpinner.style.display = 'none';
                });
        }, 300);
    });
    // Prevent form submit
    document.getElementById('productSearchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        searchInput.dispatchEvent(new Event('input'));
    });

    // Handle product link clicks
    document.getElementById('productListContainer').addEventListener('click', function(e) {
        const link = e.target.closest('.product-link');
        if (link) {
            e.preventDefault();
            const productId = link.getAttribute('data-product-id');
            if (!productId) {
                alert('No product ID found!');
                return;
            }
            fetch('get_product_details.php?product_id=' + productId)
                .then(response => response.json())
                .then(data => {
                    // Update modal content
                    document.getElementById('modalImage').src = data.product_picture;
                    document.getElementById('modalProductName').textContent = data.product_name;
                    document.getElementById('modProductName').value = data.product_name;
                    document.getElementById('productCode').value = data.product_code;
                    document.getElementById('modalPrice').textContent = '₱' + data.price;
                    document.getElementById('modalPriceRaw').value = data.price;
                    document.getElementById('modalCategory').textContent = 'Category: ' + data
                        .category;

                    // Set inventory quantity
                    const quantityInput = document.querySelector('#modalProduct .quantity');
                    quantityInput.setAttribute('data-inventory', data.quantity);
                    quantityInput.setAttribute('max', data.quantity);

                    // Show modal for wide screens and off-canvas for mobile
                    if (window.innerWidth >= 768) {
                        const modal = new bootstrap.Modal(document.getElementById('modalProduct'));
                        modal.show();
                    } else {
                        const offcanvas = new bootstrap.Offcanvas(document.getElementById(
                            'offcanvasProduct'));
                        offcanvas.show();
                    }
                });
        }
    });

    // Handle increment/decrement buttons in modal
    const modalQuantityInput = document.querySelector('#modalProduct .quantity');
    const modalIncrementBtn = document.querySelector('#modalProduct .increment-btn');
    const modalDecrementBtn = document.querySelector('#modalProduct .decrement-btn');

    modalIncrementBtn.addEventListener('click', function() {
        const currentValue = parseInt(modalQuantityInput.value) || 0;
        const inventory = parseInt(modalQuantityInput.getAttribute('data-inventory')) || 0;

        if (currentValue < inventory) {
            modalQuantityInput.value = currentValue + 1;
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

    modalDecrementBtn.addEventListener('click', function() {
        const currentValue = parseInt(modalQuantityInput.value) || 0;
        if (currentValue > 1) {
            modalQuantityInput.value = currentValue - 1;
        }
    });

    // Handle manual input
    modalQuantityInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        const inventory = parseInt(this.getAttribute('data-inventory')) || 0;

        if (isNaN(value) || value < 1) {
            this.value = 1;
        } else if (value > inventory) {
            this.value = inventory;
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
    });
});
</script>

<?php
unset($_SESSION['order']);
unset($_SESSION['orders']);

include 'includes/footer.php';
?>