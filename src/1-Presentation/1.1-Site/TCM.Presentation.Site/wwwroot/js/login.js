function AjaxSucceeded(result) {
    var form = $("#formLogin")
    var spinner = $('#loader');

    if (!result.isOK) {

        if (result.errors != null && result.type == "InvalidPassword") {

            $("#password-group").addClass("has-error");
            $("#password-group").append(
                '<div style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
            )
        };
        spinner.hide();
    }
    else {

        $(".access").remove();
        window.location.href = result.redirect;
        spinner.hide();
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

    $("#formLogin").submit(function (event) {

        var spinner = $('#loader');

        var form = $("#formLogin")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                password: $("#password").val(),
                user: $("#email").val(),
            };

            var password = $("#password").val();
            var user = $("#email").val();

            var dados = JSON.stringify(formData);

            spinner.show();

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