function AjaxSucceeded(result) {

    var form = $("#formSearchInvitation")
    var spinner = $('#loader');

    if (!result.isOK) {
        if (result.errors != null) {
            $("#divError").remove();
            $("#email-group").addClass("has-error");
            $("#email-group").append(
                '<div id="divError" style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
            )
        };
        spinner.hide();
    }
    else {
        var dados = JSON.stringify(result.data);
        console.log(dados)

        $.ajax({
            type: "POST",
            url: result.redirect,
            data: dados,
            dataType: "html",
            contentType: "application/json; charset=utf-8",
            encode: true,
            success: function (result) {
                console.log(result);
                $("#container_home").html(result)
                spinner.hide();
            },
            error: function (result, error) {
                console.log(result);

                console.log(error);

                spinner.hide();
            }
        });

    }
}

function AjaxFailed(result) {

    if (data.errors != null) {

        $("#email-group").addClass("has-error");
        $("#email-group").append(
            '<div style="color:#C0694E;" class="help-block">' + result.errors + "</div>"
        )
    };
    spinner.hide();
}
$(document).ready(function () {

    $("#formSearchInvitation").submit(function (event) {
        var spinner = $('#loader');

        var form = $("#formSearchInvitation")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                userName: $("#txtSearch").val()
            };
            var userName = $("#txtSearch").val();
            var dados = JSON.stringify(formData);
            spinner.show();

            $.ajax({
                type: "GET",
                url: `/User/GetUserConnection?UserName=${userName}`,
                data: email,
                //dataType: "json",
                encode: true,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
        }
      event.preventDefault();
    });
  });
