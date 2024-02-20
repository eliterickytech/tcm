function AjaxSucceeded(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        window.location.href = result.redirect;
    }

}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}
$(document).ready(function () {

    $('button[name="activity"]').click(function () {

        var formData = {
            "activityId": $(this).data("activityid"),
            "userId": $(this).data("userid"),
        };

        $.ajax({
            type: 'POST',
            url: "/Activity/AddActivityIteration",
            data: JSON.stringify(formData),
            dataType: 'json',
            contentType: 'application/json',
            encode: true,
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
$('#mobile').inputmask('+1 (999) 999-9999');