function AjaxSucceeded(result) {
    console.log(result)
    window.location = result.redirect
}

function AjaxFailed(result) {
    alert("Failed")
    alert(result)

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
    var url_string = window.location.href;
    var url = new URL(url_string);
    var token = url.searchParams.get("token");

    $("#token").val(token);

    $("form").submit(function (event) {

        var spinner = $('#loader');

        var formData = {
            Token: $("#token").val(),
            Code: $("#code_numbers").val()
        };

        spinner.show();

        $.ajax({
            type: "POST",
            url: "/Code/VerifyCodeMobile",
            data: formData,
            dataType: "json",
            encode: false,
            success: AjaxSucceeded,
            error: AjaxFailed,
    
        });
      event.preventDefault();
    });
  });