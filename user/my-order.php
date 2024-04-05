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
                    <?php
                    if ($total_items != 0) {

                    ?>
                    <span class="badge bg-success rounded-pill mx-5">
                        <?= $total_items ?>
                    </span>
                    <?php
                    }
                    ?>
                </div>
            </a>
        </li><!-- End Cart Page Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
                <div class="mx-4 px-2">
                    <?php
                    if ($notifs != 0 && $stat == "unread") {
                    ?>
                    <span class="badge bg-primary rounded-pill mx-5">
                        <?= $notifs ?>
                    </span>
                    <?php
                    }
                    ?>
                </div>
            </a>
        </li><!-- End Notifications Modal Nav -->

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
            if (mysqli_num_rows($result) == 0) {
                echo '<p>No orders found.</p>';
            } else {
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
                <a href="#" class="float-end view-order-btn" data-bs-toggle="modal" data-bs-target="#viewDetails"
                    data-order-code="<?= $orderCode ?>">View
                    Details</a>
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
                <small>
                    <!-- if there are more items with the same order codes, it will display a text "(number of items) more items"  -->
                </small>
            </div>
            <div class=" card-footer">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="text-start fw-bold" style="color: #4154f1;">Grand Total: ₱<?= $total ?></h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <?php if ($orderStatus !== 'Out for Delivery') {
                                            echo '<button class="btn btn-outline-secondary" type="button">Received</button>';
                                        } else {
                                            echo '<button class="btn btn-outline-success" type="submit">Recieved</button>';
                                        } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Order Card -->
        <?php
                }
            }
            // Free result set
            mysqli_free_result($result);
        } else {
            echo 'Error executing query: ' . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
        ?>

        <!-- View Order Modal -->
        <div class="modal fade" id="viewDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="fs-5" id="viewDetailsLabel">Order
                            Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-7">
                                <h6 class="form-label">Order Code: <span class="mx-2 fw-semibold" id="orderCode"></span>
                                </h6>
                            </div>

                            <div class="col-md-5">
                                <h6 class="form-label">Order Status: <span class="mx-2 fw-semibold"
                                        id="orderStatus"></span>
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <h6 class="form-label">Customer's Name: <span class="mx-2 fw-semibold"
                                        id="customerName"></span>
                                </h6>
                            </div>
                            <div class="col-md-5">
                                <h6 class="form-label">Customer's Contact: <span class="mx-2 fw-semibold"
                                        id="customerContact"></span></h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <h6 class="form-label">Delivery Address: <span class="mx-2 fw-semibold"
                                        id="deliveryAddress"></span>
                                </h6>
                            </div>
                            <div class="col-md-5">
                                <h6 class="form-label">Set Delivery Date: <span class="mx-2 fw-semibold"
                                        id="deliveryDate"></span>
                                </h6>
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
                </div>
            </div>
        </div>


    </section>

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

                    document.getElementById('orderCode').textContent = data.order_code;
                    document.getElementById('customerName').textContent = data.name;
                    document.getElementById('customerContact').textContent = data.contact;
                    document.getElementById('deliveryAddress').textContent = data.delivery_address;

                    if (data.delivery_date == null || data.delivery_date == empty) {
                        document.getElementById('deliveryDate').textContent = "N/A";
                    } else {
                        document.getElementById('deliveryDate').textContent = data.delivery_date;
                    }


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