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

$("#deleteUserId").on("click", function () {
  Swal.fire({
    title: "¿Desea eliminar estos usuarios?",
    text: "Esta accion es irreversible!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: 'No, cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $(".checkElement:checked").each(function (index) {
        fetch("/api/users/delete", {
          method: "POST",
          headers: {
            "Content-type": "application/json;charset=UTF-8",
          },
          body: JSON.stringify({
            id: $(this).attr("itemId"),
          }),
        }).then(function (response) {
          if (response) {
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            throw "Error en la llamada Ajax";
          }
        });
      });
    }
  });
});


$("#checkAllUsers").on("click", (function () {
  let checked = $('input:checkbox').is(':checked');
  $('input:checkbox').not(this).prop('checked', !checked);
}));
