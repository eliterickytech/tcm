function AjaxSucceeded(result) {


    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        window.location.href = result.redirect;
    }

}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}
$(document).ready(function () {

    $("#formBanner").submit(function (event) {

        var form = $("#formBanner")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                "Fullname": $("#fullname").val(),
                "Email": $("#email").val(),
                "Username": $("#username").val(),
                "MobilePhone": $("#mobile").val().replace(/[+()\s-]/g, ''),
                "Password": $("#password").val(),
                "ConfirmPassword": $("#confirmPassword").val(),
            };


            $.ajax({
                type: 'POST',
                url: "/ManagerBannerTop/GetBannerAsync",
                data: JSON.stringify(formData),
                dataType: 'json',
                contentType: 'application/json',
                encode: true,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
        }
      event.preventDefault();
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
$('#mobile').inputmask('+1 (999) 999-9999');