function AjaxSucceeded(result) {
    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);
        setTimeout(function () {
            window.location.href = result.redirect;
        }, 3000);
    }
}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };
}

$(document).ready(function () {

    $("#formUser").submit(function (event) {

        var form = $("#formUser")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                "Fullname": $("#fullname").val(),
                "MobilePhone": $("#mobile").val().replace(/[+()\s-]/g, ''),
                "Email": $("#email").val(),
                "UserName": $("#username").val(),
                "Password": $("#password").val(),
                "ConfirmPassword": $("#confirmPassword").val()
            };

            $.ajax({
                type: 'POST',
                url: "/Configuration/Settings",
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

