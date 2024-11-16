<?php 
// Get the current script name without the file extension
$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard') ? '' : 'collapsed' ?>" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'orders') ? '' : 'collapsed' ?>" href="orders.php">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
                <div class="mx-5 px-4">
                    <?php if (isset($count) && $count != 0): ?>
                    <span class="badge bg-primary rounded-pill mx-5"><?= $count ?></span>
                    <?php endif; ?>
                </div>
            </a>
        </li><!-- End Orders Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'products') ? '' : 'collapsed' ?>" href="products.php">
                <i class="bi bi-basket2"></i>
                <span>Product List</span>
            </a>
        </li><!-- End Product List Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'inventory') ? '' : 'collapsed' ?>" href="inventory.php">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li><!-- End Inventory Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'user-registration') ? '' : 'collapsed' ?>"
                href="user-registration.php">
                <i class="bi bi-person-plus"></i>
                <span>User Registration</span>
            </a>
        </li><!-- End User Registration Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'reports') ? '' : 'collapsed' ?>" href="reports.php">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Reports Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'users') ? '' : 'collapsed' ?>" href="users.php">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li><!-- End Users Page Nav -->

    </ul>

</aside><!-- End Sidebar -->