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
                document.getElementById("img_new_banner").value = 'http://homologacao.thechefmelo.com/' + user.file;
                if(!user.file){
                    alert('Error dont send image');
                } else {
                    //success//
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
            if(document.querySelector('[name="type"]').value < 4){
                var formData = {
                    token: document.querySelector('[name="token"]').value,
                    type: document.querySelector('[name="type"]').value,
                    collection_name: document.querySelector('[name="collection_name"]').value,            
                    img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                    session: document.querySelector('[name="session"]').value,
                    collection_hash: document.querySelector('[name="collection_hash"]').value,
                    single: document.querySelector('[name="single"]').value,
                };
            }
            if(document.querySelector('[name="type"]').value == "4" && document.querySelector('[name="video"]').value == "0"){
                var formData = {
                    token: document.querySelector('[name="token"]').value,
                    type: document.querySelector('[name="type"]').value,
                    collection_name: document.querySelector('[name="collection_name"]').value,            
                    img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                    session: document.querySelector('[name="session"]').value,
                    collection_hash: document.querySelector('[name="collection_hash"]').value,
                    imagem_part_1: document.querySelector('[name="part_1"]').value,
                    imagem_part_2: document.querySelector('[name="part_2"]').value,
                    imagem_part_3: document.querySelector('[name="part_3"]').value,
                    imagem_part_4: document.querySelector('[name="part_4"]').value,
                };
            }
            if(document.querySelector('[name="type"]').value == "5" && document.querySelector('[name="video"]').value == "0"){
                var formData = {
                    token: document.querySelector('[name="token"]').value,
                    type: document.querySelector('[name="type"]').value,
                    collection_name: document.querySelector('[name="collection_name"]').value,            
                    img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                    session: document.querySelector('[name="session"]').value,
                    collection_hash: document.querySelector('[name="collection_hash"]').value,
                    imagem_part_1: document.querySelector('[name="part_1"]').value,
                    imagem_part_2: document.querySelector('[name="part_2"]').value,
                    imagem_part_3: document.querySelector('[name="part_3"]').value,
                    imagem_part_4: document.querySelector('[name="part_4"]').value,
                    imagem_part_5: document.querySelector('[name="part_5"]').value,
                    imagem_part_6: document.querySelector('[name="part_6"]').value,
                    imagem_part_7: document.querySelector('[name="part_7"]').value,
                    imagem_part_8: document.querySelector('[name="part_8"]').value,
                    imagem_part_9: document.querySelector('[name="part_9"]').value,
                };
            }
            
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();  
            var dados = JSON.stringify(formData);
            //console.log(dados);
            spinner.show();
            $.ajax({
                type: "POST",
                url: "collection.php",
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
                        if (data.errors.collection_name) {
                            $("#collection_name-group").addClass("has-error");
                            $("#collection_name-group").append(
                                '<div style="color:#C0694E;" class="help-block">' + data.errors.collection_name + "</div>"
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