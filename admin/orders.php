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
                                <?php

                                // Fetch data from the orders table
                                $query = "SELECT order_code, user_id, SUM(quantity) as total_quantity, total_price, order_date, delivery_date, delivery_address, order_status FROM orders GROUP BY order_code ORDER BY date_created ASC";

                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['order_code']; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['total_quantity']; ?></td>
                                    <td><?php echo $row['total_price']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><?php echo $row['delivery_date']; ?></td>
                                    <td><?php echo $row['delivery_address']; ?></td>
                                    <td>
                                        <?php
                                            $status = $row['order_status'];
                                            $badgeClass = '';

                                            switch ($status) {
                                                case 'Pending':
                                                    $badgeClass = 'badge bg-warning';
                                                    break;
                                                case 'for delivery':
                                                    $badgeClass = 'badge bg-primary text-dark';
                                                    break;
                                                case 'Delivered':
                                                    $badgeClass = 'badge bg-success';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge bg-secondary';
                                                    break;
                                            }
                                            ?>

                                        <span class="<?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                    <td>
                                        <a class="btn btn-primary view-order-btn" data-bs-toggle="modal"
                                            data-bs-target="#ViewModal"
                                            data-order-code="<?php echo $row['order_code']; ?>"><i
                                                class="bi bi-eye"></i> View Order</a>

                                        <!-- <?php if ($row['order_status'] == 'Pending') { ?>
                                        <a class="btn btn-success"><i class="bi bi-check"></i></a>
                                        <a class="btn btn-danger"><i class="bi bi-x"></i></a> -->
                                        <?php }
                                                    if ($row['order_status'] == 'for delivery') { ?>
                                        <a class="btn btn-success"><i class="bi bi-cart-check"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->


                    </div>
                </div>

                <!-- View Order Modal -->
                <div class="modal fade" id="ViewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Order Information</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body m-4">
                                <form>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Order Code: </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="orderCode">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Customer's
                                            Name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="customerName">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Delivery
                                            Address:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="deliveryAddress">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Set Delivery
                                            Date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="deliveryDate" required>
                                        </div>
                                    </div>
                                    <span>Item/s:</span>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Unit Price</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Brandon Jacob</td>
                                                <td>Designer</td>
                                                <td>28</td>
                                                <td>2016-05-25</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Bridie Kessler</td>
                                                <td>Developer</td>
                                                <td>35</td>
                                                <td>2014-12-05</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Ashleigh Langosh</td>
                                                <td>Finance</td>
                                                <td>45</td>
                                                <td>2011-08-12</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Angus Grady</td>
                                                <td>HR</td>
                                                <td>34</td>
                                                <td>2012-06-11</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>Raheem Lehner</td>
                                                <td>Dynamic Division Officer</td>
                                                <td>47</td>
                                                <td>2011-04-19</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-end">
                                                    GRAND TOTAL
                                                </th>
                                                <th>total here</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger">Decline Order</button>
                                <button type="button" class="btn btn-success">Confirm Order</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>