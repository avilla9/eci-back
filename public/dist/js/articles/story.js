$('input[name=select-all]').change(function () {
  if ($('input[name=select-all]').is(":checked")) {
    $('#filters').addClass('hidden');
  } else {
    $('#filters').removeClass('hidden');
  }
});

$('#save').click(function (e) {
  e.preventDefault();

  var d = new Date($('#form-body input[name=upload-date]').val())
  var year = d.getFullYear();
  var month = ("0" + (d.getMonth() + 1)).slice(-2);
  var day = ("0" + d.getDate()).slice(-2);
  var hour = ("0" + d.getHours()).slice(-2);
  var minutes = ("0" + d.getMinutes()).slice(-2);
  var seconds = ("0" + d.getSeconds()).slice(-2);
  let timestamp = year + "-" + month + "-" + day + " " + hour + ":" + minutes + ":" + seconds;

  let data = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    button_name: $('input[name=button_name]').val(),
    button_link: $('input[name=button_link]').val(),
    image: $('input[name=image]:checked').val(),
    date: timestamp,
    groups: $('#form-body select[name=groups]').val(),
    quartiles: $('#form-body select[name=quartiles]').val(),
    delegations: $('#form-body select[name=delegations]').val(),
    roles: $('#form-body select[name=roles]').val(),
    users: $('#form-body select[name=users]').val(),
    grant_all: $('input[name=select-all]:checked').is(':checked') ? 1 : 0,
  };

  $('#alert').html();
  $('#alert').removeClass();
  let error = false;
  let message = [];

  if (data.button_link.length) {
    console.log(data.button_name);
    if (!data.button_name.length) {
      error = true;
      message.push('Debe añadir un nombre para el CTA');
    }
  } else if (data.button_name.length) {
    error = true;
    message.push('Debe añadir un link para el CTA o borrar el CTA');
  }

  if (!$('input[name=select-all]').is(":checked")) {
    if (
      !$('#form-body select[name=groups]').val().length
      && !$('#form-body select[name=delegations]').val().length
      && !$('#form-body select[name=quartiles]').val().length
      && !$('#form-body select[name=roles]').val().length
      && !$('#form-body select[name=users]').val().length
    ) {
      error = true;
      message.push('Debe seleccionar al menos un grupo objetivo');
    }
  } else {
    data.grant_all = 1
  }

  if (!data.image?.length) {
    error = true;
    message.push('Debe seleccionar una imagen');
  }

  if (error) {
    $('#alert').html();
    $('#alert').removeClass();
    $('#alert').addClass('alert alert-danger show mb-2');
    let value = '';
    for (var i = 0; i < message.length; i++) {
      value += message[i];
      if (i + 1 != message.length) {
        value += '<br>';
      }
    }
    $('#alert').html(value);
  } else {
    console.log(data);

    $.ajax({
      type: "POST",
      url: '/posts/stories/create',
      data: data,
      success: function success(data) {
        console.log('success', data);

        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-success show mb-2');
        $('#alert').html('Post creado con éxito');
      },
      error: function error(_error) {
        

        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error al crear el Post');
      }
    });
  }
});