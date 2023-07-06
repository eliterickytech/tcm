$(document).ready(function(){
    $("#upload-button").click(function (event) {
        $("#fileupload").click();
    });

    $("#fileupload").change(async function uploadFile(){
        var spinner = $('#loader');
        let formData = new FormData(); 
        formData.append("file", fileupload.files[0]);
        formData.append("token", document.querySelector('[name="token"]').value);
        formData.append("type", document.querySelector('[name="type"]').value);
        $("#banner-group").removeClass("has-error");
        $(".help-block").remove();
        try {
            spinner.show();
            let response = await fetch('/upload.php', {
                method: "POST", 
                body: formData
            }); 
            let user = await response.json();
            if (!user.success) {
                spinner.hide();
                $("#banner-group").addClass("has-error");
                $("#banner-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + user.errors + "</div>"
                );
            } else {
                spinner.hide();
                $("#banner-group").removeClass("has-error");
                $(".help-block").remove();
                document.getElementById("imageid").src = user.file;
                document.getElementById("img_new_banner").value = 'https://thechefmelo.com/' + user.file;
                if(!user.file){
                    alert('Error dont send image');
                } else {
                    //success
                }          
            }
        } catch(err) {
            alert(err);
        }
    });
    
    $("form").submit(function (event) {
        saveChanges();
        async function saveChanges() {
            var spinner = $('#loader');
            var formData = {
                token: document.querySelector('[name="token"]').value,
                type: document.querySelector('[name="type"]').value,
                password: document.querySelector('[name="password"]').value,            
                img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                link_new_banner: document.querySelector('[name="link_new_banner"]').value,
                session: document.querySelector('[name="session"]').value,
            };
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();  
            var dados = JSON.stringify(formData);
            console.log(dados);
            spinner.show();
            $.ajax({
                type: "POST",
                url: "banner.php",
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
                        if (data.errors.password) {
                            $("#password-group").addClass("has-error");
                            $("#password-group").append(
                                '<div style="color:#C0694E;" class="help-block">' + data.errors.password + "</div>"
                            );
                        }
                        if (data.errors.img_new_banner) {
                            $("#img_new_banner-group").addClass("has-error");
                            $("#img_new_banner-group").append(
                                '<div style="color:#C0694E;" class="help-block">' + data.errors.img_new_banner + "</div>"
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
        event.preventDefault();
    });
    
});