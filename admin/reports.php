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
            <a class="nav-link " href="reports.php">
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
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>