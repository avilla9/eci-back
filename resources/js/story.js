$('input[name=select-all]').on("change", (function() {
    if ($('input[name=select-all]').is(":checked")) {
        $('#filters').addClass('hidden');
    } else {
        $('#filters').removeClass('hidden');
    }
}));

$('#save-story').on("click", (function(e) {
    e.preventDefault();
    let uploadDate = $('input[name=upload-date]').val();
    let uploadTime = $('input[name=upload-time]').val();
    var hours = uploadTime.split(":")[0];
    var minutes = uploadTime.split(":")[1];
    let tDate = new Date(uploadDate)
    tDate.setHours(hours);
    tDate.setMinutes(minutes);
    tDate.setSeconds(0);
    tDate.setMilliseconds(500);
    var year = tDate.getFullYear();
    var month = ("0" + (tDate.getMonth() + 1)).slice(-2);
    var day = ("0" + tDate.getDate()).slice(-2);
    var hour = ("0" + tDate.getHours()).slice(-2);
    var minutes = ("0" + tDate.getMinutes()).slice(-2);
    var seconds = ("0" + tDate.getSeconds()).slice(-2);
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
    if (tDate == "Invalid Date") {
        error = true;
        message.push('Debe asignar la hora de publicacion');
    }

    if (!$('input[name=select-all]').is(":checked")) {
        if (!$('#form-body select[name=groups]').val().length &&
            !$('#form-body select[name=delegations]').val().length &&
            !$('#form-body select[name=quartiles]').val().length &&
            !$('#form-body select[name=roles]').val().length &&
            !$('#form-body select[name=users]').val().length
        ) {
            error = true;
            message.push('Debe seleccionar al menos un grupo objetivo');
        }
    } else {
        data.grant_all = 1
    }

    if (!data.image) {
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
}));