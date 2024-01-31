function AjaxSucceeded(result) {

    if (!result.isOK) {
        if (result.errors != null) {

            handleGritterNotificationMessages("Message warning", result.errors);

        };
    }
    else {
        window.location.href = result.redirect;
    }
}

function AjaxFailed(result) {

    if (data.errors != null) {

        handleGritterNotificationMessages("Message danger", result.errors);
    };
}
$(document).ready(function () {

    $("#formCode").submit(function (event) {

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
