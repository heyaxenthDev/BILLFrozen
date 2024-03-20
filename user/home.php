<?php
include 'authentication.php';
include_once 'includes/header.php';

include "includes/conn.php";

include "alert.php";

?>
<script src="js/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['logged'])) {
    ?>
<script type="text/javascript">
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

Toast.fire({
    background: '#53a653',
    color: '#fff',
    icon: '<?php echo $_SESSION['logged_icon']; ?>',
    title: '<?php echo $_SESSION['logged']; ?>'
});
</script>
<?php
unset($_SESSION['logged']);
}
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="home.php">
                <i class="bi bi-house"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="cart.php">
                <i class="bi bi-cart3"></i>
                <span>Cart</span>
            </a>
        </li><!-- End Cart Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li><!-- End Inventory Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="my-order.php">
                <i class="bi bi-bag-check"></i>
                <span>My Orders</span>
            </a>
        </li><!-- End Orders Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <section class="p-3">
        <div class="row">
            <div class="col-lg-9 mb-3">
                <div class="pagetitle mb-3">
                    <div class="row">

                        <div class="col-md-6 mb-2 ">
                            <h1>Product List</h1>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="gap-2 d-md-flex justify-content-md-end">
                                <div class="search-bar">
                                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                                        <input type="text" name="query" placeholder="Search"
                                            title="Enter search keyword">
                                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                                    </form>
                                </div><!-- End Search Bar -->
                            </div>
                        </div>

                    </div>
                </div><!-- End Page Title -->
                <hr>
                <!-- Additional content for the product list -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="d-grid gap-2 d-flex justify-content-end">
                        <button class="btn btn-primary" type="button">See More <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                </div><!-- row end -->
            </div>

            <!-- Best sellers -->
            <div class="col-lg-3">

                <h4 class="fw-semibold">Best Sellers</h4>

                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 col-4">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                        </div>
                        <div class="col-md-8 col-8">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>



</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>