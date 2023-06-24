function AjaxSucceeded(result) {
    $(".access").remove();
    window.location = result.redirect
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
      event.preventDefault();
    });
  });


function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var baseUrl = "img"; //Na pasta em questão adicione as imagens. Cada imagem deverá ter o nome igual ao value correspodente no option
    var $state = $(
        '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
};
$("#frm_brand").select2({
    templateResult: formatState
});