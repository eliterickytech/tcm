function AjaxSucceeded(result) {
    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);
        if (result.redirect != null) {
            setTimeout(function () {
                window.location.href = "ManagerCollection/Adm";
            }, 3000);
        }
    }
}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}
$(document).ready(function () {
    $("#imagemInput").change(function () {
        var inputFile = this;
        if (inputFile.files && inputFile.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#emptyFiles").attr("style", "display:none");
                $("#fullFiles").removeAttr("style");
                $("#fullFiles").addClass("fade show");
                $("#btn-save").removeAttr("style");
                $("#btn-save").addClass("d-block");
                $("#preview").html('<video width="350px" height="350px" src="' + e.target.result + '" controls><source width="350px" height="350px" src="' + e.target.result + '" type="video/mp4"><object><embed width="350px" height="350px" allowfullscreen="false" allowscriptaccess="always" type="application/x-shockwave-flash" src="' + e.target.result + '"></object></video>');
            };

            reader.readAsDataURL(inputFile.files[0]);
        }
    });

    $("#fileuploadSurprise").submit(function (event) {
        var form = $("#fileuploadSurprise")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {

            var formU = $('#fileuploadSurprise')[0];

            var formData = new FormData(formU);

            formData.append("imagemInput", $("#imagemInput")[0])
            formData.append("collectionId", 5);
            formData.append("collectionTypeId", $("#collectionTypeId").val());
            formData.append("collectionName", $("#collectionName").val());

            $.ajax({
                method: 'POST',
                url: "/ManagerCollection/ProcessFormSurprise",
                data: formData,
                enctype: 'multipart/form-data',
                dataType: 'json',
                contentType: false,
                encode: true,
                processData: false,
                cache: false,
                success: function (result) {

                    if (result.isOK) {
                        $("#registernewitems").removeAttr("style");


                        $("#collectionId").val(result.data.collectionId);
                        $("#collectionTypeId").val(result.data.collectionTypeId);
                        $("#urlimagedmini").val(result.data.url);
                        $("#collectionDescription").val(result.data.collectionDescription);


                        var collectionTypeId = result.data.collectionId;

                        var collectionItemModelView = {
                            collectionId: result.data.collectionId,
                            collectionItems: [
                                {
                                    CollectionItemTypeId: 5,
                                    Url: result.data.url,
                                    Sequence: 99,
                                    Sort: 99,
                                    Description: $("#collectionSurprise_description").val()
                                },
                            ]
                        };

                        $.ajax({
                            method: 'POST',
                            url: "/ManagerCollection/SaveCollectionItemSurprise",
                            data: JSON.stringify(collectionItemModelView),
                            dataType: 'json',
                            contentType: 'application/json',
                            encode: true,
                            success: AjaxSucceeded,
                            error: AjaxFailed
                        });
                        
                        event.preventDefault();

                    }
                },
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
