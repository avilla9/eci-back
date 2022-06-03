import Dropzone from "dropzone";

(function () {
    "use strict";

    if ($("#upload-users").length) {
        // Dropzone
        Dropzone.autoDiscover = false;
        $(".dropzone").each(function () {
            let options = {
                accept: (file, done) => {
                    console.log("Uploaded");
                    done();
                },
                success: function (file, response) {
                    console.log(response);
                    $('#alert').innerHTML = '';
                    if (typeof (response) === 'string') {
                        $('#alert').append('<div class="alert alert-success">' + response + '</div>');
                    } else {
                        $('#alert').append('<div class="alert alert-danger">Error al insertar algunos usuarios</div>');
                        let table = '<div class="intro-y col-span-12 lg:col-span-6 mt-5"><div class="intro-y box"><div class="p-5" id="head-options-table"><div class="preview"><div class="overflow-x-auto"><table class="table"><thead><tr><th class="whitespace-nowrap">Fila</th><th class="whitespace-nowrap">Columna</th><th class="whitespace-nowrap">Usuario</th><th class="whitespace-nowrap">Error</th></tr></thead><tbody>';
                        for (let i = 0; i < response.length; i++) {
                            const error = response[i];
                            table += '<tr>';
                            table += '<td>' + error.row + '</td>';
                            table += '<td>' + error.attribute + '</td>';
                            table += '<td>' + error.values.name + '</td>';
                            table += '<td>';
                            for (let j = 0; j < error.errors.length; j++) {
                                table += error.errors[j] + ' ';
                            }
                            table += '</td>';
                            table += '</tr>';
                        }

                        table += '</tbody></table></div></div></div></div></div>';
                        $('#upload-users').innerHTML = '';
                        $('#upload-users').append(table);
                    }
                }
            };

            if ($(this).data("single")) {
                options.maxFiles = 1;
            }

            if ($(this).data("file-types")) {
                options.accept = (file, done) => {
                    if (
                        $(this).data("file-types").split("|").indexOf(file.type) ===
                        -1
                    ) {
                        alert("Error! Files of this type are not accepted");
                        done("Error! Files of this type are not accepted");
                    } else {
                        console.log("Uploaded");
                        done();
                    }
                };
            }

            let dz = new Dropzone(this, options);

            dz.on("maxfilesexceeded", (file) => {
                alert("No more files please!");
            });
        });
    }
    /* // Dropzone
    Dropzone.autoDiscover = false;
    $(".dropzone").each(function () {
        let options = {
            accept: (file, done) => {
                console.log("Uploaded");
                done();
            },
            success: function (file, response) {
                console.log(response);
            }
        };

        if ($(this).data("single")) {
            options.maxFiles = 1;
        }

        if ($(this).data("file-types")) {
            options.accept = (file, done) => {
                if (
                    $(this).data("file-types").split("|").indexOf(file.type) ===
                    -1
                ) {
                    alert("Error! Files of this type are not accepted");
                    done("Error! Files of this type are not accepted");
                } else {
                    console.log("Uploaded");
                    done();
                }
            };
        }

        let dz = new Dropzone(this, options);

        dz.on("maxfilesexceeded", (file) => {
            alert("No more files please!");
        });
    }); */
})();
