$(document).ready(function(){
    $("#random-button").click(function (event) {
        saveChanges();
        event.preventDefault();
    });
    
    async function saveChanges() {
        var spinner = $('#loader');
        if(document.querySelector('[name="type"]').value < 1){
            var formData = {
                token: document.querySelector('[name="token"]').value,
                type: document.querySelector('[name="type"]').value,
                session: document.querySelector('[name="session"]').value,
                collection_hash: document.querySelector('[name="collection_hash"]').value,
            };
        }        
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();  
        var dados = JSON.stringify(formData);
        //console.log(dados);
        spinner.show();
        $.ajax({
            type: "POST",
            url: "share.php",
            data: {data: dados},
            dataType: "json",
            encode: true,
        })
        .done(function (data) {
            spinner.hide();
            try{
                console.log(data);
                if (!data.success) {
                    spinner.hide();
                    if (data.errors.share) {
                        $("#share-group").addClass("has-error");
                        $("#share-group").append(
                            '<div style="color:#C0694E;" class="help-block">' + data.errors.share + "</div>"
                        );
                    }
                    if (data.errors.session) {
                        $("#session-group").addClass("has-error");
                        $("#session-group").append(
                            '<div style="color:#C0694E;" class="help-block">' + data.errors.session + "</div>"
                        );
                    }
                } else {
                    spinner.hide();
                    $(".access").remove();  
                    $("head").html(
                        data.redirect
                    );
                }
            } catch(err) {
                '<div  style="color:#C0694E;" class="alert alert-danger">Error save database.</div>'
            }                
        })
        .fail(function (data) {
            spinner.hide();
            if (!data.success) {
                $("form").html(
                '<div  style="color:#C0694E;" class="alert alert-danger">Could not reach server, please try again later.</div>'
                );
            }
        });
    }
    
});