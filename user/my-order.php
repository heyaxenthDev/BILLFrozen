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
                <div class="mx-5 px-5">
                    <span class="badge bg-success rounded-pill mx-5">
                        <?= $total_items ?>
                    </span>
                </div>
            </a>
        </li><!-- End Cart Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
                <div class="mx-4 px-2">
                    <span class="badge bg-primary rounded-pill mx-5">
                        <?= $notifs ?>
                    </span>
                </div>
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
        $query = "SELECT o.`order_code`, o.`user_id`, o.`name`, o.`contact`, o.`product_code`, o.`product_name`, o.`quantity`, SUM(o.`total_price`) AS `total`, o.`order_date`, o.`delivery_date`, o.`delivery_address`, o.`order_status`, o.`date_created`, i.`product_picture` FROM `orders` o INNER JOIN `inventory` i ON o.`product_code` = i.`product_code` GROUP BY o.`order_code`";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $orderCode = $row['order_code'];
                $orderDate = $row['order_date'];
                $placedOrder = date_format(date_create($orderDate), "d, F Y");
                $productName = $row['product_name'];
                $quantity = $row['quantity'];
                $total = $row['total'];
                $orderStatus = $row['order_status'];
                $productPicture = $row['product_picture'];

                if (!function_exists('getOrderStatusBadgeClass')) {
                    function getOrderStatusBadgeClass($orderStatus)
                    {
                        switch ($orderStatus) {
                            case 'Pending':
                                return 'bg-warning';
                            case 'For Delivery':
                                return 'bg-primary';
                            case 'Out for Delivery':
                                return 'bg-info';
                            case 'Delivered' || 'Received':
                                return 'bg-success';
                            case 'Cancelled':
                                return 'bg-danger';
                            default:
                                return 'bg-secondary';
                        }
                    }
                }


        ?>
        <!-- Order Card -->
        <div class="card col-md-6 mx-auto">
            <div class="card-header">
                <span class="badge <?= getOrderStatusBadgeClass($orderStatus) ?>"><?= $orderStatus ?></span>
                <a href="#" class="float-end">View Details</a>
            </div>
            <div class="card-body">
                <h5 class="cart-title">Order Code: <?= $orderCode ?></h5>
                <span>Placed on: <?= $placedOrder ?></span>
                <div class="row mt-2 align-items-center">
                    <div class="col-md-3 col-5">
                        <img src="<?= $src . $productPicture ?>" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-9 col-7">
                        <h4><?= $productName ?></h4>
                        <small>Qty: <?= $quantity ?></small>
                    </div>
                </div>
                <h5 class="cart-title text-end">Grand Total: ₱<?= $total ?></h5>
            </div>
            <div class=" card-footer">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($orderStatus !== 'Out for Delivery') {
                            echo '<button class="btn btn-outline-secondary" type="button">Received</button>';
                          }else{
                            echo '<button class="btn btn-outline-success" type="submit">Recieved</button>';
                          } ?>

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