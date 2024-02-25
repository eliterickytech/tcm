function AjaxSucceeded(result) {
    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);

        if (result.redirect != null && result.redirect != "") {
            setTimeout(function () {
                window.location.href = result.redirect;
            }, 3000);

        }
    }
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

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}

$(document).ready(function () {

    $.ajax({
        type: 'GET',
        url: `/Login/Users`,
        dataType: 'json',
        contentType: 'application/json',
        encode: true,
        success: function (result) {
            var dataArray = [];
            $.each(result.data, function (index, item) {
                dataArray.push({ id: item.id, text: item.userName });
            });

            $("#user").select2({
                placeholder: "Select a user",
                data: dataArray
            });
        },
        error: AjaxFailed
    });

    $("#formSendDelights").submit(function (event) {
        var form = $("#formSendDelights")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            event.preventDefault()
            var formData = {
                "userId": $("#user").val(),
                "connectionUserId": $("#hdnUserId").val(),
                "collectionItemId": $('input[name="rdbSendDelights"]:checked').data('id')
            };


            var buttonClicked = $(document.activeElement).attr('id');
            if (buttonClicked === "Save") {
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
            }
            if (buttonClicked === "btnRandomly") {
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

            }
        }
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