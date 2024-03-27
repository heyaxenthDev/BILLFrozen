<?php
include 'authentication.php';
include_once 'includes/header.php';

include "includes/conn.php";

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
            icon: '<?php echo $_SESSION['logged_icon']; ?>',
            title: '<?php echo $_SESSION['logged']; ?>'
        });
    </script>
<?php
    unset($_SESSION['logged']);
}
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="home.php">
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
            <a class="nav-link collapsed" href="my-order.php">
                <i class="bi bi-bag-check"></i>
                <span>My Orders</span>
            </a>
        </li><!-- End Orders Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <section class="p-3">
        <div class="row">
            <div class="col-lg-9 mb-3">
                <div class="pagetitle mb-3">
                    <div class="row">

                        <div class="col-md-6 mb-2 ">
                            <h1>Product List</h1>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="gap-2 d-md-flex justify-content-md-end">
                                <div class="search-bar">
                                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                                        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                                    </form>
                                </div><!-- End Search Bar -->
                            </div>
                        </div>

                    </div>
                </div><!-- End Page Title -->

                <hr>

                <!-- Additional content for the product list -->
                <div class="row">
                    <?php
                    // Perform database query to fetch product information
                    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity 
                        FROM product_list pl
                        JOIN inventory inv ON pl.product_name = inv.product_name LIMIT 4";
                    $result = $conn->query($sql);

                    // Check if query was successful
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="col-lg-3 col-6">
                                <!-- Card with an image on top -->
                                <a href="#" id="toggleButton">
                                    <div class="card">
                                        <img src="<?php echo $src . $row['product_picture']; ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                            <!-- <p class="card-text">Price: <?php echo $row['price']; ?></p>
                                        <?php if ($row['quantity'] == 0) : ?>
                                            <p class="card-text"><span class="badge bg-danger">Sold Out</span></p>
                                        <?php else : ?>
                                            <p class="card-text"><span class="badge bg-success">Available</span></p>
                                        <?php endif; ?> -->
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
                $query = "SELECT `product_name`, SUM(`sold`) AS `total_sold`, `product_picture` FROM `inventory` GROUP BY `product_name` HAVING `total_sold` > 0 ORDER BY `total_sold` DESC LIMIT 1";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $productName = $row['product_name'];
                        $totalSold = $row['total_sold'];
                        $productPicture = $src . $row['product_picture'];
                ?>
                        <a href="">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4 col-4">
                                        <img src="<?php echo $productPicture; ?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $productName; ?></h5>
                                            <p>Total Sold: <?php echo $totalSold; ?></p>
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

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end w-100" tabindex="-1" id="offcanvasProduct" aria-labelledby="offcanvasProductLabel">
        <div class="offcanvas-header">
            <a href="" data-bs-dismiss="offcanvas" aria-label="Close">
                <h5 class="offcanvas-title" id="offcanvasProductLabel"><i class="ri ri-arrow-left-s-line"></i>Category
                    Here</h5>
            </a>
        </div>
        <div class="offcanvas-body m-3">
            <img src="images/default-product-image.png" class="rounded mx-auto d-block img-thumbnail" alt="...">
            <div class="row">
                <div class="col-8">
                    <h1 class="canvas-title">Product Name</h1>
                </div>
                <div class="col-4 text-end canvas-title px-3">
                    <span class="badge text-bg-primary">Price</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-8 canvas-title">
                    <span class="mx-2">Quantity</span><br>
                </div>
                <div class="col-4 canvas-title px-3">
                    <div class="quantity-input">
                        <button class="btn btn-outline-warning decrement-btn">-</button>
                        <input type="number" class="form-control quantity" name="quantity" value="1">
                        <button class="btn btn-outline-warning increment-btn">+</button>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-3">
                <button class="btn w-100 text-white" type="button" style="background-color: #0f1b48;">Buy Now</button>
                <button class="btn w-100 text-white" type="button" style="background-color: #029bf1;">Add to
                    Cart</button>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="d-grid d-md-flex justify-content-md-end px-3 py-3">
                    <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3 pb-4">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="images/default-product-image.png" class="rounded mx-auto d-block img-thumbnail" alt="...">
                        </div>

                        <div class="col-md-7">
                            <h1 class="modal-title">Product Name</h1>
                            <small>Category: Frozen Foods</small><br>
                            <h2 class="modal-title"><span class="badge text-bg-primary">Price</span></h2>

                            <div class="row">
                                <div class="col-8 modal-title">
                                    <span class="mx-3">Quantity</span><br>
                                </div>
                                <div class="col-4 modal-title px-3">
                                    <div class="quantity-input">
                                        <button class="btn btn-outline-warning decrement-btn">-</button>
                                        <input type="number" class="form-control quantity" name="quantity" value="1">
                                        <button class="btn btn-outline-warning increment-btn">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-2 mb-2">
                                <button class="btn w-100 text-white" type="button" style="background-color: #0f1b48;">Buy
                                    Now</button>
                                <button class="btn w-100 text-white" type="button" style="background-color: #029bf1;">Add
                                    to
                                    Cart</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>




</main><!-- End #main -->

<script>
    let isOffcanvasOpen = false;
    let isModalOpen = false;

    // Function to toggle the offcanvas or modal based on screen width
    function toggleOffcanvasOrModal() {
        const screenWidth = window.innerWidth;

        if (screenWidth <= 1199) {
            // Toggle offcanvas
            const offcanvas = new bootstrap.Offcanvas(
                document.getElementById("offcanvasProduct")
            );
            isOffcanvasOpen = !isOffcanvasOpen;

            if (isOffcanvasOpen) {
                offcanvas.show();
            } else {
                offcanvas.hide();
            }
        } else {
            // Toggle modal
            const modal = new bootstrap.Modal(
                document.getElementById("modalProduct")
            );
            isModalOpen = !isModalOpen;

            if (isModalOpen) {
                modal.show();
            } else {
                modal.hide();
            }
        }
    }

    // Add click event listener to the button
    document
        .getElementById("toggleButton")
        .addEventListener("click", toggleOffcanvasOrModal);

    // Listen for the 'hidden.bs.offcanvas' event and reset the offcanvas state
    document
        .getElementById("offcanvasProduct")
        .addEventListener("hidden.bs.offcanvas", () => {
            isOffcanvasOpen = false;
        });

    // Listen for the 'hidden.bs.modal' event and reset the modal state
    document
        .getElementById("modalProduct")
        .addEventListener("hidden.bs.modal", () => {
            isModalOpen = false;
        });

    // Listen for the window resize event
    window.addEventListener("resize", () => {
        if (isOffcanvasOpen) {
            const offcanvas = new bootstrap.Offcanvas(
                document.getElementById("offcanvasProduct")
            );
            offcanvas.hide();
            isOffcanvasOpen = false;
        }

        if (isModalOpen) {
            const modal = new bootstrap.Modal(
                document.getElementById("modalProduct")
            );
            modal.hide();
            isModalOpen = false;
        }
    });

    $(document).ready(function() {
        $(".increment-btn").click(function(e) {
            e.preventDefault();
            var quantityInput = $(this).siblings(".quantity");
            var currentValue = parseInt(quantityInput.val());
            quantityInput.val(currentValue + 1);
        });

        $(".decrement-btn").click(function(e) {
            e.preventDefault();
            var quantityInput = $(this).siblings(".quantity");
            var currentValue = parseInt(quantityInput.val());
            if (currentValue > 1) {
                quantityInput.val(currentValue - 1);
            }
        });
    });
</script>

<?php
include 'includes/footer.php';
?>