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

    <div class="pagetitle mb-3">
        <h1></h1>
    </div><!-- End Page Title -->

    <section class="card p-3">
        <div class="row">
            <div class="col-lg-3">
                <div class="accordion mb-3 mt-3" id="categoriesAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="categoriesHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#categoriesCollapse" aria-expanded="true"
                                aria-controls="categoriesCollapse">
                                Categories
                            </button>
                        </h2>
                        <div id="categoriesCollapse" class="accordion-collapse collapse show"
                            aria-labelledby="categoriesHeading" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="frozenFoodsCheck">
                                    <label class="form-check-label" for="frozenFoodsCheck">
                                        Frozen Foods
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="streetFoodsCheck">
                                    <label class="form-check-label" for="streetFoodsCheck">
                                        Street Foods
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="dressedChickenCheck">
                                    <label class="form-check-label" for="dressedChickenCheck">
                                        Dressed Chicken
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3" id="availabilityAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="availabilityHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#availabilityCollapse" aria-expanded="true"
                                aria-controls="availabilityCollapse">
                                Availability
                            </button>
                        </h2>
                        <div id="availabilityCollapse" class="accordion-collapse collapse show"
                            aria-labelledby="availabilityHeading" data-bs-parent="#availabilityAccordion">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="inStockCheck">
                                    <label class="form-check-label" for="inStockCheck">
                                        In Stock
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="outOfStockCheck">
                                    <label class="form-check-label" for="outOfStockCheck">
                                        Out of Stock
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <h4 class="">Best Sellers</h4>
                <a href="#">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4 align-content-md">
                                <img src="images\default-product-image.png" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title">Product 1</h6>
                                    <span class="card-text">Lorem Ipsum</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-9">
                <div class="row mt-3">
                    <div class="col-8">
                        <h3>Product List <small>(123)</small></h3>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                                aria-describedby="searchButton">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Additional content for the product list -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <img src="images\default-product-image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card with an image on top</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1 <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>


        </div>
    </section>



</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>