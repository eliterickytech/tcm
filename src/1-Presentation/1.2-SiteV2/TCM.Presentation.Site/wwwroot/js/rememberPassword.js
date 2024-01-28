function AjaxSucceeded(result) {

    if (!result.isOK) {

        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);
        if (result.type == "ChangedPIN") {
            setTimeout(function () {
                window.location.href = result.redirect;
            }, 3000);

        }


    }

}

function AjaxFailed(result) {

    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };
}
$(document).ready(function () {

    $("#formRemember").submit(function (event) {

        var form = $("#formRemember")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                "username": $("#username").val(),
            };
            var username = $("#username").val();

            $.ajax({
                type: 'GET',
                url: `/RememberPassword/Remember?username=${username}`,
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

    $("#formChange").submit(function (event) {

        var form = $("#formChange")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                "UserName": $("#username").val(),
                "Password": $("#password").val(),
                "ConfirmPassword": $("#confirmPassword").val(),
            };

            $.ajax({
                type: 'POST',
                url: `/RememberPassword/ChangePassawordUser`,
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
