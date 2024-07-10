<?php
include "includes/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bill Frozen</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>

</head>

<?php
$src = "\BILLFrozen/admin/";
?>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="home.php" class="logo d-flex align-items-center">
                <img src="assets/img/Bill-Frozen-Logo.png" alt="">
                <span class="d-none d-lg-block">Bill Frozen</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown">
                    <?php
                    // Fetch unread notifications
                    $userID = $_SESSION['user']['user_id'];
                    $notif_query = "SELECT `description`, `status`, `order_status`, `date_created` FROM notifications WHERE `user_id` = '$userID'";
                    $notif_result = mysqli_query($conn, $notif_query);

                    $unread_notifs = [];
                    $read_notifs = [];
                    if ($notif_result && mysqli_num_rows($notif_result) > 0) {
                        while ($notif_row = mysqli_fetch_assoc($notif_result)) {
                            if ($notif_row['status'] == 'unread') {
                                $unread_notifs[] = $notif_row;
                            } else {
                                $read_notifs[] = $notif_row;
                            }
                        }
                    }
                    $notifs_count = count($unread_notifs);
                    ?>

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                        <i class="bi bi-bell"></i>
                        <?php if ($notifs_count != 0) { ?>
                        <span class="badge bg-primary badge-number"><?= $notifs_count ?></span>
                        <?php } ?>
                    </a><!-- End Notification Icon -->


                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown">
                    <?php
                    // Fetch cart items count
                    $userID = $_SESSION['user']['user_id'];
                    $count_query = "SELECT COUNT(added_quantity) AS total_items FROM cart WHERE `user_id` = '$userID'";
                    $count_result = mysqli_query($conn, $count_query);

                    if ($count_result && mysqli_num_rows($count_result) > 0) {
                        $count_row = mysqli_fetch_assoc($count_result);
                        $total_items = $count_row['total_items'];
                    } else {
                        // Handle error or no items in cart
                        $total_items = 0;
                    }
                    ?>

                    <a class="nav-link nav-icon" href="cart.php">
                        <i class="bi bi-cart"></i>
                        <?php
                            if ($total_items != 0) {
                        ?>
                        <span class="badge bg-success badge-number"><?= $total_items ?></span>
                        <?php
                        }
                        ?>
                    </a><!-- End Messages Icon -->

                </li><!-- End Messages Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/user.png" alt="Profile" class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['user']['username']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <?php

                            echo "<h6>" . $_SESSION['user']['name'] . "</h6>";
                            echo "<span>" . $_SESSION['user']['email_phone'] . "</span>";

                            ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/BILLFrozen/logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'home.php') ? '' : 'collapsed' ?>" href="home.php">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
            </li><!-- End Home Nav -->

            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'cart.php') ? '' : 'collapsed' ?>" href="cart.php">
                    <i class="bi bi-cart3"></i>
                    <span>Cart</span>
                    <div class="mx-5 px-5">
                        <?php if ($total_items != 0) { ?>
                        <span class="badge bg-success rounded-pill mx-5">
                            <?= $total_items ?>
                        </span>
                        <?php } ?>
                    </div>
                </a>
            </li><!-- End Cart Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'notifications.php') ? '' : 'collapsed' ?>" href="#"
                    data-bs-toggle="modal" data-bs-target="#notificationsModal">
                    <i class="bi bi-bell"></i>
                    <span>Notifications</span>
                    <div class="mx-5 px-3">
                        <?php if ($notifs_count != 0) { ?>
                        <span class="badge bg-primary rounded-pill mx-3"><?= $notifs_count ?></span>
                        <?php } ?>
                    </div>
                </a>
            </li><!-- End Notifications Modal Nav -->

            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'my-order.php') ? '' : 'collapsed' ?>" href="my-order.php">
                    <i class="bi bi-bag-check"></i>
                    <span>My Orders</span>
                </a>
            </li><!-- End Orders Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->


    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($unread_notifs) || !empty($read_notifs)) { ?>
                    <ul class="list-group">
                        <?php
                    $current_date = '';
                    foreach (array_merge($unread_notifs, $read_notifs) as $notif) {
                        $notif_date = date('Y-m-d', strtotime($notif['date_created']));
                        if ($notif_date != $current_date) {
                            if ($current_date != '') {
                                echo '</ul>';
                            }
                            $current_date = $notif_date;
                            echo "<li class='list-group-item list-group-item-dark'><strong>Date: " . date('F j, Y', strtotime($notif_date)) . "</strong></li>";
                            echo '<ul class="list-group">';
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $notif['description'] ?>

                            <span
                                class="badge <?= ($notif['order_status'] == "Order Confirmed" ? "bg-primary" : "bg-danger") ?> rounded-pill"><?= $notif['order_status'] ?></span>

                        </li>
                        <?php
                    }
                    echo '</ul>';
                    ?>
                    </ul><!-- End Notifications List -->
                    <?php } else { ?>
                    <p>No notifications found.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div><!-- End Notifications Modal -->

    <script>
    document.getElementById('notificationsModal').addEventListener('shown.bs.modal', function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_notifications.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Notifications marked as read.");
            }
        };
        xhr.send("user_id=<?= $userID ?>");
    });
    </script>