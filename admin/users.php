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
            <a class="nav-link " href="users.php">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li><!-- End Reports Page Nav -->


    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User List</h5>
                        <!-- User Table -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Email or Phone Number</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Password</th>
                                    <!-- <th scope="col">Profile Picture</th> -->
                                    <th scope="col">Date Created</th>
                                    <!-- <th scope="col">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch data from the users table
                                $query = "SELECT * FROM `users`";
                                $result = mysqli_query($conn, $query);

                                // Loop through the results and create table rows
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$row['id']}</th>";
                                    echo "<td>{$row['user_id']}</td>";
                                    echo "<td>{$row['email_or_phone_number']}</td>";
                                    echo "<td>{$row['full_name']}</td>";
                                    echo "<td>{$row['username']}</td>";
                                    echo "<td>{$row['password']}</td>";
                                    // echo "<td><img src='{$row['profile_picture']}' style='max-width: 100px; max-height: 65px;' alt='Profile Picture'></td>";
                                    echo "<td>{$row['date_created']}</td>";
                                    // echo "<td>";
                                    // echo "<a class='btn btn-success mx-2'><i class='bi bi-pencil-square'></i></a>";
                                    // echo "<a class='btn btn-danger'><i class='bi bi-trash'></i></a>";
                                    // echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End User Table -->
                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>