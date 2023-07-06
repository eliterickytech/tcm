$(document).ready(function () {
    $("form").submit(function (event) {
        var spinner = $('#loader');
        var formData = {
            user_email: document.querySelector('[name="email"]').value,
            password: document.querySelector('[name="password"]').value,
            confirm_email: document.querySelector('[name="confirm-email"]').value,
            type: document.querySelector('[name="type"]').value,
            session: document.querySelector('[name="session"]').value,
            token: document.querySelector('[name="token"]').value,
            user_group: document.querySelector('[name="user_group"]').value,
        };
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();  
        var dados = JSON.stringify(formData);
        spinner.show();
        $.ajax({
            type: "POST",
            url: "user-admin.php",
            data: {data: dados},
            dataType: "json",
            encode: true,
        })
        .done(function (data) {
            spinner.hide();
            console.log(data);
            if (!data.success) {
                if (data.errors.password) {
                    alert(data.errors.password);
                }
                if (data.errors.email) {
                    alert(data.errors.email);
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
