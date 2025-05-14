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
            <div class="col-lg-3 col-10 d-grid gap-2 d-md-block">
                <form method="POST" class="d-flex" id="subAdminProductSearchForm">
                    <input type="text" class="form-control" name="query" id="subAdminProductSearchInput"
                        placeholder="Search Product..." autocomplete="off">
                    <!-- <button type="submit" class="btn btn-primary ms-2">Search</button> -->
                </form>
            </div>
            <div class="col-lg-9 col-2 d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#productList">
                    <i class="bi bi-cart-plus-fill"></i>
                    <span class="d-none d-md-inline">Add Product</span>
            </div>
        </div>

        <!-- Add Product Modal -->
        <div class="modal fade" id="productList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="productListLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <!-- Product Image Preview -->
                                    <center>
                                        <img id="productImagePreview" src="images/default-product-image.png"
                                            alt="Product Image Preview" style="max-width: 100%; max-height: 300px;">
                                    </center>
                                    <!-- Product Image Input -->
                                    <small class="mt-2">Add Product Image</small>
                                    <input type="file" name="productImage" class="form-control mb-3" id="productImage"
                                        onchange="previewProductImage();" accept="image/*" required>
                                </div>
                                <div class="col-lg-6 col-md-12">
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
                                    <div class="mb-3">
                                        <label for="editProductDesc" clasys="form-label">Description
                                            <small>(Optional)</small></label>
                                        <textarea type="text" class="form-control" id="editProductDesc"
                                            name="ProductDesc" required></textarea>
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

        <div class="row" id="productListContainer">
            <?php
            // Query to fetch data from product_list table
            $search = '';
            if (isset($_POST['query']) && !empty(trim($_POST['query']))) {
                $search = trim($_POST['query']);
                $query = "SELECT * FROM `product_list` WHERE product_name LIKE ? OR category LIKE ?";
                $stmt = $conn->prepare($query);
                $like = "%$search%";
                $stmt->bind_param("ss", $like, $like);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $query = "SELECT * FROM `product_list`";
                $result = $conn->query($query);
            }

            // Check if there are any rows in the result
            if ($result->num_rows > 0) {
                // Loop through each row
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-lg-2 col-6">
                <!-- Product Card -->
                <div class="card">
                    <img src="<?php echo $row['product_picture']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo $row['product_name']; ?></h6>
                        <p class="card-text fw-semibold">₱<?php echo $row['price']; ?></p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="submit" name="editProduct" data-bs-toggle="modal"
                                data-bs-target="#editProductModal" data-product-id="<?php echo $row['id']; ?>"
                                data-product-name="<?php echo $row['product_name']; ?>"
                                data-product-price="<?php echo $row['price']; ?>"
                                data-product-category="<?php echo $row['category']; ?>"
                                data-product-description="<?php echo $row['description']; ?>"
                                data-product-picture="<?php echo $row['product_picture']; ?> ">Edit</button>
                            <a class="btn btn-danger del" data-product-idDel="<?php echo $row['id']; ?>">Delete</a>
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

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel"><i
                                class="bi bi-pencil-square text-primary"></i>
                            Edit
                            Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing product details -->
                        <form id="editProductForm" method="POST" action="code.php">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <img src="" alt="product image" class="img-fluid rounded" id="product_pic"
                                            name="product_pic">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="editProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="editProductName"
                                            name="editProductName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductPrice" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="editProductPrice"
                                            name="editProductPrice" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductCategory" clasys="form-label">Category</label>
                                        <input type="text" class="form-control" id="editProductCategory"
                                            name="editProductCategory" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="editProductDesc" clasys="form-label">Description
                                            <small>(Optional)</small></label>
                                        <textarea type="text" class="form-control" id="editProductDesc"
                                            name="editProductDesc" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="editProductId" name="editProductId">
                                <button type="submit" class="btn btn-primary" name="editProduct">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var editProductModal = document.getElementById('editProductModal');
        editProductModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var productId = button.getAttribute('data-product-id');
            var productPic = button.getAttribute('data-product-picture');
            var productName = button.getAttribute('data-product-name');
            var productPrice = button.getAttribute('data-product-price');
            var productCategory = button.getAttribute('data-product-category');
            var productDesc = button.getAttribute('data-product-description');

            // Populate the form fields with the product details
            var form = document.getElementById('editProductForm');
            form['editProductId'].value = productId;
            form['product_pic'].src = productPic; // Set the src attribute of the image
            form['editProductName'].value = productName;
            form['editProductPrice'].value = productPrice;
            form['editProductCategory'].value = productCategory;
            form['editProductDesc'].value = productDesc;
        });
    });

    document.querySelectorAll(".del").forEach((item) => {
        item.addEventListener("click", function(e) {
            e.preventDefault();
            const productID = this.getAttribute("data-product-idDel");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Product has been deleted.",
                                    icon: "warning",
                                    showConfirmButton: false, // Prevents the user from closing the alert manually
                                    timer: 1500 // Show the alert for 1.5 seconds
                                }).then(() => {
                                    // Reload page after the alert is closed
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete item.",
                                    icon: "error"
                                });
                            }


                        }
                    };
                    xhr.open("POST", "delete_product_item.php");
                    xhr.setRequestHeader(
                        "Content-Type",
                        "application/x-www-form-urlencoded"
                    );
                    xhr.send(`id=${productID}`);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('subAdminProductSearchInput');
        const productListContainer = document.getElementById('productListContainer');
        let timer;
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                const query = searchInput.value;
                fetch('search_subadmin_products.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'query=' + encodeURIComponent(query)
                    })
                    .then(response => response.text())
                    .then(html => {
                        productListContainer.innerHTML = html;
                    });
            }, 300);
        });
        // Prevent form submit
        document.getElementById('subAdminProductSearchForm').addEventListener('submit', function(e) {
            e.preventDefault();
        });
    });
    </script>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>