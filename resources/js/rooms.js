$("#open-create").on("click", function(e) {
    e.preventDefault();
    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#create-section"));
    myModal.show();

})
$("#deleteSection").on("click", function(e) {
    let idTarget = e.currentTarget
    id = parseInt($(idTarget).attr("article_id"))
    Swal.fire({
        title: '¿Desea eliminar esta seccion?',
        text: "¡Esta accion es irreversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, seguro',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `/api/posts/delete-section/${id}`,
                success: function success(data) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire(
                        '¡Eliminado!',
                        'La seccion se ha eliminado con exito.',
                        'success'
                    )
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function error(error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al eliminar, intente mas tarde.',
                    })

                }
            });
        }
    })
})

$("#send-create").on("click", function(e) {
    e.preventDefault();
    let data = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        title: $("#create-title").val(),
        description: $("#description-create").val(),
        image: $('input[name=image]:checked').val(),
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
        if (!$('#filters select[name=groups] :selected').length &&
            !$('#filters select[name=delegations] :selected').length &&
            !$('#filters select[name=quartiles] :selected').length &&
            !$('#filters select[name=roles] :selected').length &&
            !$('#filters select[name=users] :selected').length
        ) {
            error = true;
            message.push('Debe seleccionar al menos un grupo objetivo');
        }
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
        // console.log(data);
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
    let id = $("#id").val();
    // console.log(id);
    let data = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        section: $("#id").val(),
        title: $("#title").val(),
        description: $("#description").val(),
        image: $('input[name=image]:checked').val(),
        groups: $('#filters2 select[name=groups]').val(),
        quartiles: $('#filters2 select[name=quartiles]').val(),
        delegations: $('#filters2 select[name=delegations]').val(),
        roles: $('#filters2 select[name=roles]').val(),
        users: $('#filters2 select[name=users]').val(),
    };
    // console.log(data);
    $.ajax({
        type: "PUT",
        url: `/api/posts/room/${id}`,
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