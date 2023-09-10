$(document).ready(function () {
    $(".dropdown-item").click(function (event) {
        event.preventDefault();

        var collectionTypeId = $(this).data("collectiontypeid");
        $("#collectiontypeid").val(collectionTypeId);

    });

    $('#uploadForm').submit(function (e) {
        e.preventDefault(); 
        var collectiontypeid = $("#collectiontypeid").val();

        if (collectiontypeid == "") collectiontypeid = 1;

        const loading = $('#loader');
        loading.show();

        const file = $('#imagemInput')[0].files[0];
        const img = new Image();
        img.src = URL.createObjectURL(file);

        img.onload = function () {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = 350;
            canvas.height = 350;

            ctx.drawImage(img, 0, 0, 350, 350);

            const imagemRedimensionada = $('#resizeImage');
            imagemRedimensionada.empty();
            imagemRedimensionada.append(canvas);

            const dataURL = canvas.toDataURL("image/png");
            const originalFileName = file.name;

            $.ajax({
                url: "/ManagerCollection/ProcessForm",
                method: "POST",
                data: {
                    imageUploadResize: dataURL,
                    imageUploadOrigin: originalFileName,
                    collectiontypeid: collectiontypeid
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (a, b, c) {
                    console.log(b)
                }
             });

            loading.hide();
        };
    });
});