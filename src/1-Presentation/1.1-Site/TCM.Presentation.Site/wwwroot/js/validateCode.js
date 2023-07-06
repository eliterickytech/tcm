function AjaxSucceeded(result) {
    alert(result);
    if (result == true) {
        $(".access").remove();
        window.location = "/Home/Index"
    }
}

function AjaxFailed(result) {
    spinner.hide();
    if (data.errors.password) {

        $("#password-group").addClass("has-error");
        $("#password-group").append(
            '<div style="color:#C0694E;" class="help-block">' + data.errors.password + "</div>"
        )
    };

    if (data.errors.username) {
        $("#email-group").addClass("has-error");
        $("#email-group").append(
            '<div style="color:#C0694E;" class="help-block">' + data.errors.username + "</div>"
        );
    }

    if (data.errors.mobile) {
        $("#mobile-group").addClass("has-error");
        $("#mobile-group").append(
            '<div style="color:#C0694E;" class="help-block">' + data.errors.mobile + "</div>"
        );
    }
}
$(document).ready(function () {

    $("form").submit(function (event) {
        var spinner = $('#loader');

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
            url: `/Code/Validate`,
            data: formData,
            dataType: "json",
            encode: true,
            success: AjaxSucceeded,
            error: AjaxFailed
        });
      event.preventDefault();
    });
  });
