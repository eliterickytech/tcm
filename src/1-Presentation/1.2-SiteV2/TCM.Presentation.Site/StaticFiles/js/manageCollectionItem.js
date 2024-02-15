function AjaxSucceeded(result) {
    if (!result.isOK) {
        handleGritterNotificationMessages("Message warning", result.errors);
    }
    else {
        handleGritterNotificationMessages("Message success", result.data);
        if (result.redirect != null) {
            setTimeout(function () {
                window.location.href = result.redirect;
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

                $("#preview").html('<a href="' + e.target.result + '" data-lightbox="gallery-group-1"><img src="' + e.target.result + '" class="img" style="width: 100px; height: 100px;"/></a>');
                $("#fileName").text(inputFile.files[0].name);
                $("#fileSize").text((inputFile.files[0].size / 1024).toFixed(2) + " KB");
            };

            reader.readAsDataURL(inputFile.files[0]);
        }
    });

    $("#formfileItems").submit(function (event) {
        var form = $("#formfileItems")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {
            var collId = $("#collectionId").val();
            var collectionTypeId = $("#collectionTypeId").val();
            if (collectionTypeId == 1) {
                var collectionItemModelView = {
                    collectionId: collId, 
                    collectionItems: [
                        {
                            CollectionItemTypeId: 6, 
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 4,
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection1_1").val(),
                            Sequence: 1,
                            Sort: 1,
                            Description: $("#collection1_1_description").val()
                        }
                    ]
                };

                $.ajax({
                    method: 'POST',
                    url: "/ManagerCollection/SaveCollectionItem",
                    data: JSON.stringify(collectionItemModelView),
                    dataType: 'json',
                    contentType: 'application/json',
                    encode: true,
                    success: AjaxSucceeded,
                    error: AjaxFailed
                });
            }
            if (collectionTypeId == 2) {
                var collectionItemModelView = {
                    collectionId: collId,
                    collectionItems: [
                        {
                            CollectionItemTypeId: 6,
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 4,
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection4_1").val(),
                            Sequence: 1,
                            Sort: 1,
                            Description: $("#collection4_1_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection4_2").val(),
                            Sequence: 2,
                            Sort: 2,
                            Description: $("#collection4_2_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection4_3").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection4_3_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection4_4").val(),
                            Sequence: 4,
                            Sort: 4,
                            Description: $("#collection4_4_description").val()
                        }
                    ]
                };

                $.ajax({
                    method: 'POST',
                    url: "/ManagerCollection/SaveCollectionItem",
                    data: JSON.stringify(collectionItemModelView),
                    dataType: 'json',
                    contentType: 'application/json',
                    encode: true,
                    success: AjaxSucceeded,
                    error: AjaxFailed
                });
            }
            if (collectionTypeId == 3) {
                var collectionItemModelView = {
                    collectionId: collId,
                    collectionItems: [
                        {
                            CollectionItemTypeId: 6,
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 4,
                            Url: $("#urlimagedmini").val(),
                            Sequence: 0,
                            Sort: 0,
                            Description: $("#collectionDescription").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_1").val(),
                            Sequence: 1,
                            Sort: 1,
                            Description: $("#collection9_1_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_2").val(),
                            Sequence: 2,
                            Sort: 2,
                            Description: $("#collection9_2_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_3").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_3_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_4").val(),
                            Sequence: 4,
                            Sort: 4,
                            Description: $("#collection9_4_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_5").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_5_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_6").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_6_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_7").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_7_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_8").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_8_description").val()
                        },
                        {
                            CollectionItemTypeId: 2,
                            Url: $("#urlimagecollection9_9").val(),
                            Sequence: 3,
                            Sort: 3,
                            Description: $("#collection9_9_description").val()
                        },
                    ]
                };

                $.ajax({
                    method: 'POST',
                    url: "/ManagerCollection/SaveCollectionItem",
                    data: JSON.stringify(collectionItemModelView),
                    dataType: 'json',
                    contentType: 'application/json',
                    encode: true,
                    success: AjaxSucceeded,
                    error: AjaxFailed
                });
            }

            event.preventDefault();
        }
    });
    $("#fileupload").submit(function (event) {
        var form = $("#fileupload")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        else {

            var formU = $('#fileupload')[0];

            var formData = new FormData(formU);

            formData.append("imagemInput", $("#imagemInput")[0])
            formData.append("collectionId", $("#collectionId").val());
            formData.append("collectionTypeId", $("#collectionTypeId").val());
            formData.append("collectionName", $("#collectionName").val());

            $.ajax({
                method: 'POST',
                url: "/ManagerCollection/ProcessForm",
                data: formData,
                enctype: 'multipart/form-data',
                dataType: 'json',
                contentType: false,
                encode: true,
                processData: false,
                cache: false,
                success: function (result) {
                    $("#registernewitems").removeAttr("style");
                    if (result.isOK) {
                        if (result.data.collectionTypeId == 1) {
                            $("#collectionId").val(result.data.collectionId);
                            $("#collectionTypeId").val(result.data.collectionTypeId);
                            $("#urlimagedmini").val(result.data.url);
                            $("#collectionDescription").val(result.data.collectionDescription);
                            $("#urlimagecollection1_1").val(result.data.splitImages[0]);
                            $("#collection1_1").html('<img src="' + result.data.splitImages[0] + '" class="img" style="width: 100px; height: 100px;"/>')
                        }
                        if (result.data.collectionTypeId == 2) {
                            $("#collectionId").val(result.data.collectionId);
                            $("#collectionTypeId").val(result.data.collectionTypeId);
                            $("#urlimagedmini").val(result.data.url);
                            $("#collectionDescription").val(result.data.collectionDescription);
                            $("#urlimagecollection4_1").val(result.data.splitImages[0]);
                            $("#urlimagecollection4_2").val(result.data.splitImages[1]);
                            $("#urlimagecollection4_3").val(result.data.splitImages[2]);
                            $("#urlimagecollection4_4").val(result.data.splitImages[3]);
                            $("#collection4_1").html('<img src="' + result.data.splitImages[0] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection4_2").html('<img src="' + result.data.splitImages[1] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection4_3").html('<img src="' + result.data.splitImages[2] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection4_4").html('<img src="' + result.data.splitImages[3] + '" class="img" style="width: 100px; height: 100px;"/>')
                        }
                        if (result.data.collectionTypeId == 3) {
                            $("#collectionId").val(result.data.collectionId);
                            $("#collectionTypeId").val(result.data.collectionTypeId);
                            $("#urlimagedmini").val(result.data.url);
                            $("#collectionDescription").val(result.data.collectionDescription);
                            $("#urlimagecollection9_1").val(result.data.splitImages[0]);
                            $("#urlimagecollection9_2").val(result.data.splitImages[1]);
                            $("#urlimagecollection9_3").val(result.data.splitImages[2]);
                            $("#urlimagecollection9_4").val(result.data.splitImages[3]);
                            $("#urlimagecollection9_5").val(result.data.splitImages[4]);
                            $("#urlimagecollection9_6").val(result.data.splitImages[5]);
                            $("#urlimagecollection9_7").val(result.data.splitImages[6]);
                            $("#urlimagecollection9_8").val(result.data.splitImages[7]);
                            $("#urlimagecollection9_9").val(result.data.splitImages[8]);

                            $("#collection9_1").html('<img src="' + result.data.splitImages[0] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_2").html('<img src="' + result.data.splitImages[1] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_3").html('<img src="' + result.data.splitImages[2] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_4").html('<img src="' + result.data.splitImages[3] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_5").html('<img src="' + result.data.splitImages[4] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_6").html('<img src="' + result.data.splitImages[5] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_7").html('<img src="' + result.data.splitImages[6] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_8").html('<img src="' + result.data.splitImages[7] + '" class="img" style="width: 100px; height: 100px;"/>')
                            $("#collection9_9").html('<img src="' + result.data.splitImages[8] + '" class="img" style="width: 100px; height: 100px;"/>')
                        }
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
