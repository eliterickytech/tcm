<?php
//####################################################
//####################################################
//####################################################
//Projeto Contratado Via Workana
//Desenvolvedor Giovanni Barbosa
//https://www.workana.com/freelancer/8f1f0c0f1e3374c5aecbd8edb6a19a06
//#####################################################
//#####################################################
//#####################################################
require_once("header.php");
require_once("variables.php");
//####################################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//####################################
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}
//
if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
    $user_group = $data_token['user_group'];
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "1"){
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
    } else {
        ////###############
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1'";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //############### get_total_rows($sSQL = NULL, $connection)
        if (!$total_collections = get_total_rows($get_data_sql, $connection)) {
          $total_collections = 0;
        }
        ////###############
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Operador insert collection 3x3 page</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/collection.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</head>
<body onload="onLoad()" class="access">
    <section id="container_home">
        <div class="container_home">
            <div class="container_home_int">
                <div class="area_home">
                    <div class="menu_header">
                        <div class="icon_menu">
                            <nav class="nav">
                                <input type="checkbox" class="checkbox" id="checkbox">
                                <label for="checkbox" class="label_menu">
                                    <!--<img width="27px" height="27px" src="img/Icon_Menu.png" alt="">-->
                                    <span class="menu_hamburguer"></span>
                                </label>
                                <div class="container_menu home">
                                    <div class="container_menu_int">
                                        <div class="area_menu">
                                            <div class="logo_menu">
                                                <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                                            </div>
                                            <div class="social_icons">
                                                <img src="img/instagram.png" alt="">
                                                <img src="img/facebook.png" alt="">
                                                <img src="img/world.png" alt="">
                                            </div>
                                            <div class="admin">
                                                <h2>admin console</h2>
                                            </div>
                                            <nav>
                                                <?php require_once("menu-admin-nav.php");?>
                                            </nav>
                                        </div>
                                    </div>
                                    <footer>
                                        <div class="collectibles">
                                            <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                                            <h2>My Collectibles</h2>
                                        </div>
                                    </footer>
                                </div>
                            </nav>
                        </div>
                        <div class="logo_home">
                            <img width="30px" height="30px" src="img/logo_small.png" alt="Patisserie">
                            <div class="collectibles_home">
                                <h2>My Collectibles</h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="area_form">
                        <input type="text" name="search" class="search" placeholder="Search">
                        <img class="icon_search" src="img/Icon_Search.png" alt="">
                    </div>

                    <div class="area_profile_single">
                        <div class="area_profile_int_single">
                            <div class="profile_single_admin">
                                <div class="title_profile_single">
                                    <img width="30px" height="30px" src="img/profile.png" alt="">
                                    <div class="texts_profile_single">
                                        <h2>Chef_melo</h2>
                                        <p><?php echo(isset($total_collections) ? $total_collections : '0');?> collections available.</p>
                                    </div>
                                </div>
                                <div class="single_admin">
                                    <h2>admin view</h2>
                                </div>
                            </div>
                            <div class="icons_profile_single">
                                <?php require_once("menu-collections.php");?>
                            </div>
                        </div>
                    </div>
                    <div class="bar"></div>                    
                        <div class="area_grid_collectible">
                        <div class="area_grid_collectible_int">
                            <div class="area_texts_collectible">
                                <div class="title_collectible">
                                    <h2><strong>Collections</strong></h2>
                                </div>
                                <div class="page_collectible">
                                <select name="pages" id="pages" style="background-color: #FFF; border: none;" onchange="changePage()" onblur="changePage()">
                                    <option value="3">Single</option>
                                    <option value="4">2x2 grid</option>
                                    <option value="5" selected>3x3 grid</option>
                                </select>
                                </div>
                            </div>
                            <div>
                                <button id="upload-button" style="border:none; background-color: #FFF;">
                                    <img max-width="350px" max-height="0px" src="./img/background_empty.png">
                                    <table cellspacing="0" cellpadding="0" style="background-color: #FFF; width:100%; margin-top: -350px; padding: 0px; border-collapse: separate; border-spacing: 2px 0px; border: 0px;">
                                        <tr style="padding: 0px; margin: 0px;">
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_1" name="imageid_1" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_2" name="imageid_2" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_3" name="imageid_3" src="./img/part.png"></td>
                                        </tr>
                                        <tr style="padding: 0px; margin: 0px;">
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_4" name="imageid_4" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_5" name="imageid_5" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_6" name="imageid_6" src="./img/part.png"></td>
                                        </tr>
                                        <tr style="padding: 0px; margin: 0px;">
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_7" name="imageid_8" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_8" name="imageid_9" src="./img/part.png"></td>
                                            <td><img style="width: 99.5%;" max-width="116px" max-height="0px" id="imageid_9" name="imageid_9" src="./img/part.png"></td>
                                        </tr>
                                    </table>
                                </button>
                            </div>
                            <form action="#" method="POST">
                                <div class="area_next">
                                    <input type="text" class="collection_next" name="collection_name" id="collection_name" placeholder="Tap to give your collection a name*" autocomplete="off">
                                    <input type="submit" value="NEXT" class="next">
                                </div>
                                <div class="wrapper" style="display:none;">
                                    <input id="fileupload" type="file" name="fileupload"/> 
                                    <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
                                    <input type="hidden" name="type" value="5">
                                    <input type="hidden" name="video" id="video" value="0">
                                    <input type="hidden" name="session" value="<?php echo session_id();?>">
                                    <input type="hidden" id="img_new_banner" name="img_new_banner">
                                    <img id="imageid" style="display: none;">
                                    <input type="hidden" id="img_base64" name="img_base64">
                                    <input type="hidden" id="collection_hash" name="collection_hash" value="<?php echo sha1(time()) . "-" .uniqid() . "-" . time();?>">
                                    <input type="hidden" id="part_1" name="part_1">
                                    <input type="hidden" id="part_2" name="part_2">
                                    <input type="hidden" id="part_3" name="part_3">
                                    <input type="hidden" id="part_4" name="part_4">
                                    <input type="hidden" id="part_5" name="part_5">
                                    <input type="hidden" id="part_6" name="part_6">
                                    <input type="hidden" id="part_7" name="part_7">
                                    <input type="hidden" id="part_8" name="part_8">
                                    <input type="hidden" id="part_9" name="part_9">
                                </div>
                                <div id="collection_name-group" style="margin-top: 30px;"></div>
                                <div id="img_new_banner-group" style="margin-top: 5px;"></div>
                                <div id="session-group" style="margin-top: 5px;"></div>
                                <div style="color:#C0694E;" class="help-block"></div>
                            </form>
                        </div>
                    </div>
                    </form>
                    <div class="menu_footer">
                        <div class="menu_footer_int">
                            <div class="area_menu_footer">
                                <?php require_once("menu-admin-footer.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="loader"></div>

    <script>
        $(document).ready(function() { 
            const NewCollection = document.querySelector('#imageid');

            NewCollection.addEventListener("load", () => {
                var spinner = $('#loader');
                spinner.show();
                console.log("The image has loaded!");
                const img_base = document.getElementById('imageid').src;
                console.log(img_base);
                ConvertBase64(img_base, function(dataURL){
                    console.log(dataURL);
                });
                spinner.hide();
            });
            
        });
    </script>

    <script type="text/javascript">
    
    function ConvertBase64(src, callback){
        var image = new Image();
        image.crossOrigin = 'Anonymous';
        image.onload = function(){
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        canvas.height = this.naturalHeight;
        canvas.width = this.naturalWidth;
        context.drawImage(this, 0, 0);
        var dataURL = canvas.toDataURL('image/jpeg');
        document.getElementById('img_base64').src = dataURL;
        
        var w2 = image.width / 3;
        var h2 = image.height / 3;
        const parts = [];

        for(var i=0; i<9; i++) {
            var x = (-w2*i) % (w2*3),
                y = (h2*i)<=h2? 0 : -h2 ;

            canvas.width = w2;
            canvas.height = h2;
            
            if(i < 2){
                context.drawImage(this, x, y, w2*3, h2*3);
            } 
            if(i == "2"){
                x=-233.33333333333337;
                y=0;
                context.drawImage(this, x, y, w2*3, h2*3);
            }
            if(i>2 || i<6){
                context.drawImage(this, x, y, w2*3, h2*3);
            }
            if(i=="6"){
                x=0;
                y=-233.33333333333337;
                context.drawImage(this, x, y, w2*3, h2*3);
            } 
            if(i=="7"){
                x=-116.66666666666669;
                y=-233.33333333333337;
                context.drawImage(this, x, y, w2*3, h2*3);
            } 
            if(i=="8"){
                x=-233.33333333333337;
                y=-233.33333333333337;
                context.drawImage(this, x, y, w2*3, h2*3);
            } 
            console.log('i='  + i  + ' x=' + x + ' y=' + y + ' w2=' + w2*3 + ' h2=' + h2*3);

            parts.push( canvas.toDataURL() );

            var slicedImage = document.createElement('img')
            if(i == "0"){
                document.getElementById('imageid_1').src = parts[i];
                document.getElementById('part_1').value = parts[i];
            }
            if(i == "1"){
                document.getElementById('imageid_2').src = parts[i];                
                document.getElementById('part_2').value = parts[i];
            }
            if(i == "2"){
                document.getElementById('imageid_3').src = parts[i];                
                document.getElementById('part_3').value = parts[i];
            }
            if(i == "3"){
                document.getElementById('imageid_4').src = parts[i];                
                document.getElementById('part_4').value = parts[i];
            }
            if(i == "4"){
                document.getElementById('imageid_5').src = parts[i];                
                document.getElementById('part_5').value = parts[i];
            }
            if(i == "5"){
                document.getElementById('imageid_6').src = parts[i];                
                document.getElementById('part_6').value = parts[i];
            }
            if(i == "6"){
                document.getElementById('imageid_7').src = parts[i];                
                document.getElementById('part_7').value = parts[i];
            }
            if(i == "7"){
                document.getElementById('imageid_8').src = parts[i];                
                document.getElementById('part_8').value = parts[i];
            }
            if(i == "8"){
                document.getElementById('imageid_9').src = parts[i];                
                document.getElementById('part_9').value = parts[i];
            }

            
        }

        callback(dataURL);
        };
        image.src = src;
    }
    
    

    
    function changePage(){
      let page = document.getElementById("pages").value;
      if(page == "3"){
        window.location = "<?php echo "https://thechefmelo.com/collections-insert.php?token=".$access_token_seting . "&v=".$time;?>";
      }
      if(page == "4"){
        window.location = "<?php echo "https://thechefmelo.com/collections-insert-2x2.php?token=".$access_token_seting . "&v=".$time;?>";
      }
      if(page == "5"){
        window.location = "<?php echo "https://thechefmelo.com/collections-insert-3x3.php?token=".$access_token_seting . "&v=".$time;?>";
      }
    }
    </script>
</body>
</html>