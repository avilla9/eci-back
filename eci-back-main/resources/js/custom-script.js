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

  /* let name = $('#InputName').val();
  let email = $('#InputEmail').val();
  let mobile = $('#InputMobile').val();
  let message = $('#InputMessage').val();

  $.ajax({
    url: "/usuarios/update",
    type: "PUT",
    data: {
      "_token": "{{ csrf_token() }}",
      name: name,
      email: email,
      mobile: mobile,
      message: message,
    },
    success: function (response) {
      $('#successMsg').show();
      console.log(response);
    },
    error: function (response) {
      $('#nameErrorMsg').text(response.responseJSON.errors.name);
      $('#emailErrorMsg').text(response.responseJSON.errors.email);
      $('#mobileErrorMsg').text(response.responseJSON.errors.mobile);
      $('#messageErrorMsg').text(response.responseJSON.errors.message);
    },
  }); */
});