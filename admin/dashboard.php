<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
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
            <a class="nav-link " href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="orders.php">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
                <div class="mx-5 px-4">
                    <?php
                    if ($count != 0) {
                    ?>
                    <span class="badge bg-primary rounded-pill mx-5">
                        <?= $count ?>
                    </span>
                    <?php
                    }
                    ?>
                </div>
            </a>
        </li><!-- End Orders Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="products.php">
                <i class="bi bi-basket2"></i>
                <span>Product List</span>
            </a>
        </li><!-- End Product List Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="inventory.php">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li><!-- End Inventory Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="reports.php">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Reports Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="users.php">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li><!-- End Users Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle mb-3">
        <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <?php
                    // Assume you have established a database connection

                    // Query to fetch total orders
                    $totalOrdersQuery = "SELECT COUNT(DISTINCT `order_code`) AS total_orders FROM orders WHERE `order_status` = 'Pending'";

                    // Query to fetch total delivered orders
                    $deliveredOrdersQuery = "SELECT COUNT(DISTINCT `order_code`) AS total_delivered FROM orders WHERE order_status = 'Delivered'";

                    // Execute queries
                    $totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
                    $deliveredOrdersResult = mysqli_query($conn, $deliveredOrdersQuery);

                    // Fetch counts
                    $totalOrdersRow = mysqli_fetch_assoc($totalOrdersResult);
                    $totalDeliveredRow = mysqli_fetch_assoc($deliveredOrdersResult);

                    // Assign counts to variables
                    $totalOrders = $totalOrdersRow['total_orders'];
                    $totalDelivered = $totalDeliveredRow['total_delivered'];
                    ?>

                    <!-- Order Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card order-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php echo $totalOrders; ?>
                                            <!-- Count of orders -->
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Order Card -->

                    <!-- Delivered Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card delivered-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Delivered</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php echo $totalDelivered; ?>
                                            <!-- Count of order status = Delivered -->
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Delivered Card -->


                    <!-- Out of Stocks -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Out of Stocks</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Revenue</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    // Assuming you have already connected to your database
                                    $sql = "SELECT * FROM `inventory` WHERE 1";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <?php if ($row['quantity'] <= 5) { ?>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="<?php echo $row['product_picture']; ?>" alt=""></a></th>
                                            <td><a href="#"
                                                    class="text-primary fw-bold"><?php echo $row['product_name']; ?></a>
                                            </td>
                                            <td>$<?php echo $row['price']; ?></td>
                                            <td class="fw-bold"><?php echo $row['sold']; ?></td>
                                            <td>₱<?php echo number_format($row['price'] * $row['sold'], 2); ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Out of Stocks -->
                    <?php
                                    } else {
                                        echo "No inventory found.";
                                    }

                ?>



                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Reports <span>/Today</span></h5>
                                <?php
                            // Assuming you have already connected to your database
                            $sql = "SELECT `order_date`, `total_price` FROM `orders` WHERE DATE(`order_date`) = CURDATE()";
                            $result = mysqli_query($conn, $sql);

                            $dataPointsSales = [];
                            $dataPointsRevenue = [];

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $dataPointsSales[] = intval($row['total_price']); // Convert total_price to integer
                                    $dataPointsRevenue[] = strtotime($row['order_date']) * 1000; // Convert order_date to milliseconds
                                }
                            }
                            ?>
                                <!-- Line Chart -->
                                <div id="reportsChart"></div>

                                <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector(
                                        "#reportsChart"), {
                                        series: [{
                                            name: 'Sales',
                                            data: <?php echo json_encode($dataPointsSales); ?>,
                                        }, {
                                            name: 'Revenue',
                                            data: <?php echo json_encode($dataPointsRevenue); ?>
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#2eca6a'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: <?php echo json_encode($dataPointsRevenue); ?>
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy HH:mm'
                                            },
                                        }
                                    }).render();
                                });
                                </script>
                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div><!-- End Reports -->





                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- New Order -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body pb-3">
                        <h5 class="card-title">New Orders</h5>
                        <?php
                        // Assuming you have already connected to your database

                        $currentDateTime = date('Y-m-d H:i:s');
                        $oneDayAgo = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($currentDateTime)));
                        $sql = "SELECT * FROM `orders`  WHERE `date_created` >= '$oneDayAgo'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                        ?>
                        <div class="news">
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="post-item clearfix">
                                <h4><a href="#"><?php echo $row['product_name']; ?></a></h4>
                                <p>Order Code: <?php echo $row['order_code']; ?></p>
                                <p>Quantity: <?php echo $row['quantity']; ?></p>
                                <p>Total Price: <?php echo $row['total_price']; ?></p>
                                <p>Order Date: <?php echo $row['order_date']; ?></p>
                                <p>Delivery Date: <?php echo $row['delivery_date']; ?></p>
                                <p>Delivery Address: <?php echo $row['delivery_address']; ?></p>
                                <p>Order Status: <?php echo $row['order_status']; ?></p>
                            </div>
                            <?php } ?>
                        </div><!-- End sidebar recent posts-->

                    </div>
                </div><!-- End New Order -->
                <?php
                        } else {
                            echo "No new orders found.";
                        }

                        // Close the database connection
                        mysqli_close($conn);
            ?>


            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>