$(document).ready(function () {
    "use strict";
    var pageForm = $("#user_password_change_form");
    if (pageForm.length) {
        if (typeof pageForm.validate === "function") {
            pageForm.validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                    },
                    new_password_confirmation: {
                        required: true,
                        equalTo: new_password,
                    },
                    
                },
                messages: {
                    new_password_confirmation: {
                        required: "Enter Confirm Password",
                        equalTo: "Password Did Not Match",
                    },
                    old_password: {
                        required: "Enter Old Password",
                    },
                    new_password:{
                        required: "Enter New Password"
                    }
                },
            });
        } else {
            console.error("jQuery Validation Plugin is not loaded");
        }
    }

    $("#user_submit_password_btn").on("click", function (e) {
       
        e.preventDefault();
        if (!pageForm.valid()) {
            return false;
        }
        var formData = new FormData(pageForm[0]);
        $.ajax({
            url: httpPath + "user/password/update",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                var obj = JSON.parse(JSON.stringify(response));
                if (obj.res == "1") {
                    $("#user_password_change_form").trigger("reset");
                    show_toastr(
                        "success",
                        "Password Added Successfully.",
                        "Password"
                    );
                } else if (obj.res == "2") {
                    show_toastr("error", "Enter Correct Old Password", "Password");
                } else if (obj.res == "0") {
                    show_toastr("error", "Something is wrong.", "Password");
                }
            },
        });
    });
});
