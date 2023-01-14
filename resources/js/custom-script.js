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

$('#togglePassword-check').on("click", function (e) {
  e.preventDefault();
  let type = $("#password-check").attr("type") === "password" ? "text" : "password";
  $("#password-check").attr("type", type);

  if (type !== "password") {
    $('#open-check').css('display', 'block');
    $('#closed-check').css('display', 'none');
  } else {
    $('#closed-check').css('display', 'block');
    $('#open-check').css('display', 'none');
  }
});