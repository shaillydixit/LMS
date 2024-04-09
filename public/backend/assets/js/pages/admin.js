$(document).ready(function () {
    "use strict";
    var pageForm = $("#admin_form");
    if (pageForm.length) {
        // Check if jQuery Validation Plugin is loaded
        if (typeof pageForm.validate === "function") {
            pageForm.validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    username: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    
                },
                messages: {
                    email: {
                        required: "Enter Email address",
                        email: "Email Address is not valid",
                    },
                    phone: {
                        required: "Enter Phone Number",
                        minlength: "Phone number is not valid",
                    },
                },
            });
        } else {
            console.error("jQuery Validation Plugin is not loaded");
        }
    }

    $("#submit_btn_admin").on("click", function (e) {
        e.preventDefault();
        if (!pageForm.valid()) {
            return false;
        }
        var formData = new FormData(pageForm[0]);
        $.ajax({
            url: httpPath + "admin/profile/update",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                var obj = JSON.parse(JSON.stringify(response));
                if (obj.res == "3") {
                    window.location.reload(true);
                    show_toastr("success", "Data Updated Successfully.", "User");
                } else if (obj.res == "2") {
                    show_toastr("info", "Data Already Exist.", "User");
                } else if (obj.res == "0") {
                    show_toastr("error", "Something is wrong.", "User");
                }
            },
        });
    });
});
