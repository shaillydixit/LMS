$(document).ready(function () {
    "use strict";
    var pageForm = $("#instructor_form");
    if (pageForm.length) {
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

    $("#submit_btn_instructor").on("click", function (e) {
        e.preventDefault();
        if (!pageForm.valid()) {
            return false;
        }
        var formData = new FormData(pageForm[0]);
        $.ajax({
            url: httpPath + "instructor/profile/update",
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
                    show_toastr("success", "Data Updated Successfully.", "instructor");
                } else if (obj.res == "2") {
                    show_toastr("info", "User Already Exist.", "instructor");
                } else if (obj.res == "0") {
                    show_toastr("error", "Something is wrong.", "instructor");
                }
            },
        });
    });
});


$(document).ready(function () {
    "use strict";
    var pageForm = $("#instructor_update_password_form");
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

    $("#instructor_submit_password_btn").on("click", function (e) {
        e.preventDefault();
        if (!pageForm.valid()) {
            return false;
        }
        var formData = new FormData(pageForm[0]);
        $.ajax({
            url: httpPath + "instructor/password/update",
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
                    $("#instructor_update_password_form").trigger("reset");
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
