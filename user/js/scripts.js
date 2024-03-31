$(document).ready(function () {
  $(".increment-btn").click(function (e) {
    e.preventDefault();
    var quantityInput = $(this).siblings(".quantity");
    var currentValue = parseInt(quantityInput.val());
    quantityInput.val(currentValue + 1);
  });

  $(".decrement-btn").click(function (e) {
    e.preventDefault();
    var quantityInput = $(this).siblings(".quantity");
    var currentValue = parseInt(quantityInput.val());
    if (currentValue > 1) {
      quantityInput.val(currentValue - 1);
    }
  });

  const productLinks = document.querySelectorAll(".product-link");

  function updateAttributes() {
    const screenWidth = window.innerWidth;
    if (productLinks) {
      productLinks.forEach((product) => {
        if (screenWidth <= 530) {
          product.setAttribute("data-bs-toggle", "offcanvas");
          product.setAttribute("data-bs-target", "#offcanvasProduct");
          product.setAttribute("aria-controls", "offcanvasProduct");
          product.setAttribute("href", "#offcanvasProduct");
          product.setAttribute("role", "button");
        } else {
          product.setAttribute("data-bs-toggle", "modal");
          product.setAttribute("data-bs-target", "#modalProduct");
          product.setAttribute("aria-controls", "modalProduct");
          product.setAttribute("href", "#modalProduct");
          product.setAttribute("role", "button");
        }
      });
    }
  }

  // Initial call to set attributes based on initial screen width
  updateAttributes();

  // Listen for resize events to update attributes when screen width changes
  window.addEventListener("resize", updateAttributes);

  productLinks.forEach((product) => {
    product.addEventListener("click", function (event) {
      event.preventDefault();
      const productCode = product.getAttribute("data-product-id");
      fetchProductDetails(productCode);
    });
  });

  function fetchProductDetails(productCode) {
    // Perform AJAX request to fetch product details
    $.ajax({
      url: "get_product_details.php",
      type: "POST",
      data: { productCode: productCode },
      success: function (response) {
        const product = JSON.parse(response);
        populateModal(product);
        populateOffcanvas(product);
        // $("#modalProduct").modal("show");
      },
      error: function () {
        alert("Failed to fetch product details.");
      },
    });
  }

  function populateModal(product) {
    $("#modalImage").attr(
      "src",
      "\\BillFrozen\\admin\\" + product.product_picture
    );
    $("#modalProductName").text(product.product_name);
    $("#modProductName").val(product.product_name);
    $("#productCode").val(product.product_code);
    $("#modalCategory").text("Category: " + product.category);
    $("#modalPrice").text("₱" + product.price);
    $("#modalQuantity").text("Quantity: " + product.quantity);
  }

  function populateOffcanvas(product) {
    $("#offcanvasImage").attr(
      "src",
      "\\BillFrozen\\admin\\" + product.product_picture
    );
    $("#offcanvasProductName").text(product.product_name);
    $("#offProductName").val(product.product_name);
    $("#offproductCode").val(product.product_code);
    $("#offcanvasCategory").html(
      "<i class='ri ri-arrow-left-s-line'></i>" + product.category
    );
    $("#offcanvasPrice").text("₱" + product.price);
    $("#offcanvasQuantity").text("Quantity: " + product.quantity);
  }
});


