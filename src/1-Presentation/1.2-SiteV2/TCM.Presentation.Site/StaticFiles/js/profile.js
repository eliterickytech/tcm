﻿function AjaxSucceeded(result) {

    if (result.isOK) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                cancelButton: "btn btn-default active me-1 mb-1"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            imageUrl: result.data.url,
            text: result.data.description,
            showCancelButton: true,
            showConfirmButton: false

        });
    }
    else {

    }
}
function AjaxSucceededList(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        redirect = "/Chat/Details?connectionUserId=" + $("#connectionUserId").val();
    }
}

function AjaxFailed(result) {

    if (result.errors != null) {

        handleGritterNotificationMessages("Message danger", result.errors);
    };
}
function showAlert(id) {

    $.ajax({
        type: 'GET',
        url: `/Collection/GetCollectionItemById?id=${id}`,
        dataType: 'json',
        contentType: 'application/json',
        encode: true,
        success: AjaxSucceeded,
        error: AjaxFailed
    });
};


// Example starter JavaScript for disabling form submissions if there are invalid fields
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