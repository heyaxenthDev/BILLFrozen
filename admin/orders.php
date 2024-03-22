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
            <a class="nav-link collapsed" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link " href="orders.php">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
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

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Orders</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order List</h5>
                        <p>Add lightweight datatables to your project with using the <a
                                href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple
                                DataTables</a> library. Just add <code>.datatable</code> class name to any table you
                            wish to conver to a datatable</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Order Code</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Order Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Brandon Jacob</td>
                                    <td>Designer</td>
                                    <td>28</td>
                                    <td>28</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>
                                        <a class="btn btn-primary"><i class="bi bi-eye"></i></a>

                                        <!-- if order status is pending { -->
                                        <a class="btn btn-success"><i class="bi bi-check"></i></a>
                                        <a class="btn btn-danger"><i class="bi bi-x"></i></a>
                                        <!-- } -->

                                        <!-- if order status is for delivery { -->
                                        <a class="btn btn-success"><i class="bi bi-cart-check"></i></a>
                                        <!-- } -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>