import Dropzone from "dropzone";

(function () {
    "use strict";
    Dropzone.autoDiscover = false;

    if ($("#upload-users").length) {
        // Dropzone
        $(".dropzone").each(function () {
            let options = {
                accept: (file, done) => {
                    console.log("Uploaded");
                    done();
                },
                success: function (file, response) {
                    console.log(response);
                    $("#alert").innerHTML = "";
                    if (typeof response === "string") {
                        $("#alert").append(
                            '<div class="alert alert-success">' +
                                response +
                                "</div>"
                        );
                    } else {
                        $("#alert").append(
                            '<div class="alert alert-danger">Error al insertar algunos usuarios</div>'
                        );
                        let table =
                            '<div class="intro-y col-span-12 lg:col-span-6 mt-5"><div class="intro-y box"><div class="p-5" id="head-options-table"><div class="preview"><div class="overflow-x-auto"><table class="table"><thead><tr><th class="whitespace-nowrap">Fila</th><th class="whitespace-nowrap">Columna</th><th class="whitespace-nowrap">Usuario</th><th class="whitespace-nowrap">Error</th></tr></thead><tbody>';
                        for (let i = 0; i < response.length; i++) {
                            const error = response[i];
                            table += "<tr>";
                            table += "<td>" + error.row + "</td>";
                            table += "<td>" + error.attribute + "</td>";
                            table += "<td>" + error.values.name + "</td>";
                            table += "<td>";
                            for (let j = 0; j < error.errors.length; j++) {
                                table += error.errors[j] + " ";
                            }
                            table += "</td>";
                            table += "</tr>";
                        }

                        table +=
                            "</tbody></table></div></div></div></div></div>";
                        $("#upload-users").innerHTML = "";
                        $("#upload-users").append(table);
                    }
                },
            };

            if ($(this).data("single")) {
                options.maxFiles = 1;
            }

            if ($(this).data("file-types")) {
                options.accept = (file, done) => {
                    if (
                        $(this)
                            .data("file-types")
                            .split("|")
                            .indexOf(file.type) === -1
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

    $("#automatic-modal #auto_campaign_id").on("change", function () {
        console.log($(this).val());
        $("#import-campaign").removeClass("hidden");
        $(".dropzone").each(function () {
            let options = {
                accept: (file, done) => {
                    console.log("Uploaded");
                    done();
                },
                success: function (file, response) {
                    $("#automatic-modal #alert").html();
                    $("#automatic-modal #alert").removeClass();
                    $("#automatic-modal #alert").addClass(
                        "alert alert-success show mb-2"
                    );
                    $("#automatic-modal #alert").html(
                        "Datos añadidos con éxito"
                    );

                    $.ajax({
                        type: "GET",
                        url: "/produccion/campaign",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            id: parseInt($("#campaign").val()),
                        },
                        success: function success(data) {
                            $("#suscribed-list").html();
                            if (!data) {
                                $("#suscribed-list").html(
                                    '<tr><th class="text-center w-full" colspan="7">No hay registros para mostrar</th></tr>'
                                );
                            } else {
                                let printData = "";
                                for (let i = 0; i < data.length; i++) {
                                    const item = data[i];
                                    let tr =
                                        '<tr id="' +
                                        item.id +
                                        '">' +
                                        '<td class="text-right">' +
                                        item.dni +
                                        "</td>" +
                                        '<td class="text-right">' +
                                        item.name +
                                        "</td>" +
                                        '<td class="text-right">' +
                                        item.policy_objective +
                                        "</td>" +
                                        '<td class="text-right">' +
                                        item.policy_raised +
                                        "</td>" +
                                        '<td class="text-right">' +
                                        (
                                            (item.policy_raised * 100) /
                                            item.policy_objective
                                        ).toPrecision(2) +
                                        "%</td>" +
                                        '<td class="text-right">' +
                                        item.bonus +
                                        "</td>" +
                                        '<td class="text-right">' +
                                        item.incentive +
                                        "</td>" +
                                        '<td><button campaign_id="' +
                                        item.id +
                                        '" class="delete flex items-center text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Eliminar</button></td></tr>';
                                    printData += tr;
                                }
                                $("#suscribed-list").html(printData);
                            }
                        },
                        error: function error(_error) {
                            console.log("error", _error);

                            $("#manually-modal #alert").html();
                            $("#manually-modal #alert").removeClass();
                            $("#manually-modal #alert").addClass(
                                "alert alert-danger show mb-2"
                            );
                            $("#manually-modal #alert").html(
                                "Ha ocurrido un error al eliminar la campaña"
                            );
                        },
                    });
                },
            };

            /* if ($(this).data("single")) {
        options.maxFiles = 1;
      } */

            if ($(this).data("file-types")) {
                options.accept = (file, done) => {
                    if (
                        $(this)
                            .data("file-types")
                            .split("|")
                            .indexOf(file.type) === -1
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

            dz.on("sending", function (file, xhr, formData) {
                formData.append("campaign_id", $("#auto_campaign_id").val());
            });
        });
    });

    if ($("#multiple-file-upload").length) {
        console.log("multiple");
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#my-awesome-dropzone", {
            autoProcessQueue: false,
        });
        $(".dropzone").each(function () {
            const $button = document.getElementById("submit-files");
            $button.addEventListener("click", function () {
                // Retrieve selected files
                const acceptedFiles = myDropzone.getAcceptedFiles();
                for (let i = 0; i < acceptedFiles.length; i++) {
                    setTimeout(function () {
                        myDropzone.processFile(acceptedFiles[i]);
                    }, i * 2000);
                    $("#alertSuccess").html(
                      '<div class="alert alert-success">' +
                          "Subiendo archivos" +
                          "</div>"
                  )
                  $("#alertSuccess").css("display", "block");
                  $('#redirect-files').css("display", "")
                  setTimeout(() => {
                      $("#alertSuccess").css("display", "none");
                  }, 5000);
                  
                }
               
                
            });
            let options = {
                accept: (file, done) => {
                    console.log("Uploaded");
                    done();
                },
                success: function (file, response) {
                    console.log(response);
                },
            };

            if ($(this).data("file-types")) {
                options.accept = (file, done) => {
                    if (
                        $(this)
                            .data("file-types")
                            .split("|")
                            .indexOf(file.type) === -1
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

            /* dz.on("maxfilesexceeded", (file) => {
        alert("No more files please!");
      }); */
        });
    }

    /* // Dropzone
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
