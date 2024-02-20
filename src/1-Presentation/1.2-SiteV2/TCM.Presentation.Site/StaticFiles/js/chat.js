function AjaxSucceededAdd(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        window.location.href = result.redirect;
    }

}
function AjaxSucceeded(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {

    }
}
function AjaxSucceededList(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        redirect = "/Chat/Details?connectionUserId=" + $("#connectionUserId").val();
    }
}

function AjaxFailed(result) {

    if (result.errors != null) {

        handleGritterNotificationMessages("Message danger", result.errors);
    };
}
$(document).ready(function () {

    function atualizarPagina() {
        location.reload();
    }

    // Chama a função de atualização a cada 1 minuto (60000 milissegundos)
    setInterval(atualizarPagina, 60000);

    $("#chatBack").click(function (event) {

        window.location.href="/Chat/Index"
    });



    $(".widget-chat-body").scroll(function () {

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 20) {

            var username = $("#usernameConnectionChat")[0].innerHTML;
            $.ajax({
                type: 'GET',
                url: `/Chat/UpdateIsReaded?usernameConnectionChat=${username}`,
                dataType: 'json',
                contentType: 'application/json',
                encode: true,
                success: AjaxSucceededAdd,
                error: AjaxFailed
            });
        }
    });

    $("#formChat").submit(function (event) {

        var form = $("#formChat")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var formData = {
                "Message": $("#message").val(),
                "UserId": $("#userId").val(),
                "ConnectionUserId": $("#connectionUserId").val()
            };

            $.ajax({
                type: 'POST',
                url: "/Chat/Add",
                data: JSON.stringify(formData),
                dataType: 'json',
                contentType: 'application/json',
                encode: true,
                success: AjaxSucceededAdd,
                error: AjaxFailed
            });
        }
        event.preventDefault();
    });

});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()