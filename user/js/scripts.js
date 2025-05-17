document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".product-link").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const productId = link.getAttribute("data-product-id");

      $.ajax({
        url: `get_product_details.php`,
        type: "GET",
        data: {
          product_id: productId,
        },
        dataType: "json",
        success: (data) => {
          if (data.error) {
            console.error("Product error:", data.error);
            alert(data.error);
            return;
          }

          // Helper function to update product details
          function updateProductDetails(prefix, data) {
            // Update basic details
            document.getElementById(prefix + "Image").src =
              data.product_picture;
            document.getElementById(prefix + "ProductName").textContent =
              data.product_name;
            document.getElementById(prefix + "ProductNameInput").value =
              data.product_name;
            document.getElementById(prefix + "ProductCode").value =
              data.product_code;
            document.getElementById(prefix + "Price").textContent =
              "₱" + data.price;
            document.getElementById(prefix + "PriceRaw").value = data.price;
            document.getElementById(prefix + "Category").textContent =
              "Category: " + data.category;
            document.getElementById(prefix + "Desc").textContent =
              "Description: " + data.description;
            document.getElementById(prefix + "AvailableQty").textContent =
              "Qty: " + data.quantity;

            // Handle expiry date
            const expiryBadge = document.getElementById(prefix + "ExpiryBadge");
            const expiryDate = new Date(data.expiry_date);
            const today = new Date();
            const oneWeekFromNow = new Date();
            oneWeekFromNow.setDate(today.getDate() + 7);

            // Format the expiry date
            const options = { year: "numeric", month: "long", day: "numeric" };
            const formattedExpiryDate = expiryDate.toLocaleDateString(
              "en-US",
              options
            );

            // Reset previous classes
            expiryBadge.classList.remove(
              "bg-danger",
              "bg-warning",
              "bg-success"
            );

            // Set text and color based on expiry status
            if (expiryDate < today) {
              expiryBadge.textContent = "Expired (" + formattedExpiryDate + ")";
              expiryBadge.classList.add("bg-danger", "text-white");
            } else if (expiryDate <= oneWeekFromNow) {
              expiryBadge.textContent =
                "Expiring Soon (" + formattedExpiryDate + ")";
              expiryBadge.classList.add("bg-warning", "text-dark");
            } else {
              expiryBadge.textContent = "Expires on " + formattedExpiryDate;
              expiryBadge.classList.add("bg-success", "text-white");
            }

            // Add tooltip for the full expiry date
            document.getElementById(prefix + "ExpiryDate").title =
              "Expires on " + formattedExpiryDate;

            // After updating product details in updateProductDetails
            const qtyInput = document.querySelector(
              `#${prefix}Product .quantity`
            );
            if (qtyInput) {
              qtyInput.setAttribute("data-inventory", data.quantity);
              qtyInput.setAttribute("max", data.quantity);
            }
          }

          // Update modal content
          updateProductDetails("modal", data);

          // Update offcanvas content
          updateProductDetails("offcanvas", data);

          // Show modal or offcanvas based on screen size
          const targetElement =
            window.innerWidth >= 768 ? "modalProduct" : "offcanvasProduct";
          // const element = document.getElementById(targetElement);
          const instance = bootstrap[
            targetElement === "modalProduct" ? "Modal" : "Offcanvas"
          ].getOrCreateInstance(document.getElementById(targetElement));
          instance.show();
        },
        error: (xhr, status, error) => {
          console.error("AJAX error:", error);
          alert("Failed to load product details. Please try again later.");
        },
      });
    });
  });
});
