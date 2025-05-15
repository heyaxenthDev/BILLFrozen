<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in

include "includes/conn.php";
include_once 'includes/header.php';
include 'includes/sidebar.php';
include "alert.php";
?>

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
                        <p></p>

                        <!-- Table with stripped rows -->
                        <table id="ordersTable" class="table datatable">
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
                                $query = "SELECT order_code, user_id, SUM(quantity) as total_quantity, SUM(total_price) AS grand_total, order_date, delivery_date, delivery_address, order_status FROM orders GROUP BY order_code ORDER BY date_created DESC";

                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $row['order_code'] ?></td>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= $row['total_quantity'] ?></td>
                                    <td><?= "₱" . $row['grand_total'] ?></td>
                                    <td><?= $row['order_date'] ?></td>
                                    <td><?= date("F j, Y", strtotime($row['delivery_date']))?></td>
                                    <td><?= $row['delivery_address'] ?></td>
                                    <td>
                                        <?php
                                            $status = $row['order_status'];
                                            $badgeClass = '';

                                            switch ($status) {
                                                case 'Pending':
                                                    $badgeClass = 'badge bg-warning';
                                                    break;
                                                case 'For Delivery':
                                                    $badgeClass = 'badge bg-primary';
                                                    break;
                                                case 'Delivered':
                                                    $badgeClass = 'badge bg-info';
                                                    break;
                                                case 'Order Received':
                                                    $badgeClass = 'badge bg-success';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge bg-secondary';
                                                    break;
                                            }
                                            ?>

                                        <span class="<?= $badgeClass ?>"><?= $status ?></span>
                                    <td>
                                        <!-- View Modal Button -->
                                        <button class="btn btn-primary btn-sm view-order-btn" data-bs-toggle="modal"
                                            data-bs-target="#ViewModal" data-order-code="<?= $row['order_code'] ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Complete Delivery Status -->
                                        <?php if ($row['order_status'] == 'For Delivery') { ?>
                                        <a href="code.php?order=Delivered&OrderCode=<?= $row['order_code'] ?>"
                                            class="btn btn-success btn-sm"><i class="bi bi-cart-check"></i></a>
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
                <div class=" modal fade" id="ViewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Order
                                    Information</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="code.php" method="POST">
                                <input type="hidden" id="Status">
                                <input type="hidden" class="form-control" id="userID" name="userID" readonly>
                                <div class="modal-body m-4">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Order Status: </label>
                                        <div class="col-sm-9">
                                            <span id="orderStatus"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Order Code: </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="orderCode" name="orderCode"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="customerContact" class="col-sm-3 col-form-label">Customer's
                                            Contact:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="customerContact" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="customerName" class="col-sm-3 col-form-label">Customer's
                                            Name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="customerName"
                                                name="customerName" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="deliveryAddress" class="col-sm-3 col-form-label">Delivery
                                            Address:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="deliveryAddress" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="deliveryDate" class="col-sm-3 col-form-label">Set Delivery
                                            Date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="deliveryDate"
                                                name="deliveryDate" required>
                                        </div>
                                    </div>
                                    <span>Item/s:</span>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Unit Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="orderItemsTableBody">
                                            <!-- Order items will be displayed here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-end">GRAND TOTAL
                                                </th>
                                                <th id="grandTotalPrice"></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm" id="openDeclineModalBtn">Decline
                                        Order</button>
                                    <button type="submit" class="btn btn-success btn-sm" name="confirmBtn">Confirm
                                        Order</button>

                                    <button style="display: none;" type="submit" class="btn btn-primary btn-sm"
                                        name="saveChangeBtn" id="saveChangeBtn">Save
                                        Change Date</button>

                                    <!-- Print Modal Button -->
                                    <button id="print-view-modal" onclick="printOrderModal()"
                                        class="btn btn-secondary btn-sm">
                                        <i class="bi bi-printer"></i> Print Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Decline Reason Modal -->
                <div class="modal fade" id="declineReasonModal" tabindex="-1" aria-labelledby="declineReasonModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="declineReasonModalLabel">Decline Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="declineReasonForm" method="POST" action="code.php">
                                <div class="modal-body">
                                    <input type="hidden" name="decline_order_code" id="decline_order_code">
                                    <div class="mb-3">
                                        <label for="decline_reason" class="form-label">Reason for Decline <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="decline_reason" name="decline_reason"
                                            rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm">Submit Reason</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </section>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/order.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Open Decline Modal and set order code
        document.getElementById('openDeclineModalBtn').addEventListener('click', function() {
            var orderCode = document.getElementById('orderCode').value;
            document.getElementById('decline_order_code').value = orderCode;
            var declineModal = new bootstrap.Modal(document.getElementById('declineReasonModal'));
            declineModal.show();
        });
    });
    </script>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>