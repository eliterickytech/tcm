$(document).ready(function () {
    $("form").submit(function (event) {
        var spinner = $('#loader');
        var formData = {
            password: document.querySelector('[name="password"]').value,
            confirm_password: document.querySelector('[name="confirm-password"]').value,
            username: document.querySelector('[name="username"]').value,
            email: document.querySelector('[name="email"]').value,
            mobile: document.querySelector('[name="mobile"]').value,
            session: document.querySelector('[name="session"]').value,
        };
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();  
        var dados = JSON.stringify(formData);
        spinner.show();
        $.ajax({
            type: "POST",
            url: "sign-up.php",
            data: {data: dados},
            dataType: "json",
            encode: true,
        })
        .done(function (data) {
            spinner.hide();
            console.log(data);
            if (!data.success) {
                if (data.errors.password) {
                $("#password-group").addClass("has-error");
                $("#password-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.password + "</div>"
                );
                }
                if (data.errors.confirm_password) {
                $("#confirm-password-group").addClass("has-error");
                $("#confirm-password-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.confirm_password + "</div>"
                );
                }
                if (data.errors.email) {
                $("#email-group").addClass("has-error");
                $("#email-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.email + "</div>"
                );
                }
                if (data.errors.username) {
                $("#username-group").addClass("has-error");
                $("#username-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.username + "</div>"
                );
                }
                if (data.errors.mobile) {
                $("#mobile-group").addClass("has-error");
                $("#mobile-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + data.errors.mobile + "</div>"
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
            spinner.hide();
            if (!data.success) {
                $("form").html(
                '<div  style="color:#C0694E;" class="alert alert-danger">Could not reach server, please try again later.</div>'
                );
            }
        });
      event.preventDefault();
    });
  });
