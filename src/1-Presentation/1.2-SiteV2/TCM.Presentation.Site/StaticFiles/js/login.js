function AjaxSucceeded(result) {
    var form = $("#formLogin")


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

    $("#formLogin").submit(function (event) {

        var form = $("#formLogin")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                password: $("#password").val(),
                user: $("#username").val(),
            };

            var password = $("#password").val();
            var user = $("#username").val();

            var dados = JSON.stringify(formData);

            $.ajax({
                type: "GET",
                url: `Login/GetUser?user=${user}&password=${password}`,
                data: dados,
                dataType: "json",
                encode: true,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
        }
        event.preventDefault();
    });
});

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