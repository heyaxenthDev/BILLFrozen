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
            <a class="nav-link collapsed" href="home.php">
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
            <a class="nav-link " href="my-order.php">
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

    <button class="btn btn-primary" type="button" id="toggleButton">Toggle right offcanvas</button>

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end w-100" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <a href="" data-bs-dismiss="offcanvas" aria-label="Close">
                <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="ri ri-arrow-left-s-line"></i>Category
                    Here</h5>
            </a>
        </div>
        <div class="offcanvas-body m-3">
            <img src="images/default-product-image.png" class="rounded mx-auto d-block img-thumbnail" alt="...">
            <div class="row">
                <div class="col-8">
                    <h1 class="canvas-title">Product Name</h1>
                </div>
                <div class="col-4 text-end canvas-title px-3">
                    <span class="badge text-bg-primary">Price</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-8 canvas-title">
                    <span class="mx-2">Quantity</span><br>
                </div>
                <div class="col-4 canvas-title px-3">
                    <div class="quantity-input">
                        <button class="btn btn-outline-warning decrement-btn">-</button>
                        <input type="number" class="form-control quantity" name="quantity" value="1">
                        <button class="btn btn-outline-warning increment-btn">+</button>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-3">
                <button class="btn w-100 text-white" type="button" style="background-color: #0f1b48;">Buy Now</button>
                <button class="btn w-100 text-white" type="button" style="background-color: #029bf1;">Add to
                    Cart</button>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="d-grid d-md-flex justify-content-md-end px-3 py-3">
                    <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3 pb-4">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="images/default-product-image.png" class="rounded mx-auto d-block img-thumbnail"
                                alt="...">
                        </div>

                        <div class="col-md-7">
                            <h1 class="modal-title">Product Name</h1>
                            <small>Category: Frozen Foods</small><br>
                            <h2 class="modal-title"><span class="badge text-bg-primary">Price</span></h2>

                            <div class="row">
                                <div class="col-8 modal-title">
                                    <span class="mx-3">Quantity</span><br>
                                </div>
                                <div class="col-4 modal-title px-3">
                                    <div class="quantity-input">
                                        <button class="btn btn-outline-warning decrement-btn">-</button>
                                        <input type="number" class="form-control quantity" name="quantity" value="1">
                                        <button class="btn btn-outline-warning increment-btn">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-2 mb-2">
                                <button class="btn w-100 text-white" type="button"
                                    style="background-color: #0f1b48;">Buy
                                    Now</button>
                                <button class="btn w-100 text-white" type="button"
                                    style="background-color: #029bf1;">Add
                                    to
                                    Cart</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>




</main><!-- End #main -->

<script>
let isOffcanvasOpen = false;
let isModalOpen = false;

// Function to toggle the offcanvas or modal based on screen width
function toggleOffcanvasOrModal() {
    const screenWidth = window.innerWidth;

    if (screenWidth <= 1199) {
        // Toggle offcanvas
        const offcanvas = new bootstrap.Offcanvas(
            document.getElementById("offcanvasRight")
        );
        isOffcanvasOpen = !isOffcanvasOpen;

        if (isOffcanvasOpen) {
            offcanvas.show();
        } else {
            offcanvas.hide();
        }
    } else {
        // Toggle modal
        const modal = new bootstrap.Modal(
            document.getElementById("staticBackdrop")
        );
        isModalOpen = !isModalOpen;

        if (isModalOpen) {
            modal.show();
        } else {
            modal.hide();
        }
    }
}

// Add click event listener to the button
document
    .getElementById("toggleButton")
    .addEventListener("click", toggleOffcanvasOrModal);

// Listen for the 'hidden.bs.offcanvas' event and reset the offcanvas state
document
    .getElementById("offcanvasRight")
    .addEventListener("hidden.bs.offcanvas", () => {
        isOffcanvasOpen = false;
    });

// Listen for the 'hidden.bs.modal' event and reset the modal state
document
    .getElementById("staticBackdrop")
    .addEventListener("hidden.bs.modal", () => {
        isModalOpen = false;
    });

// Listen for the window resize event
window.addEventListener("resize", () => {
    if (isOffcanvasOpen) {
        const offcanvas = new bootstrap.Offcanvas(
            document.getElementById("offcanvasRight")
        );
        offcanvas.hide();
        isOffcanvasOpen = false;
    }

    if (isModalOpen) {
        const modal = new bootstrap.Modal(
            document.getElementById("staticBackdrop")
        );
        modal.hide();
        isModalOpen = false;
    }
});

$(document).ready(function() {
    $(".increment-btn").click(function(e) {
        e.preventDefault();
        var quantityInput = $(this).siblings(".quantity");
        var currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
    });

    $(".decrement-btn").click(function(e) {
        e.preventDefault();
        var quantityInput = $(this).siblings(".quantity");
        var currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
        }
    });
});
</script>

<?php
include 'includes/footer.php';
?>