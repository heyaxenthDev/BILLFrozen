<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in
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
                                $query = "SELECT order_code, user_id, SUM(quantity) as total_quantity, SUM(total_price) AS grand_total, order_date, delivery_date, delivery_address, order_status FROM orders GROUP BY order_code ORDER BY date_created ASC";

                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['order_code']; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['total_quantity']; ?></td>
                                    <td><?php echo "₱" . $row['grand_total']; ?></td>
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
                                                case 'For Delivery':
                                                    $badgeClass = 'badge bg-primary';
                                                    break;
                                                case 'Delivered':
                                                    $badgeClass = 'badge bg-info';
                                                    break;
                                                case 'Recieved':
                                                    $badgeClass = 'badge bg-success';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge bg-secondary';
                                                    break;
                                            }
                                            ?>

                                        <span class="<?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                    <td>
                                        <button class="btn btn-primary view-order-btn" data-bs-toggle="modal"
                                            data-bs-target="#ViewModal"
                                            data-order-code="<?php echo $row['order_code']; ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if ($row['order_status'] == 'for delivery') { ?>
                                        <a href="code.php?order=Delivered&OrderCode=<?php echo $row['order_code']; ?>"
                                            class="btn btn-success"><i class="bi bi-cart-check"></i></a>
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
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Customer's
                                            Contact:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="customerContact" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Customer's
                                            Name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="customerName" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Delivery
                                            Address:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="deliveryAddress" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Set Delivery
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
                                    <button type="submit" class="btn btn-danger" name="declineBtn"
                                        id="declineBtn">Decline
                                        Order</button>
                                    <script>
                                    document.getElementById('declineBtn').addEventListener('click', function() {
                                        document.getElementById('deliveryDate').removeAttribute('required');
                                    });
                                    </script>
                                    <button type="submit" class="btn btn-success" name="confirmBtn">Confirm
                                        Order</button>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var viewOrderButtons = document.querySelectorAll('.view-order-btn');

        viewOrderButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var orderCode = this.getAttribute('data-order-code');
                fetchOrderInformation(orderCode);
            });
        });

        function fetchOrderInformation(orderCode) {
            fetch('fetch_order_details.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_code: orderCode
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    var orderStatusElement = document.getElementById('orderStatus');
                    var status = data.order_status;
                    var badgeClass = '';

                    switch (status) {
                        case 'Pending':
                            badgeClass = 'badge bg-warning';
                            break;
                        case 'for delivery':
                            badgeClass = 'badge bg-primary';
                            break;
                        case 'Delivered':
                            badgeClass = 'badge bg-success';
                            break;
                        default:
                            badgeClass = 'badge bg-secondary';
                            break;
                    }

                    orderStatusElement.innerHTML = `<span class="${badgeClass}">${status}</span>`;

                    var confirmBtn = document.querySelector('[name="confirmBtn"]');
                    var declineBtn = document.querySelector('[name="declineBtn"]');

                    // Assuming data.order_status contains the order status
                    if (data.order_status !== 'Pending') {
                        confirmBtn.style.display = 'none';
                        declineBtn.style.display = 'none';
                    } else {
                        confirmBtn.style.display = 'inline-block'; // or 'block' based on your styling
                        declineBtn.style.display = 'inline-block'; // or 'block' based on your styling
                    }

                    document.getElementById('orderCode').value = data.order_code;
                    document.getElementById('customerName').value = data.name;
                    document.getElementById('customerContact').value = data.contact;
                    document.getElementById('deliveryAddress').value = data.delivery_address;
                    document.getElementById('deliveryDate').value = (data.delivery_date = null ?
                        "Order Declined" : data.delivery_date);

                    var orderItemsTableBody = document.getElementById('orderItemsTableBody');
                    orderItemsTableBody.innerHTML = '';

                    data.items.forEach(function(item, index) {
                        var unitPrice = item.total_price / item.quantity;
                        var formattedUnitPrice = unitPrice.toLocaleString('en-PH', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        var row = `
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${item.product_name}</td>
                                <td>${formattedUnitPrice}</td>
                                <td>${item.quantity}</td>
                                <td>₱${item.total_price}</td>
                            </tr>
                        `;
                        orderItemsTableBody.innerHTML += row;
                    });


                    document.getElementById('grandTotalPrice').textContent = "₱" +
                        data.grand_total;
                })
                .catch(error => console.error('Error:', error));
        }
    });
    </script>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>