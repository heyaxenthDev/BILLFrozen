$(document).ready(function () {
  // Email validation
  $("#resetEmail").keyup(function () {
    var email = $(this).val().trim();
    if (email !== "") {
      $.ajax({
        url: "check_email.php",
        method: "POST",
        data: {
          email: email,
        },
        success: function (response) {
          $("#email-status").html(response);
        },
      });
    } else {
      $("#email-status").html("");
    }
  });

  // Form submission and modal handling
  const resetCodeModal = document.getElementById("resetCodeModal");
  const resetCodeForm = document.getElementById("myForm");

  if (resetCodeModal && resetCodeForm) {
    const resetCodeModalInstance = new bootstrap.Modal(resetCodeModal);

    resetCodeForm.addEventListener("submit", function (event) {
      event.preventDefault();

      // Get the email value
      const email = document.getElementById("resetEmail").value;

      // Make AJAX call to send reset code
      $.ajax({
        url: "reset-password.php",
        method: "POST",
        data: {
          resetEmail: email,
          passwordReset: true,
        },
        success: function (response) {
          try {
            const result = JSON.parse(response);
            if (result.status === "success") {
              // Set the email in the modal form
              document.getElementById("modalResetEmail").value = email;
              // Show the modal
              resetCodeModalInstance.show();
            } else {
              // Show error message
              alert(result.message || "Error sending reset code");
            }
          } catch (e) {
            console.error("Error parsing response:", e);
            alert("Error processing server response");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error sending reset code:", error);
          alert("Error sending reset code. Please try again.");
        },
      });
    });
  }
});
