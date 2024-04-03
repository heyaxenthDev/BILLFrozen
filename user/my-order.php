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
        <a href="home.php">
            <h1><i class="ri ri-arrow-left-s-line"></i> My Orders</h1>
        </a>
    </div><!-- End Page Title -->

    <section class="section">

        <?php
        // Assuming you have already established a database connection
        $query = "SELECT o.`order_code`, o.`user_id`, o.`name`, o.`contact`, o.`product_code`, o.`product_name`, o.`quantity`, SUM(o.`total_price`) AS `total`, o.`order_date`, o.`delivery_date`, o.`delivery_address`, o.`order_status`, o.`date_created`, i.`product_picture` FROM `orders` o INNER JOIN `inventory` i ON o.`product_code` = i.`product_code` WHERE 1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $orderCode = $row['order_code'];
                $productName = $row['product_name'];
                $quantity = $row['quantity'];
                $total = $row['total'];
                $orderStatus = $row['order_status'];
                $productPicture = $row['product_picture'];

        ?>
        <!-- Order Card -->
        <div class="card col-md-6 mx-auto">
            <div class="card-header"><?= $orderStatus ?></div>
            <div class="card-body">
                <h5 class="card-title"><?= $orderCode ?></h5>
                <div class="row">
                    <div class="col-6">
                        <img src="<?= $src . $productPicture ?>" alt="" height="100px">
                    </div>
                    <div class="col-6">
                        <span><?= $productName ?></span>
                    </div>
                </div>
                <h5 class="card-title text-end">Grand Total: ₱<?= $total ?></h5>
            </div>
            <div class=" card-footer">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-success" type="button">Recieved</button>
                </div>
            </div>
        </div><!-- End Order Card -->

        <?php
            }

            // Free result set
            mysqli_free_result($result);
        } else {
            echo 'Error executing query: ' . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
        ?>

    </section>



</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>