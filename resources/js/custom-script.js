import { each } from "jquery";

$('#togglePassword').on("click", function (e) {
  e.preventDefault();
  let type = $("#password").attr("type") === "password" ? "text" : "password";
  $("#password").attr("type", type);

  if (type !== "password") {
    $('.open').css('display', 'block');
    $('.closed').css('display', 'none');
  } else {
    $('.closed').css('display', 'block');
    $('.open').css('display', 'none');
  }
});

$("#checkAllUsers").on("change", (function (event) {
  event.preventDefault();
  if (this.checked) {
    $('.checkElement:checkbox').attr('checked', 'checked');
  } else {
    $('.checkElement:checkbox').removeAttr('checked');
  }
}));
