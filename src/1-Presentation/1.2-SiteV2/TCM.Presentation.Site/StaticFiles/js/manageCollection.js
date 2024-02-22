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
function stringToDate(dateString, hourString) {
    return moment(dateString + ' ' + hourString, 'MM/DD/YYYY hh:mm A').format('MM/DD/YYYY HH:mm:ss');
}

function AjaxFailed(result) {
    if (result.errors != null) {
        handleGritterNotificationMessages("Message danger", result.errors);
    };

}

$(document).ready(function () {

    $('button[name="delete"]').click(function () {

        var id = $(this).data("id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-theme me-1 mb-1",
                cancelButton: "btn btn-default active me-1 mb-1"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: 'Are you sure you are going to delete the collection?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: `/ManagerCollection/DeleteCollection?id=${id}`,
                    dataType: 'json',
                    contentType: 'application/json',
                    encode: true,
                    success: AjaxSucceeded,
                    error: AjaxFailed
                });
            }
        });

    });

    if ($("#formNewCollection").length > 0) {
        $("#formNewCollection").submit(function (event) {

            var form = $("#formNewCollection")
            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
            }
            else {
                var formatDateHour = stringToDate($("#availableAt").val(), $("#timepicker").val());
                var formData = {
                    "CollectionName": $("#collectionName").val(),
                    "CollectionDescription": $("#shortenedName").val(),
                    "AvaiableAt": formatDateHour,
                    "CollectionType": $("#collectiontype").val()
                };

                $.ajax({
                    type: 'POST',
                    url: "/ManagerCollection/SaveNewCollection",
                    data: JSON.stringify(formData),
                    dataType: 'json',
                    contentType: 'application/json',
                    encode: true,
                    success: AjaxSucceeded,
                    error: AjaxFailed
                });
            }
            event.preventDefault();
        });
    };

    if ($("#formUploadProcessImage").length > 0){
        FormMultipleUpload.init();
    }

    if ($('#formNewCollection').length > 0) {
        var formatDate = moment().format("MM/DD/yyyy");

        $("#availableAt").val(formatDate)
        $("#divavailableAt").datepicker({
            format: 'mm/dd/yyyy',
            todayHighlight: true,
            autoclose: true
        });

        $("#timepicker").timepicker();

        $.ajax({
            type: 'GET',
            url: `/ManagerCollection/ListCollection`,
            dataType: 'json',
            contentType: 'application/json',
            encode: true,
            success: function (result) {
                $("#collectionName").autocomplete({
                    source: result.data
                });
            },
            error: AjaxFailed
        });

    }
    
    $("#btnAddCollection").click(function () {
        window.location.href = "/ManagerCollection/AddNewCollection";
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
var handleJqueryFileUpload = function () {
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        autoUpload: false,
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCCOLOR_REDentials: true},                
    });

    // Enable iframe cross-domain access via COLOR_REDirect option:
    $('#fileupload').fileupload(
        'option',
        'COLOR_REDirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // hide empty row text
    $('#fileupload').bind('fileuploadadd', function (e, data) {
        $('#fileupload [data-id="empty"]').hide();
    });

    // show empty row text
    $('#fileupload').bind('fileuploadfail', function (e, data) {
        var rowLeft = (data['originalFiles']) ? data['originalFiles'].length : 0;
        if (rowLeft === 0) {
            $('#fileupload [data-id="empty"]').show();
        } else {
            $('#fileupload [data-id="empty"]').hide();
        }
    });

    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
        $.ajax({
            type: 'HEAD'
        }).fail(function () {
            $('<div class="alert alert-danger"/>').text('Upload server currently unavailable - ' + new Date()).appendTo('#fileupload');
        });
    }

    // Load & display existing files:
    $('#fileupload').addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCCOLOR_REDentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), { result: result });
    });
};


var FormMultipleUpload = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleJqueryFileUpload();
        }
    };
}();