$('#editArticle').on("click", function(e) {
    e.preventDefault();
    let idTarget = e.currentTarget
    id = parseInt($(idTarget).attr("article_id"))
    $.ajax({
        type: "GET",
        url: `/api/posts/room/${id}`,
        success: function success(data) {
            $("#id").val(data[0].id)
            $("#title").val(data[0].title)
            $("#description").val(data[0].description)
            $('input[name=image]').each(function() {
                if ($(this).val() == data[0].file_id) {
                    $(this).attr("checked", "true")
                }
            })
            const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#edit-section"));
            myModal.show()
        },
        error: function error(_error) {
            console.log(_error.responseJSON.message);
            // console.log(error);
            let errors = _error.responseJSON.message;

            if (errors === undefined) {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html('Ha ocurrido un error al consultar la seccion');

            } else {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html(errors);
            }
            setTimeout(function() {
                $('#alert').fadeOut(4000);
            }, 2000);

        }
    });
});

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
    console.log(data);
    $.ajax({
        type: "POST",
        url: '/api/posts/room/creation',
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
                // location.reload();
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