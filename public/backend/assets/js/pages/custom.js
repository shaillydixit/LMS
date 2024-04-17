function show_toastr(type, message, title) {
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: false,
        positionClass: "toast-top-center",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "2000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    if (type == "success") {
        toastr.success(message, title);
    } else if (type == "error") {
        toastr.error(message, title);
    } else if (type == "info") {
        toastr.info(message, title);
    }
}

function block_page() {
    $.blockUI({
        message: '<div class="spinner-border text-white" role="status"></div>',
        css: {
            backgroundColor: "transparent",
            border: "0",
        },
        overlayCSS: {
            opacity: 0.5,
        },
    });
}
function unblock_page() {
    $.unblockUI();
}