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

 $(document).ready(function () {
   $(".view-order").click(function () {
     var orderCode = $(this).data("order-code");
     // AJAX request to fetch order details using the order code
     $.ajax({
       url: "fetch_order_details.php",
       method: "POST",
       data: { orderCode: orderCode },
       success: function (response) {
         // Populate modal with the fetched order details
         var data = JSON.parse(response);
         $("#orderCode").val(data.orderCode);
         $("#customerName").val(data.customerName);
         $("#deliveryAddress").val(data.deliveryAddress);
         $("#deliveryDate").val(data.deliveryDate);
         // Populate table with item details
         var itemsHtml = "";
         $.each(data.items, function (index, item) {
           itemsHtml +=
             "<tr>" +
             "<td>" +
             (index + 1) +
             "</td>" +
             "<td>" +
             item.productName +
             "</td>" +
             "<td>" +
             item.unitPrice +
             "</td>" +
             "<td>" +
             item.quantity +
             "</td>" +
             "<td>" +
             item.totalPrice +
             "</td>" +
             "</tr>";
         });
         $("#itemTable tbody").html(itemsHtml);
         // Update grand total
         $("#grandTotal").text(data.grandTotal);
       },
     });
   });
 });
