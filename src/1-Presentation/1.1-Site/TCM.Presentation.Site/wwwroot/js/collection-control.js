$(document).ready(function(){
    $("#upload_miniature_button").click(function (event) {
        $("#fileupload_miniature").click();
    });

    $("#fileupload_miniature").change(async function uploadFile(){
        var spinner = $('#loader');
        let formData = new FormData(); 
        formData.append("file", fileupload_miniature.files[0]);
        formData.append("token", document.querySelector('[name="token"]').value);
        formData.append("type", document.querySelector('[name="type_minier"]').value);
        $("#collection_miniature-group").removeClass("has-error");
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
                $("#collection_miniature-group").addClass("has-error");
                $("#collection_miniature-group").append(
                    '<div style="color:#C0694E;" class="help-block">' + user.errors + "</div>"
                );
            } else {
                spinner.hide();
                $("#collection_miniature-group").removeClass("has-error");
                $(".help-block").remove();
                document.getElementById("collection_miniature").src = user.file;
                document.getElementById("img_new_miniature").value = 'http://homolocao.thechefmelo.com/' + user.file;
                document.getElementById("img_new_banner").value = 'http://homolocao.thechefmelo.com/' + user.file;
                if(!user.file){
                    alert('Error dont send image');
                } else {
                    //success >>
                }          
            }
        } catch(err) {
            alert(err);
        }
    });
    
    $("#save-single-image-collection").click(function (event) {
        saveChanges();
        async function saveChanges() {
            var spinner = $('#loader');
            var formData = {
                token: document.querySelector('[name="token"]').value,
                type: document.querySelector('[name="type"]').value,      
                img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                session: document.querySelector('[name="session"]').value,
                collection_hash: document.querySelector('[name="collection_hash"]').value,
                miniature_collection_piece_description: document.querySelector('[name="miniature_collection_piece_description"]').value,
                single_part_collection_piece_description: document.querySelector('[name="single_part_collection_piece_description"]').value,
                collection_available_now: document.querySelector('[name="collection_available_now"]').value,
                collection_date_available: document.querySelector('[name="collection_date_available"]').value,
                collection_time_available: document.querySelector('[name="collection_time_available"]').value,
                single: document.querySelector('[name="single"]').value,
            };
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();  
            var dados = JSON.stringify(formData);
            console.log(dados);
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

    $("#save-collection").click(function (event) {
        saveChanges();
        async function saveChanges() {
            var spinner = $('#loader');
            if(document.querySelector('[name="type"]').value == "4"){
                if(document.querySelector('[name="video"]').value == "0"){
                    var formData = {
                        token: document.querySelector('[name="token"]').value,
                        type: document.querySelector('[name="type"]').value,      
                        img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                        session: document.querySelector('[name="session"]').value,
                        collection_hash: document.querySelector('[name="collection_hash"]').value,
                        miniature_collection_piece_description: document.querySelector('[name="miniature_collection_piece_description"]').value,
                        collection_available_now: document.querySelector('[name="collection_available_now"]').value,
                        collection_date_available: document.querySelector('[name="collection_date_available"]').value,
                        collection_time_available: document.querySelector('[name="collection_time_available"]').value,
                        single: document.querySelector('[name="single"]').value,
                        image_part_1: document.querySelector('[name="imageid_1"]').value,
                        description_part_1: document.querySelector('[name="description_1"]').value,
                        image_part_2: document.querySelector('[name="imageid_2"]').value,
                        description_part_2: document.querySelector('[name="description_2"]').value,
                        image_part_3: document.querySelector('[name="imageid_3"]').value,
                        description_part_3: document.querySelector('[name="description_3"]').value,
                        image_part_4: document.querySelector('[name="imageid_4"]').value,
                        description_part_4: document.querySelector('[name="description_4"]').value,
                    };
                } else {
                    var formData = {
                        token: document.querySelector('[name="token"]').value,
                        type: document.querySelector('[name="type"]').value,      
                        img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                        session: document.querySelector('[name="session"]').value,
                        collection_hash: document.querySelector('[name="collection_hash"]').value,
                        collection_video_description: document.querySelector('[name="collection_video_description"]').value,
                        single: document.querySelector('[name="single"]').value,
                        video: document.querySelector('[name="video"]').value,                        
                    };
                }
            } 
            if(document.querySelector('[name="type"]').value == "5"){
                if(document.querySelector('[name="video"]').value < 1){
                    var formData = {
                        token: document.querySelector('[name="token"]').value,
                        type: document.querySelector('[name="type"]').value,      
                        video: document.querySelector('[name="video"]').value,
                        img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                        session: document.querySelector('[name="session"]').value,
                        collection_hash: document.querySelector('[name="collection_hash"]').value,
                        miniature_collection_piece_description: document.querySelector('[name="miniature_collection_piece_description"]').value,
                        collection_available_now: document.querySelector('[name="collection_available_now"]').value,
                        collection_date_available: document.querySelector('[name="collection_date_available"]').value,
                        collection_time_available: document.querySelector('[name="collection_time_available"]').value,
                        single: document.querySelector('[name="single"]').value,
                        
                        image_part_1: document.querySelector('[name="imageid_1"]').value,
                        description_part_1: document.querySelector('[name="description_1"]').value,
                        image_part_2: document.querySelector('[name="imageid_2"]').value,
                        description_part_2: document.querySelector('[name="description_2"]').value,
                        image_part_3: document.querySelector('[name="imageid_3"]').value,
                        description_part_3: document.querySelector('[name="description_3"]').value,
                        image_part_4: document.querySelector('[name="imageid_4"]').value,
                        description_part_4: document.querySelector('[name="description_4"]').value,

                        image_part_5: document.querySelector('[name="imageid_5"]').value,
                        description_part_5: document.querySelector('[name="description_5"]').value,
                        image_part_6: document.querySelector('[name="imageid_6"]').value,
                        description_part_6: document.querySelector('[name="description_6"]').value,
                        image_part_7: document.querySelector('[name="imageid_7"]').value,
                        description_part_7: document.querySelector('[name="description_7"]').value,
                        image_part_8: document.querySelector('[name="imageid_8"]').value,
                        description_part_8: document.querySelector('[name="description_8"]').value,
                        image_part_9: document.querySelector('[name="imageid_9"]').value,
                        description_part_9: document.querySelector('[name="description_9"]').value,
                    };
                } else {
                    var formData = {
                        token: document.querySelector('[name="token"]').value,
                        type: document.querySelector('[name="type"]').value,      
                        img_new_banner: document.querySelector('[name="img_new_banner"]').value,
                        session: document.querySelector('[name="session"]').value,
                        collection_hash: document.querySelector('[name="collection_hash"]').value,
                        collection_video_description: document.querySelector('[name="collection_video_description"]').value,
                        single: document.querySelector('[name="single"]').value,
                        video: document.querySelector('[name="video"]').value,                        
                    };
                }
            } 
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();  
            var dados = JSON.stringify(formData);
            console.log(dados);
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