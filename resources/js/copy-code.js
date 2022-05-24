import Toastify from "toastify-js";

(function () {
    "use strict";

    // Copy original code
    $("body").on("click", ".copy-code", function () {
        let elementId = $(this).data("target");
        $(elementId).find("textarea")[0].select();
        $(elementId).find("textarea")[0].setSelectionRange(0, 99999);
        document.execCommand("copy");

        Toastify({
            text: "Copied!",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            className: "toastify-content",
        }).showToast();
    });
})();
