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

    <section class="p-2">
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="pagetitle mb-3">
                    <div class="row">

                        <div class="col-md-6 mb-3 ">
                            <h1><a href="home.php"><i class="ri ri-arrow-left-s-line"></i></a> Product List</h1>
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
                            JOIN inventory inv ON pl.product_name = inv.product_name";
                    $result = $conn->query($sql);

                    // Check if query was successful
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            ?>
                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <a href="">
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

                    // Close the database connection
                    $conn->close();
                    ?>
                </div><!-- row end -->

            </div>


        </div>
    </section>



</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>