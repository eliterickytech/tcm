function AjaxSucceeded(result) {

    if (result.isOK) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-theme me-1 mb-1"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            html: `<div class="col-xl-12 mb-20px">
                <a href="#" class="navbar-brand mb-20px"><span><img src="/StaticFiles/tcm/img/Logo.png" width="40" height="40"></span>&nbsp;<b>Chef</b> Melo</a>
            </div>
            <div class="col-xl-12 mb-10px">
                <img src='${result.data.url}' />
            </div>
            <div class="col-xl-12" style="display:${result.data.quantity > 1 ? "block": "none"}">
                <h6>You have ${result.data.quantity} repeated items</h6>
            </div>
            <div class="col-xl-12">
                <h5>${result.data.description}</h5>
            </div>
            <div class="col-xl-10">
                <h6>Sent by ${result.data.connectionNameShared}</h5>
            </div>
            `,
            showConfirmButton: result.data.quantity > 1 ? true : false,
            confirmButtonText: "Share this delight",
            showCloseButton: true

        }).then((resultAlert) => {
            if (resultAlert.isConfirmed) {
                window.location.href = `/SendDelights/ShareDelightConnection?collectionItemId=${result.data.collectionItemId}`;
            }
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
        url: `/SendDelights/ListSharedItemsByCollectionItemId?collectionItemId=${id}`,
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