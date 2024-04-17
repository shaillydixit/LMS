$(document).ready(function () {
    datatable = $("#datatable").dataTable({
        bAutoWidth: false,
        bFilter: true,
        bStateSave: true,
        bSort: true,
        bProcessing: true,
        bServerSide: true,

        oLanguage: {
            sLengthMenu: "_MENU_",
            sInfoFiltered: "",
            sProcessing: "Loading ...",
            sEmptyTable: "NO DATA ADDED YET !",
        },
        aLengthMenu: [
            [-1, 10, 20, 30, 50],
            ["All", 10, 20, 30, 50],
        ],
        iDisplayLength: 10,
        sAjaxSource: httpPath + "fetch-category",
        fnServerParams: function (aoData) {
            aoData.push({
                name: "mode",
                value: "fetch",
            });
        },
        fnDrawCallback: function (oSettings) {
            $('.ttip, [data-toggle="tooltip"]').tooltip();
        },
    });
    //Search input style
    $(".dataTables_filter input")
        .addClass("form-control")
        .attr("placeholder", "Search");
    $(".dataTables_length select").addClass("form-control");
    // validate the comment form when it is submitted
});


$(document).ready(function () {
    "use strict";
    var pageForm = $("#add_category_form");
    if (pageForm.length) {
        if (typeof pageForm.validate === "function") {
            pageForm.validate({
                rules: {
                    category_name: {
                        required: true,
                    },
                    // category_image: {
                    //     required: true,
                    // },
                },
                messages: {
                    category_name: {
                        required: "Enter Category Name",
                    },
                    // category_image: {
                    //     required: "Select Category Image",
                    // },


                },
            });
        }
    } else {
        console.error("jQuery Validation Plugin is not loaded");
    }

    $("#submit_btn_category").on("click", function (e) {
        e.preventDefault();
        if (!$("#add_category_form").valid()) {
            return false;
        }
        var formData = new FormData($("#add_category_form")[0]);
        $.ajax({
            url: httpPath + "ajax-manage-category",
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
                    $("#add_category_form").trigger("reset");
                    setInterval(function () {
                        window.location = httpPath + "category";
                    }, 1000);
                    show_toastr("success", "Data Added Successfully.", "Category");
                } else if (obj.res == "3") {
                    $("#add_category_form").trigger("reset");
                    setInterval(function () {
                        window.location = httpPath + "category";
                    }, 1000);
                    show_toastr("success", "Data Updated Successfully.", "Category");
                } else if (obj.res == "2") {
                    show_toastr("info", "Data Already Exist.", "Category");
                } else if (obj.res == "0") {
                    show_toastr("error", "Something is wrong.", "Category");
                }
            },
        });
    });
});

function delete_record(id) {
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        reverseButtons: false,
    }).then(function (result) {
        if (result.value) {
            // block_page();
            $.ajax({
                url: httpPath + "delete-category",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                data: {
                    id: id,
                },
                beforeSend: function () {},
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);
                    if (obj.res == "1") {
                        show_toastr(
                            "success",
                            "Data Deleted Successfully.",
                            "category"
                        );
                        $("#datatable").DataTable().ajax.reload();
                    } else if (obj.res == "0") {
                        show_toastr(
                            "error",
                            "Something is wrong.",
                            "category"
                        );
                    }
                    // unblock_page();
                },
            });
        }
    });
}