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

    $("#delete").click(function () {
        var id = $(this).data("id");

        swal({
            title: 'Are you sure?',
            text: 'Are you sure you are going to delete the collection?',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Yes, delete it!',
                    value: true,
                    visible: true,
                    className: 'btn btn-theme',
                }
            }
        }).then((result) => {
            if (result == true) {
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
