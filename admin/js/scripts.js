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
            $("#productImagePreview").attr("src", response);
          } else {
            $("#productImagePreview").attr(
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
