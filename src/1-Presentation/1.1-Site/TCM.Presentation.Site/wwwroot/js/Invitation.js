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

        //$(".area_user_chats").load(result.redirect, dados, function (response, status, xhr) {
        //    if (status == "error") {
        //        var msg = "Sorry but there was an error: ";
        //        alert(msg + xhr.status + " " + xhr.statusText);
        //    }
        //});

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
                email: $("#txtSearch").val()
            };
            var email = $("#txtSearch").val();
            var dados = JSON.stringify(formData);
            spinner.show();

            $.ajax({
                type: "GET",
                url: `/Invitation/GetUser?Email=${email}`,
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
