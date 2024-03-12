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
            <a class="nav-link collapsed" href="orders.php">
                <i class="bi bi-cart"></i>
                <span>Orders</span>
            </a>
        </li><!-- End Orders Page Nav -->

        <li class="nav-item">
            <a class="nav-link " href="products.php">
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
        <h1>Products List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Products List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row mt-4 mb-4">
            <div class="col-3 d-grid gap-2 d-md-block">
                <input type="email" class="form-control" id="SearchBar" placeholder="Search Product...">
            </div>
            <div class="col-9 d-grid gap-2 d-md-flex justify-content-md-end">
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
                                        <img id="productImagePreview" src="images/default-product-image.png"
                                            alt="Product Image Preview" style="max-width: 100%; max-height: 300px;">
                                    </center>
                                    <!-- Product Image Input -->
                                    <small class="mt-2">Add Product Image</small>
                                    <input type="file" name="productImage" class="form-control mb-3" id="productImage"
                                        onchange="previewProductImage();" accept="image/*" required>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder=" " required>
                                        <label for="product_name">Product Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="category" name="category" required>
                                            <option selected>Select Category</option>
                                            <option value="Frozen Foods">Frozen Foods</option>
                                            <option value="Street Foods">Street Foods</option>
                                            <option value="Dressed Chicken">Dressed Chicken</option>
                                        </select>
                                        <label for="category">Category</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="price" name="price" placeholder=" "
                                            required>
                                        <label for="price">Price</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addNewProduct"><i
                                    class="bi bi-plus"></i> Add
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr>

        <div class="row" id="product">
            <?php
            // Query to fetch data from product_list table
            $query = "SELECT `id`, `product_name`, `category`, `price`, `product_picture` FROM `product_list` WHERE 1";

            // Perform the query
            $result = $conn->query($query);

            // Check if there are any rows in the result
            if ($result->num_rows > 0) {
                // Loop through each row
                while ($row = $result->fetch_assoc()) {
                    ?>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="<?php echo $row['product_picture']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo $row['product_name']; ?></h6>
                        <p class="card-text fw-semibold">₱<?php echo $row['price']; ?></p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <?php
                }
            } else {
                echo "No products found";
            }

            // Close result set
            $result->close();
            ?>
        </div>

    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>