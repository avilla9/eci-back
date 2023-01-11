$('#SubmitForm').on('submit', function (e) {
  e.preventDefault();

  let data = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    dni: $('#dni').val(),
    name: $('#name').val(),
    gender: $('#female').is(':checked') ? 'f' : 'm',
    email: $('#email').val(),
    territorial: $('#territorial').val(),
    secicoins: $('#secicoins').val(),
    password: $('#password').val(),
    role_id: $('#role_id').val(),
    delegation_id: $('#delegation_id').val(),
    group_id: $('#group_id').val(),
    quartile_id: $('#quartile_id').val(),
  };

  console.log(data);

  $.ajax({
    type: "PUT",
    url: '/usuarios/update',
    data: data,
    success: function (data) {
      console.log('success', data);
    },
    error: function (error) {
      console.log('error', error);
    },
  });
});

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


+$("#deleteUserId").on("click", function () {
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
              console.log($(this).attr("itemId"));
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
                      console.log(response);
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