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
        <h1>Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Inventory</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3 col-lg-12 col-5">
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#productList">
                    <i class="bi bi-cart-plus-fill"></i> Add Product</button>
            </div>
        </div>


        <!-- Add Product Modal -->
        <div class="modal fade" id="productList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="productListLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Product Image Preview -->
                                    <center>
                                        <img id="productPreview" src="images/default-product-image.png"
                                            alt="Product Image Preview" style="max-width: 100%; max-height: 300px;">
                                    </center>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="product_name" name="product_name" required>
                                            <option value="" selected disabled>Select a Product</option>
                                            <?php

                                            // Query to fetch product names from the database
                                            $query = "SELECT * FROM `product_list`";
                                            $result = mysqli_query($conn, $query);

                                            // Loop through the results and create an option for each product name
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                echo "<option value='{$row['id']}'>{$row['product_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="product-name">Product Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            placeholder=" " required>
                                        <label for="quantity">Quantity</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="expiry-date" name="expiry-date"
                                            placeholder=" " required>
                                        <label for="expiry-date">Expiry Date</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addInventoryProduct"><i
                                    class="bi bi-plus"></i> Add
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory List</h5>
                        <!-- Product Inventory Table -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Product Code</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch data from the inventory table
                                $query = "SELECT * FROM `inventory`";
                                $result = mysqli_query($conn, $query);

                                // Loop through the results and create table rows
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$row['product_code']}</th>";
                                    echo "<td><img src='{$row['product_picture']}' style='max-width: 100px; max-height: 65px;' alt='Product Image'> {$row['product_name']}</td>";
                                    echo "<td>{$row['price']}</td>";
                                    echo "<td>";
                                    if ($row['quantity'] == 0) {
                                        echo "<span class='badge bg-secondary'>Out of Stock</span>";
                                    } else {
                                        echo "{$row['quantity']}";
                                    }
                                    echo "</td>";
                                    echo "<td>{$row['sold']}</td>"; // Sold

                                    $currentDate = strtotime(date('Y-m-d'));
                                    $expiryDate = strtotime($row['expiry_date']);

                                    $statusClass = '';
                                    $statusText = '';
                                    if (
                                        $expiryDate < $currentDate
                                    ) {
                                        $statusClass = 'danger'; // Expired
                                        $statusText = 'Expired';
                                    } elseif ($expiryDate < strtotime('+1 month', $currentDate)) {
                                        $statusClass = 'warning'; // Expiring Soon
                                        $statusText = 'Expiring Soon';
                                    } else {
                                        $statusClass = 'success'; // Good
                                        $statusText = 'Good';
                                    }

                                    echo "<td><span class='badge bg-$statusClass'>$statusText</span></td>";
                                    echo "<td>{$row['expiry_date']}</td>";

                                    echo "<td>";
                                    echo "<a class='btn btn-success mx-2' data-bs-toggle='modal' data-bs-target='#editInventoryModal' data-id='{$row['id']}' data-product-name='{$row['product_name']}' data-price='{$row['price']}' data-quantity='{$row['quantity']}' data-expiry-date='{$row['expiry_date']}'><i class='bi bi-pencil-square'></i></a>";
                                    echo "<a class='btn btn-danger'><i class='bi bi-trash'></i></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }

                                function getStatusBadgeClass($status)
                                {
                                    switch ($status) {
                                        case 'Good':
                                            return 'success';
                                        case 'Expired':
                                            return 'danger';
                                        case 'Expiring Soon':
                                            return 'warning';
                                        default:
                                            return 'secondary';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Product Inventory Table -->
                    </div>
                </div>

                <!-- Edit Inventory Item Modal -->
                <div class="modal fade" id="editInventoryModal" tabindex="-1" aria-labelledby="editInventoryModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editInventoryModalLabel">Edit Inventory Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form for editing inventory item -->
                                <form action="code.php" method="POST">
                                    <input type="text" name="id" id="editId">
                                    <div class="mb-3">
                                        <label for="editProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="editProductName"
                                            name="product_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editPrice" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="editPrice" name="price">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editQuantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="editQuantity" name="quantity">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editExpiryDate" class="form-label">Expiry Date</label>
                                        <input type="date" class="form-control" id="editExpiryDate" name="expiry_date">
                                    </div>
                                    <!-- Add more fields as needed -->
                                    <button type="submit" class="btn btn-primary" name="editInventory">Save
                                        Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                var editInventoryModal = document.getElementById('editInventoryModal');
                editInventoryModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var productName = button.getAttribute('data-product-name');
                    var price = button.getAttribute('data-price');
                    var quantity = button.getAttribute('data-quantity');
                    var expiryDate = button.getAttribute('data-expiry-date');

                    var editIdField = editInventoryModal.querySelector('#editId');
                    var editProductNameField = editInventoryModal.querySelector('#editProductName');
                    var editPriceField = editInventoryModal.querySelector('#editPrice');
                    var editQuantityField = editInventoryModal.querySelector('#editQuantity');
                    var editExpiryDateField = editInventoryModal.querySelector('#editExpiryDate');

                    editIdField.value = id;
                    editProductNameField.value = productName;
                    editPriceField.value = price;
                    editQuantityField.value = quantity;
                    editExpiryDateField.value = expiryDate;
                });
                </script>


            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>