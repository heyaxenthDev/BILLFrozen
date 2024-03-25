// Function to preview the selected product image
function previewProductImage() {
  var fileInput = document.getElementById("productImage");
  var file = fileInput.files[0];
  var reader = new FileReader();

  // Set up the onload event handler for the FileReader
  reader.onload = function (e) {
    var preview = document.getElementById("productImagePreview");
    preview.src = e.target.result;
  };

  // Read the selected file as a data URL
  reader.readAsDataURL(file);
}

$(document).ready(function () {
  $("#product_name").change(function () {
    var productId = $(this).val();
    if (productId) {
      $.ajax({
        url: "get_product_image.php",
        type: "post",
        data: { id: productId },
        success: function (response) {
          if (response) {
            $("#productPreview").attr("src", response);
          } else {
            $("#productPreview").attr(
              "src",
              "images/default-product-image.png"
            );
          }
        },
      });
    } else {
      $("#productImagePreview").attr("src", "images/default-product-image.png");
    }
  });
});

// JavaScript code for showing product details in offcanvas
$(document).ready(function () {
  $(".product-card").click(function (e) {
    e.preventDefault();

    var productName = $(this).data("product-name");
    var category = $(this).data("category");
    var price = $(this).data("price");
    var quantity = $(this).data("quantity");
    var productPicture = $(this).data("product-picture");

    var html = `
            <img src="${productPicture}" class="img-fluid mb-2" alt="${productName}">
            <h5>${productName}</h5>
            <p>Category: ${category}</p>
            <p>Price: ${price}</p>
            <p>Quantity: ${quantity}</p>
        `;

    $(".product-details-container").html(html);
    $("#productDetailsOffcanvas").offcanvas("show");
  });

  $(".add-to-cart-btn").click(function () {
    var productName = $(".product-details-container h5").text();
    var price = $('.product-details-container p:contains("Price")')
      .text()
      .split(": ")[1];
    // Perform your add to cart logic here
    console.log("Added to cart:", productName, price);
    // Close the offcanvas
    $("#productDetailsOffcanvas").offcanvas("hide");
  });
});
