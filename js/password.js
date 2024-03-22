//  Show Password Login

$("#yourPassword").on("keyup", function () {
  var input = $(this).val();
  let element = document.getElementById("icon");
  element.hidden = input === "";
});

document
  .querySelector(".toggle-password")
  .addEventListener("click", function (e) {
    const password = document.querySelector("#yourPassword");
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.classList.toggle("bi-eye-slash-fill");
  });
