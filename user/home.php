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
                        <a href="#" class="product-card" data-product-name="<?php echo $row['product_name']; ?>"
                            data-category="<?php echo $row['category']; ?>" data-price="<?php echo $row['price']; ?>"
                            data-quantity="<?php echo $row['quantity']; ?>"
                            data-product-picture="<?php echo $src.$row['product_picture']; ?>">
                            <div class="card">
                                <img src="<?php echo $src.$row['product_picture']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                    <!-- <p class="card-text">Price: <?php echo $row['price']; ?></p>
                                        <?php if ($row['quantity'] == 0): ?>
                                            <p class="card-text"><span class="badge bg-danger">Sold Out</span></p>
                                        <?php else: ?>
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
                    $productPicture = $src.$row['product_picture'];
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

    <!-- Offcanvas for product details -->
    <div class="offcanvas offcanvas-end w-100" tabindex="-1" id="productDetailsOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="productDetailsOffcanvasLabel">Product Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="productDetailsBody">
            <!-- Product details will be dynamically inserted here -->
            <div class="container product-details-container"></div>
        </div>
        <div class="offcanvas-footer">
            <button type="button" class="btn btn-primary add-to-cart-btn">Add to Cart</button>
        </div>
    </div>





</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>