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
            <div class="col-6 d-grid gap-2 d-md-block">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Search Product...">
            </div>
            <div class="col-6 d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-success" type="button">
                    <i class="bi bi-cart-plus-fill"></i> Add Product</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/SM3012-4.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/funtastyk-young-pork-tocino-flatpack-225g_1.jpg" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg" class=" card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/Purefoods-Tender-Juicy.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/39.-CDO-Ulam-Burger-Regular-Patties-228g.jpg" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
            <div class="col-lg-2">
                <!-- Product Card -->
                <div class="card">
                    <img src="images/products/5951-003-20-2023-140350-685.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title">Product Card</h6>
                        <p class="card-text">Price</p>
                        <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary" type="button">Edit</button>
                            <button class="btn btn-danger" type="button">Delete</button>
                        </div>
                    </div>
                </div><!-- End Product Card -->
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>