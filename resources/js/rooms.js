$("#open-create").on("click", function(e) {
    e.preventDefault();
    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#create-section"));
    myModal.show();
})

$("#send-create").on("click", function(e) {
    e.preventDefault();
    var d = new Date($('#create-section input[name=create-date]').val())
    var year = d.getFullYear();
    var month = ("0" + (d.getMonth() + 1)).slice(-2);
    var day = ("0" + d.getDate()).slice(-2);
    var hour = ("0" + d.getHours()).slice(-2);
    var minutes = ("0" + d.getMinutes()).slice(-2);
    var seconds = ("0" + d.getSeconds()).slice(-2);
    let timestamp = year + "-" + month + "-" + day + " " + hour + ":" + minutes + ":" + seconds;
    let data = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        title: $("#create-title").val(),
        description: $("#description-create").val(),
        image: $('input[name=image]:checked').val(),
        date: timestamp,
        groups: $('#filters select[name=groups]').val(),
        quartiles: $('#filters select[name=quartiles]').val(),
        delegations: $('#filters select[name=delegations]').val(),
        roles: $('#filters select[name=roles]').val(),
        users: $('#filters select[name=users]').val(),
        page_id: $('#pageId').val(),
        // grant_all: $('input[name=select-all]:checked').is(':checked') ? 1 : 0,
    };
    // console.log(data);
    $('#alert2').html();
    $('#alert2').removeClass();
    let error = false;
    let message = [];
    if (!$('input[name=select-all]').is(":checked")) {
        if (!$('#form-body select[name=groups]').val() &&
            !$('#form-body select[name=delegations]').val() &&
            !$('#form-body select[name=quartiles]').val() &&
            !$('#form-body select[name=roles]').val() &&
            !$('#form-body select[name=users]').val()
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

    if (!data.title) {
        error = true;
        message.push('Debe añadir un título');
    }

    if (!data.description) {
        error = true;
        message.push('Debe añadir una descripción corta');
    }

    if (error) {
        $('#alert2').html();
        $('#alert2').removeClass();
        $('#alert2').addClass('alert alert-danger show mb-2');
        let value = '';
        for (var i = 0; i < message.length; i++) {
            value += message[i];
            if (i + 1 != message.length) {
                value += '<br>';
            }
        }
        $('#alert2').fadeIn(500)
        $('#alert2').html(value);

    } else {
        console.log(data);
        $('#alert2').html(" ");
        $.ajax({
            type: "POST",
            url: '/api/posts/room/creation',
            data: data,
            success: function success(data) {
                console.log(data)

                $('#alertCreateSuccess').css({
                    'display': 'flex',
                    'align-items': 'center',
                    'justify-content': 'center'
                });
                setTimeout(function() {
                    $('#alertCreateSuccess').fadeOut(2000);
                    location.reload();
                }, 2000);
            },
            error: function error(error) {
                console.log(error);
                $('#alertCreateFailed').css({
                    'display': 'flex',
                    'align-items': 'center',
                    'justify-content': 'center'
                });
                $("#alertCreateFailed").html(error.responseJSON.message);
            }
        });
    }

})


$("#updateSection").on("click", function(e) {
    e.preventDefault();
    let data = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        section: $("#id").val(),
        title: $("#title").val(),
        description: $("#description").val(),
        image: $('input[name=image]:checked').val(),
    };
    console.log(data);
    $.ajax({
        type: "PUT",
        url: `/api/posts/room/create`,
        data: data,
        success: function success(data) {
            // console.log('success', data)
            $('#alertUpdateSuccess').css({
                'display': 'flex',
                'align-items': 'center',
                'justify-content': 'center'
            });
            setTimeout(function() {
                $('#alertUpdateSuccess').fadeOut(4000);
                location.reload();
            }, 1500);
        },
        error: function error(error) {
            console.log(error);
            $('#alertUpdateFailed').css({
                'display': 'flex',
                'align-items': 'center',
                'justify-content': 'center'
            });
            $("#alertUpdateFailed").html(error.message);
        }
    });
})