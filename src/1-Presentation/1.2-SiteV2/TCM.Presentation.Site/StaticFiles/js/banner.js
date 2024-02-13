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
    $("#formBanner").submit(function (event) {

        var form = $("#formBanner")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else { 


            var formU = $('#formBanner')[0];

            var formData = new FormData(formU);

            formData.append("redirectTo", $("#redirectTo").val())
            formData.append("password", $("#password").val())
            formData.append("imageUpload", $("#imageUpload")[0])

            $.ajax({
                method: 'POST',
                url: "/ManagerBannerTop/ProcessForm",
                data: formData,
                enctype: 'multipart/form-data',
                dataType: 'json',
                contentType: false,
                encode: true,
                processData: false,
                cache: false,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
        }
      event.preventDefault();
    });

    $("#formBannerMiddle").submit(function (event) {

        var form = $("#formBannerMiddle")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {


            var formU = $('#formBannerMiddle')[0];

            var formData = new FormData(formU);

            formData.append("redirectTo", $("#redirectTo").val())
            formData.append("password", $("#password").val())
            formData.append("imageUpload", $("#imageUpload")[0])
            formData.append("video", $("#typeBanner").is(':checked'))

            $.ajax({
                method: 'POST',
                url: "/ManagerBannerMiddle/ProcessForm",
                data: formData,
                enctype: 'multipart/form-data',
                dataType: 'json',
                contentType: false,
                encode: true,
                processData: false,
                cache: false,
                success: AjaxSucceeded,
                error: AjaxFailed
            });
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