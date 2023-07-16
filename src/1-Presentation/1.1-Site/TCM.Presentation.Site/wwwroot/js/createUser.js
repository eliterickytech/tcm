function AjaxSucceeded(result) {
    var form = $("#formUser")
    var spinner = $('#loader');
    spinner.hide();
    if (!result.isOK) {
        if (result.type == "Password") {

            $("#password-group").addClass("has-error");
            $("#password-group").append(
                '<div style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
            )
        };
    }
    else {

        $(".access").remove();
        window.location.href = result.redirect;
    }

}

function AjaxFailed(result) {
    var spinner = $('#loader');
    spinner.hide();
    if (result.errors != null) {

        $("#password-group").addClass("has-error");
        $("#password-group").append(
            '<div style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
        )
    };

}
$(document).ready(function () {

    $("#formUser").submit(function (event) {

        var spinner = $('#loader');

        var form = $("#formUser")
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

            spinner.show();

            $.ajax({
                type: 'POST',
                url: "/CreateAccount/AddUser",
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