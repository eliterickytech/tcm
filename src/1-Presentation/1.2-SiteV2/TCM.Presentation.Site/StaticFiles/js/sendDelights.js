function AjaxSucceeded(result) {
    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        if (result.redirect != null) {

            window.location.href = result.redirect;
        }
    }
}

function AjaxFailed(result) {
    console.log("Result Failed: ", result);

    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}

function showSweetAlert() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-theme me-1 mb-1"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "",
        icon: "info",
        html: `<div class="col-xl-12"><h4>Please wait while I distribute the collection items</h4><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>`,
    });
}
function closeSweetAlert() {
    Swal.close();
}
function stringToDate(dateString, hourString) {
    return moment(dateString + ' ' + hourString, 'MM/DD/YYYY hh:mm A').format('MM/DD/YYYY HH:mm:ss');
}


$(document).ready(function () {

    $('button[name="share"]').click(function () {

        $('button[name="share"]').prop("disabled", true).removeClass("btn-theme").addClass("btn-default");

        var form = $("#formSharedSendDelights")

        var formData = {
            "userId": $("#hdnUserId").val(),
            "connectionUserId": $("#user").val(),
            "collectionItemId": $("#hdnCollectioItemId").val(),
            "description": $("#message").val(),
            "postMyActivity": $("#postMyActivity").is(":checked") ? true : false,
            "userName": $("#hdnUserName").val(),
            "connectionUserName": $("#user option:selected").text()
        };

        $.ajax({
            type: 'POST',
            url: "/SendDelights/SaveSharedUserItem",
            data: JSON.stringify(formData),
            dataType: 'json',
            contentType: 'application/json',
            encode: true,
            success: AjaxSucceeded,
            error: AjaxFailed
        });

    });

    $('button[name="btnRandomly"]').click(function () {

        var form = $("#formSendDelights")

        var formData = {
            "userId": $("#user").val(),
            "connectionUserId": $("#hdnUserId").val()
        };

        showSweetAlert();

        $.ajax({
            type: 'POST',
            url: "/SendDelights/SaveSharedRandomItem",
            data: JSON.stringify(formData),
            dataType: 'json',
            contentType: 'application/json',
            encode: true,
            success: function (result) {
                AjaxSucceeded(result);
                closeSweetAlert();

            },
            error: function (result) {
                AjaxFailed(result);
                closeSweetAlert();
            }
        });
    });

    $('button[name="save"]').click(function () {

        var form = $("#formSendDelights")

        var formData = {
            "userId": $("#user").val(),
            "connectionUserId": $("#hdnUserId").val(),
            "collectionItemId": $('input[name="rdbSendDelights"]:checked').data('id')
        };

        if (formData.collectionItemId == undefined || formData.collectionItemId == null) {
            AjaxFailed({ errors: "Please select a item", isOK: false })
            return;
        }
        $.ajax({
            type: 'POST',
            url: "/SendDelights/SaveSharedItem",
            data: JSON.stringify(formData),
            dataType: 'json',
            contentType: 'application/json',
            encode: true,
            success: AjaxSucceeded,
            error: AjaxFailed
        }); 
    });

    var currentUserId = $("#hdnUserId").val();

    $.ajax({
        type: 'GET',
        url: `/Connection/ListMyConnection`,
        dataType: 'json',
        contentType: 'application/json',
        encode: true,
        success: function (result) {
            var dataArray = [];
            $.each(result.data, function (index, item) {
                if (item.userId != 1 && item.userId.toString() !== currentUserId) {
                    dataArray.push({ id: item.userId, text: item.userName });
                }
            });

            $("#user").select2({
                placeholder: "Select a user",
                data: dataArray
            });
        },
        error: AjaxFailed
    });
});
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()