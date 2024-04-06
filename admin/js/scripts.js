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

document.querySelectorAll(".cart").forEach((item) => {
  item.addEventListener("click", function (e) {
    e.preventDefault();
    const productCode = this.getAttribute("data-product-code");

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        // Send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                showConfirmButton: false, // Prevents the user from closing the alert manually
                timer: 1500, // Show the alert for 1.5 seconds
              }).then(() => {
                // Reload page after the alert is closed
                location.reload();
              });
            } else {
              Swal.fire({
                title: "Error!",
                text: "Failed to delete item.",
                icon: "error",
              });
            }
          }
        };
        xhr.open("POST", "delete_cart_item.php");
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xhr.send(`product_code=${productCode}`);
      }
    });
  });
});
