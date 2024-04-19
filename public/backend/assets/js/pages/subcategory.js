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
        sAjaxSource: httpPath + "fetch-subcategory",
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
    var pageForm = $("#add_subcategory_form");
    if (pageForm.length) {
        if (typeof pageForm.validate === "function") {
            pageForm.validate({
                rules: {
                    subcategory_name: {
                        required: true,
                    },
                },
                messages: {
                    subcategory_name: {
                        required: "Enter subCategory Name",
                    },
                },
            });
        }
    } else {
        console.error("jQuery Validation Plugin is not loaded");
    }

    $("#submit_btn_subcategory").on("click", function (e) {
        e.preventDefault();
        if (!$("#add_subcategory_form").valid()) {
            return false;
        }
        var formData = new FormData($("#add_subcategory_form")[0]);
        $.ajax({
            url: httpPath + "ajax-manage-subcategory",
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
                    $("#add_subcategory_form").trigger("reset");
                    setInterval(function () {
                        window.location = httpPath + "subcategory";
                    }, 1000);
                    show_toastr("success", "Data Added Successfully.", "subcategory");
                } else if (obj.res == "3") {
                    $("#add_subcategory_form").trigger("reset");
                    setInterval(function () {
                        window.location = httpPath + "subcategory";
                    }, 1000);
                    show_toastr("success", "Data Updated Successfully.", "subcategory");
                } else if (obj.res == "2") {
                    show_toastr("info", "Data Already Exist.", "subcategory");
                } else if (obj.res == "0") {
                    show_toastr("error", "Something is wrong.", "subcategory");
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
                url: httpPath + "delete-subcategory",
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
                            "subcategory"
                        );
                        $("#datatable").DataTable().ajax.reload();
                    } else if (obj.res == "0") {
                        show_toastr(
                            "error",
                            "Something is wrong.",
                            "subcategory"
                        );
                    }
                    // unblock_page();
                },
            });
        }
    });
}