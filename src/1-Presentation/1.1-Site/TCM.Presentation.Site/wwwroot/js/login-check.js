$(document).ready(function () {
    $("form").submit(function (event) {
        var formData = {
            code_numbers: document.querySelector('[name="code_numbers"]').value,
            token: document.querySelector('[name="token"]').value,
        };
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();  
        var dados = JSON.stringify(formData);
        $.ajax({
            type: "POST",
            url: "login-validate.php",
            data: {data: dados},
            dataType: "json",
            encode: true,
        })
        .done(function (data) {
            console.log(data);
            if (!data.success) {
                if (data.errors.code_numbers) {
                $("#code-group").addClass("has-error");
                $("#code-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.code_numbers + "</div>"
                );
                }
            } else {
                $(".access").remove();  
                $("head").html(
                    data.redirect
                );
            }
        })
        .fail(function (data) {
            if (!data.success) {
                $("form").html(
                '<div  style="color:#C0694E;" class="alert alert-danger">Could not reach server, please try again later.</div>'
                );
            }
        });
      event.preventDefault();
    });
  });
