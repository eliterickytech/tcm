function AjaxSucceeded(result) {

    var form = $("#formCode")
    var spinner = $('#loader');

    if (!result.isOK) {
        if (result.errors != null) {

            $("#password-group").addClass("has-error");
            $("#password-group").append(
                '<div style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
            )
        };
    }
    else {

        $(".access").remove();
        window.location.href = result.redirect;
        spinner.hide();
    }
}

function AjaxFailed(result) {

    spinner.hide();
    if (data.errors != null) {

        $("#password-group").addClass("has-error");
        $("#password-group").append(
            '<div style="color:#C0694E;" class="help-block">' + data.errors + "</div>"
        )
    };
}
$(document).ready(function () {

    $("#formCode").submit(function (event) {
        var spinner = $('#loader');

        var form = $("#formCode")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {

            var formData = {
                code: $("#code").val(),
                token: $("#token").val()
            };

            var code = $("#code").val();
            var token = $("#token").val();

            var dados = JSON.stringify(formData);

            spinner.show();

            $.ajax({
                type: "POST",
                url: "/Code/Validate",
                data: formData,
                dataType: "json",
                encode: true,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
        }
      event.preventDefault();
    });
  });
