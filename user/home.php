<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
include_once 'includes/header.php';

include "alert.php";

?>
<script src="js/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['logged'])) {
?>
<script type="text/javascript">
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

Toast.fire({
    background: '#53a653',
    color: '#fff',
    icon: '<?= $_SESSION['logged_icon']; ?>',
    title: '<?= $_SESSION['logged']; ?>'
});
</script>
<?php
    unset($_SESSION['logged']);
}
?>

<main id="main" class="main">

    <section class="p-3">
        <div class="row">
            <div class="col-lg-9 mb-3">
                <div class="pagetitle mb-3">

                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <h1>Product List</h1>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="justify-content-md-end">
                                <div class="search-bar">
                                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                                        <input type="text" name="query" placeholder="Search"
                                            title="Enter search keyword">
                                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                                    </form>
                                </div><!-- End Search Bar -->
                            </div>
                        </div>
                    </div>
                </div><!-- End Page Title -->


                <hr>

                <!-- Additional content for the product list -->
                <div class="row" id="product-user">
                    <div id="productListLoading"
                        style="display:none;position:absolute;left:50%;top:30%;transform:translate(-50%, -50%);z-index:10;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <?php
                    // Perform database query to fetch product information
                    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
                            FROM product_list pl
                            JOIN inventory inv ON pl.product_name = inv.product_name 
                            WHERE inv.quantity > 0 
                            LIMIT 4";

                    $result = $conn->query($sql);

                    // Check if query was successful
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <a href="#" class="product-link" data-product-id="<?= $row['product_code']; ?>">
                            <div class="card item">
                                <img src="<?= $src . $row['product_picture']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['product_name']; ?></h5>
                                    <p class="card-text">Price: <?= $row['price']; ?></p>
                                    <?php if ($row['quantity'] == 0) : ?>
                                    <p class="card-text"><span class="badge bg-danger">Sold Out</span></p>
                                    <?php else : ?>
                                    <p class="card-text">Qty: <?= $row['quantity']?> <span
                                            class="badge bg-success">Available</span></p>
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
                    ?>
                </div><!-- row end -->


                <div class="d-grid gap-2 d-flex justify-content-end">
                    <a class="btn btn-primary" href="product-list.php">See More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            </div>

            <!-- Best sellers -->


            <div class="col-lg-3">
                <h4 class="fw-semibold">Best Sellers</h4>
                <?php
                $query = "SELECT `product_name`, SUM(`sold`) AS `total_sold`, `product_picture`, `product_code`, quantity FROM `inventory` GROUP BY `product_name` HAVING `total_sold` > 0 ORDER BY `total_sold` DESC LIMIT 1";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $productName = $row['product_name'];
                        $totalSold = $row['total_sold'];
                        $productPicture = $src . $row['product_picture'];
                ?>
                <a href="" class="product-link" data-product-id="<?= $row['product_code']; ?>"
                    data-inventory="<?= $row['quantity']; ?>">
                    <div class="card mb-3 item" style="max-width: 540px;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 col-4">
                                <img src="<?= $productPicture; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="col-md-8 col-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $productName; ?></h5>
                                    <p>Total Sold: <?= $totalSold; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                    }
                }

                ?>

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
                    <div class="col-5 modal-title px-3">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input[name="query"]');
    const productListContainer = document.getElementById('product-user');
    const loadingSpinner = document.getElementById('productListLoading');
    let timer;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                const query = searchInput.value;
                loadingSpinner.style.display = 'block';
                fetch('search_home_products.php', {
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
                        // Insert the new product cards after the spinner
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        while (tempDiv.firstChild) {
                            productListContainer.appendChild(tempDiv.firstChild);
                        }
                    })
                    .finally(() => {
                        loadingSpinner.style.display = 'none';
                    });
            }, 300);
        });
        // Prevent form submit
        searchInput.form.addEventListener('submit', function(e) {
            e.preventDefault();
            searchInput.dispatchEvent(new Event('input'));
        });
    }

});

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