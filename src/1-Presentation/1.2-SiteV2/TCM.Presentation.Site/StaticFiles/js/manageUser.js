function AjaxSucceeded(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);
        setTimeout(function () {
            window.location.href = result.redirect;
        }, 3000);
    }

}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}
$(document).ready(function () {
    $("#profile").click(function () {
        var userId = $(this).data("userid");
        window.location.href = `/Profile/ProfileConnection?connectionUserId=${userId}`;
    });

    $("#chat").click(function () {
        var userId = $(this).data("userid");
        window.location.href = `/Chat/Details?connectionUserId=${userId}`;
    });
    $("#cancelled").click(function (event) {
        event.preventDefault();
        var userId = $(this).data("userid");
        var dinamicText = ""

        $.ajax({
            url: "/ManagerUser/DisabledUser",
            type: "POST",
            data: { "userId": userId },
            success: AjaxSucceeded,
            error: AjaxFailed
        });

    });
    $("#enabled").click(function (event) {
        event.preventDefault();
        var userId = $(this).data("userid");
        var dinamicText = ""

        $.ajax({
            url: "/ManagerUser/EnabledUser",
            type: "POST",
            data: { "userId": userId },
            success: AjaxSucceeded,
            error: AjaxFailed
        });

    });

});
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
