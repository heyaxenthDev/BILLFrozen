document.addEventListener("DOMContentLoaded", function () {
  var viewOrderButtons = document.querySelectorAll(".view-order-btn");

  viewOrderButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var orderCode = this.getAttribute("data-order-code");
      fetchOrderInformation(orderCode);
    });
  });

  function fetchOrderInformation(orderCode) {
    fetch("fetch_order_details.php", {
      method: "POST",
      body: JSON.stringify({
        order_code: orderCode,
      }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        var orderStatusElement = document.getElementById("orderStatus");
        var status = data.order_status;
        var badgeClass = "";

        switch (status) {
          case "Pending":
            badgeClass = "badge bg-warning";
            break;
          case "for delivery":
            badgeClass = "badge bg-primary";
            break;
          case "Delivered":
            badgeClass = "badge bg-info";
            break;
          default:
            badgeClass = "badge bg-secondary";
            break;
        }

        orderStatusElement.innerHTML = `<span class="${badgeClass}">${status}</span>`;

        var statusElement = document.getElementById("Status");

        var confirmBtn = document.querySelector('[name="confirmBtn"]');
        var declineBtn = document.querySelector('[name="declineBtn"]');

        // Assuming data.order_status contains the order status
        if (data.order_status !== "Pending") {
          confirmBtn.style.display = "none";
          declineBtn.style.display = "none";
        } else {
          confirmBtn.style.display = "inline-block"; // or 'block' based on your styling
          declineBtn.style.display = "inline-block"; // or 'block' based on your styling
        }

        statusElement.value = data.order_status;
        document.getElementById("userID").value = data.user_id;
        document.getElementById("orderCode").value = data.order_code;
        document.getElementById("customerName").value = data.name;
        document.getElementById("customerContact").value = data.contact;
        document.getElementById("deliveryAddress").value =
          data.delivery_address;
        document.getElementById("deliveryDate").value = data.delivery_date =
          null ? "Order Declined" : data.delivery_date;

        var orderItemsTableBody = document.getElementById(
          "orderItemsTableBody"
        );
        orderItemsTableBody.innerHTML = "";

        data.items.forEach(function (item, index) {
          var unitPrice = item.total_price / item.quantity;
          var formattedUnitPrice = unitPrice.toLocaleString("en-PH", {
            style: "currency",
            currency: "PHP",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          });

          var row = `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.product_name}</td>
                            <td>${formattedUnitPrice}</td>
                            <td>${item.quantity}</td>
                            <td>₱${item.total_price}</td>
                        </tr>
                    `;
          orderItemsTableBody.innerHTML += row;
        });

        document.getElementById("grandTotalPrice").textContent =
          "₱" + data.grand_total;
      })
      .catch((error) => console.error("Error:", error));
  }
});

$(document).ready(function () {
  $("#deliveryDate").change(function () {
    let status = $("#Status").val().trim(); // Get the order status

    if (status === "For Delivery") {
      $("#saveChangeBtn").css("display", "inline-block"); // Show the button
      $("#deliveryDate").removeAttr("readonly"); // Allow editing
    } else {
      $("#saveChangeBtn").css("display", "none"); // Hide button
      $("#deliveryDate").attr("readonly", true); // Make it readonly
    }
  });
});

function printOrderModal() {
  var modalContent = document
    .querySelector("#ViewModal .modal-body")
    .cloneNode(true);

  // Remove input borders & keep only the values
  modalContent.querySelectorAll("input, select").forEach((input) => {
    var span = document.createElement("span");
    span.textContent = input.value || input.innerText;
    input.parentNode.replaceChild(span, input);
  });

  // Open a new print window
  var printWindow = window.open("", "", "width=900,height=600");

  printWindow.document.write(`
  <html>
  <head>
      <title>Order Details</title>
      <style>
          body { font-family: Arial, sans-serif; padding: 20px; }
          .modal-body { font-size: 14px; }
          table { width: 100%; border-collapse: collapse; margin-top: 10px; }
          th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
          th { background-color: #f4f4f4; }
          h2 { text-align: center; margin-bottom: 20px; }
          input, select, button { display: none; } /* Hide input fields & buttons */
          .row { display: flex; margin-bottom: 5px; }
          .col-sm-3 { font-weight: bold; width: 30%; }
          .col-sm-9 { width: 70%; }
          @media print {
     @page {
        margin-left: 0.5in;
        margin-right: 0.5in;
        margin-top: 0;
        margin-bottom: 0;
      }
}
      </style>
  </head>
  <body>
      <h2>Order Details</h2>
      ${modalContent.innerHTML}
  </body>
  </html>
`);

  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}
