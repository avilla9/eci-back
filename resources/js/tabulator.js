import xlsx from "xlsx";
import feather from "feather-icons";
import Tabulator from "tabulator-tables";

(function () {
  "use strict";

  // User List
  if ($("#user-tabulator").length) {
    // Setup Tabulator
    let table = new Tabulator("#user-tabulator", {
      ajaxURL: "/api/users/getAllUsers",
      ajaxFiltering: true,
      ajaxSorting: true,
      printAsHtml: true,
      printStyled: true,
      pagination: 'local',
      paginationSize: 10,
      /* paginationSizeSelector: [10, 25, 50, 100], */
      layout: "fitColumns",
      responsiveLayout: "collapse",
      placeholder: "No matching records found",
      reactiveData: true,
      responsiveLayoutCollapseStartOpen: false,
      columns: [
        {
          formatter: "responsiveCollapse",
          width: 40,
          minWidth: 30,
          hozAlign: "center",
          resizable: false,
          headerSort: false,
        },

        // For HTML table
        {
          title: "DNI",
          minWidth: 100,
          responsive: 0,
          field: "dni",
          vertAlign: "left",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().dni
              }</div>
                        </div>`;
          },
        },
        {
          title: "Nombre completo",
          minWidth: 200,
          responsive: 0,
          field: "name",
          vertAlign: "right",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().name
              }</div>
                        </div>`;
          },
        },
        {
          title: "Email",
          minWidth: 250,
          field: "email",
          hozAlign: "right",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().email
              }</div>
                        </div>`;
          },
        },
        {
          title: "Rol",
          minWidth: 200,
          field: "role_name",
          hozAlign: "right",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().role_name
              }</div>
                        </div>`;
          },
        },
        {
          title: "Estatus",
          minWidth: 100,
          field: "active",
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div class="flex items-center lg:justify-center ${cell.getData().active
              ? "text-success"
              : "text-danger"
              }">
                            <i data-feather="check-square" class="w-4 h-4 mr-2"></i> ${cell.getData().active ? "Activo" : "Inactivo"
              }
                        </div>`;
          },
        },
        {
          title: "Funciones",
          minWidth: 200,
          field: "actions",
          responsive: 1,
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            let a =
              $(`<div class="flex lg:justify-center items-center">
                    <a data-tw-target="#superlarge-modal-size-preview" data-tw-toggle="modal" class="view flex items-center mr-3" href="javascript:;">
                        <i data-feather="eye" class="w-4 h-4 mr-1"></i> Ver
                    </a>
                    <a data-tw-target="#edit-user" data-tw-toggle="modal" class="edit flex items-center mr-3" href="javascript:;">
                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Editar
                    </a>
                    <a class="delete flex items-center text-danger" href="javascript:;">
                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                    </a>
                </div>`);
            $(a)
              .find(".view")
              .on("click", function () {
                $('#table-content').html('');
                table = '';
                table += `<tr class="whitespace-nowrap"><th>Activo</th><td>${cell.getData().active == 1 ? 'Si' : 'No'}</td></tr>`;
                let table = `<tr class="whitespace-nowrap"><th>DNI</th><td>${cell.getData().dni}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Nombre</th><td>${cell.getData().name}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Email</th><td>${cell.getData().email}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Sexo</th><td>${cell.getData().gender == 'm' ? 'Masculino' : 'femenino'}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>SECI Coins</th><td>${cell.getData().secicoins}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Rol</th><td>${cell.getData().role_name}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Cuartil</th><td>${cell.getData().quartile}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Grupo</th><td>${cell.getData().group}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Delegación</th><td>${cell.getData().delegation_name}</td></tr>`;
                table += `<tr class="whitespace-nowrap"><th>Código Delegación</th><td>${cell.getData().delegation_code}</td></tr>`;
                console.log(table);
                $('#table-content').html(table);
              });

            $(a)
              .find(".edit")
              .on("click", function () {
                $('#dni').val(cell.getData().dni);
                $('#dni').attr("placeholder", cell.getData().dni);

                $('#name').val(cell.getData().name);
                $('#name').attr("placeholder", cell.getData().name);

                $('#name').val(cell.getData().name);
                $('#name').attr("placeholder", cell.getData().name);

                if (cell.getData().gender == 'm') {
                  $('#male').attr("checked", true);
                } else {
                  $('#female').attr("checked", true);
                }

                $('#email').val(cell.getData().email);
                $('#email').attr("placeholder", cell.getData().email);

                $('#territorial').val(cell.getData().territorial);
                $('#territorial').attr("placeholder", cell.getData().territorial);

                $('#secicoins').val(cell.getData().secicoins);
                $('#secicoins').attr("placeholder", cell.getData().secicoins);

                $('#role_id').val(cell.getData().role_id).attr("selected", "selected");

                $('#delegation_id').val(cell.getData().delegation_id).attr("selected", "selected");

                $('#group_id').val(cell.getData().group_id).attr("selected", "selected");

                $('#quartile_id').val(cell.getData().quartile_id).attr("selected", "selected");
              });

            $(a)
              .find(".delete")
              .on("click", function () {
                console.log('id log', cell.getData().id)
                Swal.fire({
                  title: '¿Desea eliminar este/os usuario/s?',
                  text: "Esta accion es irreversible!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, seguro!',
                  cancelButtonText: 'No, cancelar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    fetch('/api/users/delete', {
                      method: 'POST',
                      headers: { "Content-type": "application/json;charset=UTF-8" },
                      body: JSON.stringify({
                        id: cell.getData().id
                      }),
                    }).then(function (response) {
                      if (response) {
                        console.log(response);
                        cell.getRow().delete();
                        table.redraw(true);
                      } else {
                        throw "Error en la llamada Ajax";
                      }
                    });
                  }
                })
              });

            return a[0];
          },
        },

        // For print format
        /* {
            title: "PRODUCT NAME",
            field: "name",
            visible: false,
            print: true,
            download: true,
        },
        {
            title: "CATEGORY",
            field: "category",
            visible: false,
            print: true,
            download: true,
        },
        {
            title: "Estatus",
            field: "status",
            visible: false,
            print: true,
            download: true,
            formatterPrint(cell) {
                return cell.getValue() ? "Active" : "Inactive";
            },
        },
        {
            title: "IMAGE 1",
            field: "images",
            visible: false,
            print: true,
            download: true,
            formatterPrint(cell) {
                return cell.getValue()[0];
            },
        },
        {
            title: "IMAGE 2",
            field: "images",
            visible: false,
            print: true,
            download: true,
            formatterPrint(cell) {
                return cell.getValue()[1];
            },
        },
        {
            title: "IMAGE 3",
            field: "images",
            visible: false,
            print: true,
            download: true,
            formatterPrint(cell) {
                return cell.getValue()[2];
            },
        }, */
      ],
      renderComplete() {
        feather.replace({
          "stroke-width": 1.5,
        });
      },
    });

    // Redraw table onresize
    window.addEventListener("resize", () => {
      table.redraw();
      feather.replace({
        "stroke-width": 1.5,
      });
    });

    // Filter function
    function filterHTMLForm() {
      let field = $("#tabulator-html-filter-field").val();
      let type = $("#tabulator-html-filter-type").val();
      let value = $("#tabulator-html-filter-value").val();
      table.setFilter(field, type, value);
    }

    // On submit filter form
    $("#tabulator-html-filter-form")[0].addEventListener(
      "keypress",
      function (event) {
        let keycode = event.keyCode ? event.keyCode : event.which;
        if (keycode == "13") {
          event.preventDefault();
          filterHTMLForm();
        }
      }
    );

    // On click go button
    $("#tabulator-html-filter-go").on("click", function (event) {
      filterHTMLForm();
    });

    // On reset filter form
    $("#tabulator-html-filter-reset").on("click", function (event) {
      $("#tabulator-html-filter-field").val("name");
      $("#tabulator-html-filter-type").val("like");
      $("#tabulator-html-filter-value").val("");
      filterHTMLForm();
    });

    // Export
    $("#tabulator-export-csv").on("click", function (event) {
      table.download("csv", "data.csv");
    });

    $("#tabulator-export-json").on("click", function (event) {
      table.download("json", "data.json");
    });

    $("#tabulator-export-xlsx").on("click", function (event) {
      window.XLSX = xlsx;
      table.download("xlsx", "data.xlsx", {
        sheetName: "Products",
      });
    });

    $("#tabulator-export-html").on("click", function (event) {
      table.download("html", "data.html", {
        style: true,
      });
    });

    // Print
    $("#tabulator-print").on("click", function (event) {
      table.print();
    });
  }

  // Role List
  if ($("#role-tabulator").length) {
    // Setup Tabulator
    let table = new Tabulator("#role-tabulator", {
      ajaxURL: "/api/roles/all-roles",
      ajaxFiltering: true,
      ajaxSorting: true,
      printAsHtml: true,
      printStyled: true,
      pagination: 'local',
      paginationSize: 10,
      /* paginationSizeSelector: [10, 25, 50, 100], */
      layout: "fitColumns",
      responsiveLayout: "collapse",
      placeholder: "No matching records found",
      reactiveData: true,
      responsiveLayoutCollapseStartOpen: false,
      columns: [
        {
          formatter: "responsiveCollapse",
          width: 40,
          minWidth: 30,
          hozAlign: "center",
          resizable: false,
          headerSort: false,
        },

        // For HTML table
        {
          title: "Nombre",
          minWidth: 200,
          responsive: 0,
          field: "name",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().name
              }</div>
                        </div>`;
          },
        },
        {
          title: "Descripción",
          minWidth: 200,
          field: "description",
          hozAlign: "right",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().description
              }</div>
                        </div>`;
          },
        },
        {
          title: "Nivel",
          minWidth: 200,
          field: "level",
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().level
              }</div>
                        </div>`;
          },
        },
        {
          title: "Funciones",
          minWidth: 200,
          field: "actions",
          responsive: 1,
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            let a =
              $(`<div class="flex lg:justify-center items-center">
                            <a class="edit flex items-center mr-3" href="javascript:;">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Editar
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                            </a>
                        </div>`);
            $(a)
              .find(".edit")
              .on("click", function () {
                alert("EDIT");
              });

            $(a)
              .find(".delete")
              .on("click", function () {
                console.log('id log', cell.getData().id)
                Swal.fire({
                  title: '¿Desea eliminar este/os roles?',
                  text: "Esta accion es irreversible!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, seguro!',
                  cancelButtonText: 'No, cancelar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    /* fetch('/api/users/delete', {
                    method: 'POST',
                    headers: { "Content-type": "application/json;charset=UTF-8" },
                    body: JSON.stringify({
                        id: cell.getData().id
                    }),
                }).then(function (response) {
                    if (response) {
                        console.log(response);
                    } else {
                        throw "Error en la llamada Ajax";
                    }
                }); */
                  }
                })
              });

            return a[0];
          },
        },

        // For print format
        {
          title: "Nombre",
          field: "name",
          hozAlign: "center",
          visible: false,
          print: true,
          download: true,
        },
        {
          title: "Descripción",
          field: "description",
          hozAlign: "center",
          visible: false,
          print: true,
          download: true,
        },
        {
          title: "Nivel",
          field: "level",
          hozAlign: "center",
          visible: false,
          print: true,
          download: true,
        },
      ],
      renderComplete() {
        feather.replace({
          "stroke-width": 1.5,
        });
      },
    });

    // Redraw table onresize
    window.addEventListener("resize", () => {
      table.redraw();
      feather.replace({
        "stroke-width": 1.5,
      });
    });

    // Filter function
    function filterHTMLForm() {
      let field = $("#tabulator-html-filter-field").val();
      let type = $("#tabulator-html-filter-type").val();
      let value = $("#tabulator-html-filter-value").val();
      table.setFilter(field, type, value);
    }

    // On submit filter form
    $("#tabulator-html-filter-form")[0].addEventListener(
      "keypress",
      function (event) {
        let keycode = event.keyCode ? event.keyCode : event.which;
        if (keycode == "13") {
          event.preventDefault();
          filterHTMLForm();
        }
      }
    );

    // On click go button
    $("#tabulator-html-filter-go").on("click", function (event) {
      filterHTMLForm();
    });

    // On reset filter form
    $("#tabulator-html-filter-reset").on("click", function (event) {
      $("#tabulator-html-filter-field").val("name");
      $("#tabulator-html-filter-type").val("like");
      $("#tabulator-html-filter-value").val("");
      filterHTMLForm();
    });

    // Export
    $("#tabulator-export-csv").on("click", function (event) {
      table.download("csv", "data.csv");
    });

    $("#tabulator-export-json").on("click", function (event) {
      table.download("json", "data.json");
    });

    $("#tabulator-export-xlsx").on("click", function (event) {
      window.XLSX = xlsx;
      table.download("xlsx", "data.xlsx", {
        sheetName: "Products",
      });
    });

    $("#tabulator-export-html").on("click", function (event) {
      table.download("html", "data.html", {
        style: true,
      });
    });

    // Print
    $("#tabulator-print").on("click", function (event) {
      table.print();
    });
  }

  // Tabulator
  if ($("#tabulator").length) {
    // Setup Tabulator
    let table = new Tabulator("#tabulator", {
      ajaxURL: "https://dummy-data.left4code.com",
      ajaxFiltering: true,
      ajaxSorting: true,
      printAsHtml: true,
      printStyled: true,
      pagination: "remote",
      paginationSize: 19,
      paginationSizeSelector: [10, 20, 30, 40],
      layout: "fitColumns",
      responsiveLayout: "collapse",
      placeholder: "No matching records found",
      columns: [
        {
          formatter: "responsiveCollapse",
          width: 40,
          minWidth: 30,
          hozAlign: "center",
          resizable: false,
          headerSort: false,
        },

        // For HTML table
        {
          title: "PRODUCT NAME",
          minWidth: 200,
          responsive: 0,
          field: "name",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div>
                            <div class="font-medium whitespace-nowrap">${cell.getData().name
              }</div>
                            <div class="text-slate-500 text-xs whitespace-nowrap">${cell.getData().category
              }</div>
                        </div>`;
          },
        },
        {
          title: "IMAGES",
          minWidth: 200,
          field: "images",
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div class="flex lg:justify-center">
                            <div class="intro-x w-10 h-10 image-fit">
                                <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${cell.getData().images[0]
              }">
                            </div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5">
                                <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${cell.getData().images[1]
              }">
                            </div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5">
                                <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${cell.getData().images[2]
              }">
                            </div>
                        </div>`;
          },
        },
        {
          title: "REMAINING STOCK",
          minWidth: 200,
          field: "remaining_stock",
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
        },
        {
          title: "STATUS",
          minWidth: 200,
          field: "status",
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            return `<div class="flex items-center lg:justify-center ${cell.getData().status
              ? "text-success"
              : "text-danger"
              }">
                            <i data-feather="check-square" class="w-4 h-4 mr-2"></i> ${cell.getData().status ? "Active" : "Inactive"
              }
                        </div>`;
          },
        },
        {
          title: "ACTIONS",
          minWidth: 200,
          field: "actions",
          responsive: 1,
          hozAlign: "center",
          vertAlign: "middle",
          print: false,
          download: false,
          formatter(cell, formatterParams) {
            let a =
              $(`<div class="flex lg:justify-center items-center">
                            <a class="edit flex items-center mr-3" href="javascript:;">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>`);
            $(a)
              .find(".edit")
              .on("click", function () {
                alert("EDIT");
              });

            $(a)
              .find(".delete")
              .on("click", function () {
                alert("DELETE");
              });

            return a[0];
          },
        },

        // For print format
        {
          title: "PRODUCT NAME",
          field: "name",
          visible: false,
          print: true,
          download: true,
        },
        {
          title: "CATEGORY",
          field: "category",
          visible: false,
          print: true,
          download: true,
        },
        {
          title: "REMAINING STOCK",
          field: "remaining_stock",
          visible: false,
          print: true,
          download: true,
        },
        {
          title: "STATUS",
          field: "status",
          visible: false,
          print: true,
          download: true,
          formatterPrint(cell) {
            return cell.getValue() ? "Active" : "Inactive";
          },
        },
        {
          title: "IMAGE 1",
          field: "images",
          visible: false,
          print: true,
          download: true,
          formatterPrint(cell) {
            return cell.getValue()[0];
          },
        },
        {
          title: "IMAGE 2",
          field: "images",
          visible: false,
          print: true,
          download: true,
          formatterPrint(cell) {
            return cell.getValue()[1];
          },
        },
        {
          title: "IMAGE 3",
          field: "images",
          visible: false,
          print: true,
          download: true,
          formatterPrint(cell) {
            return cell.getValue()[2];
          },
        },
      ],
      renderComplete() {
        feather.replace({
          "stroke-width": 1.5,
        });
      },
    });

    // Redraw table onresize
    window.addEventListener("resize", () => {
      table.redraw();
      feather.replace({
        "stroke-width": 1.5,
      });
    });

    // Filter function
    function filterHTMLForm() {
      let field = $("#tabulator-html-filter-field").val();
      let type = $("#tabulator-html-filter-type").val();
      let value = $("#tabulator-html-filter-value").val();
      table.setFilter(field, type, value);
    }

    // On submit filter form
    $("#tabulator-html-filter-form")[0].addEventListener(
      "keypress",
      function (event) {
        let keycode = event.keyCode ? event.keyCode : event.which;
        if (keycode == "13") {
          event.preventDefault();
          filterHTMLForm();
        }
      }
    );

    // On click go button
    $("#tabulator-html-filter-go").on("click", function (event) {
      filterHTMLForm();
    });

    // On reset filter form
    $("#tabulator-html-filter-reset").on("click", function (event) {
      $("#tabulator-html-filter-field").val("name");
      $("#tabulator-html-filter-type").val("like");
      $("#tabulator-html-filter-value").val("");
      filterHTMLForm();
    });

    // Export
    $("#tabulator-export-csv").on("click", function (event) {
      table.download("csv", "data.csv");
    });

    $("#tabulator-export-json").on("click", function (event) {
      table.download("json", "data.json");
    });

    $("#tabulator-export-xlsx").on("click", function (event) {
      window.XLSX = xlsx;
      table.download("xlsx", "data.xlsx", {
        sheetName: "Products",
      });
    });

    $("#tabulator-export-html").on("click", function (event) {
      table.download("html", "data.html", {
        style: true,
      });
    });

    // Print
    $("#tabulator-print").on("click", function (event) {
      table.print();
    });
  }
})();
