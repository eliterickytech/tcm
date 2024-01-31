function AjaxSucceeded(result) {

    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }

}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}
$(document).ready(function () {

    $("#formSearch").submit(function (event) {

        var form = $("#formSearch")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var username = $("#searchUser").val();

            window.location.href = `/Search/SearchUser?username=${username}`
        }
      event.preventDefault();
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
