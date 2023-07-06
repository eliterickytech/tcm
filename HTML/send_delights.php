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
$result = array();
$list_users = array();
$openImageBase64 = "";
//####################################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
if(isset($_GET['collection_hash'])) {$collection_hash = $_GET['collection_hash'];}
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
        ////#############
        $get_collections_plataform = "SELECT * FROM collections LEFT JOIN collections_pieces ON collections.collection_hash = collections_pieces.collection_master_hash WHERE collections.collection_type > 3 OR collections.collection_type = 3";
        if(!$get_collections_plataform = get_all_data($get_collections_plataform, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          foreach($get_collections_plataform as $item) {
              $result[] = array(
                  'collection_type' => $item['collection_type'],
                  'collection_image' => $item['collection_image'],
                  'collection_hash' => $item['collection_hash'],
                  'collection_piece_id' => $item['collection_piece_id'],
                  'collection_piece_image' => $item['collection_piece_image']
              );
          }
        }
        //###############
        $get_users = "SELECT * FROM users Where user_group = '0' ORDER BY user_name";
        if(!$get_users = get_all_data($get_users, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          foreach($get_users as $item) {
            $list_users[] = array(
                  'user_id' => $item['user_id'],
                  'user_registry_key' => $item['user_registry_key'],
                  'user_name' => $item['user_name']
              );
          }
        }
        //############### 
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
    <title>Operador send dekights</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/share_collection.js?v=" + versionUpdate;  
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
                    <form action="#" method="POST">
                        <div class="area_form">
                            <input type="text" name="search" class="search" placeholder="Search">
                            <img class="icon_search" src="img/Icon_Search.png" alt="">
                        </div>
                    </form>
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
                    <div class="send_delights">
                        <div class="send_delights_int">
                            <div class="area_send_delights">
                                <div class="title_send_delights">
                                    <h2>Send delights</h2>
                                </div>
                                <div class="area_btn_send_delights">
                                    <form action="#" method="POST">
                                        <button id="random-button" name="random-button" class="btn_send_delights"><h2>SENT RANDOMLY</h2></button>
                                        <input type="hidden" id="type" name="type" value="0">
                                        <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
                                        <input type="hidden" name="session" value="<?php echo session_id();?>">
                                        <input type="hidden" name="collection_hash" value="<?php echo $collection_hash;?>">
                                    </form>
                                    <div class="randomly_text">
                                        <p> You can send delights randomly once a day.</p>
                                        <div id="share-group" style="margin-top: 30px;"></div>
                                        <div id="session-group" style="margin-top: 5px;"></div>
                                        <div style="color:#C0694E;" class="help-block"></div>
                                    </div>
                                </div>
                                <div class="user_delights">
                                    <h2>Choose by username</h2>
                                </div>
                                <?php foreach ($list_users as $itemUser):?>
                                    <div class="user_name_delights">
                                        <h2><?php echo(isset($itemUser['user_name']) ? $itemUser['user_name'] : '');?></h2>
                                    </div>
                                        <form action="#" method="POST">
                                            <div class="area_radio" style="max-width: 425px; overflow-x: scroll; overflow-y: hidden; white-space: nowrap;">
                                                <?php foreach ($result as $itemCollection):?>
                                                    <div class="area_radio_int">
                                                        <input type="radio" class="radio">
                                                        <div class="box_radio">
                                                            <?php if(isset($itemCollection['collection_type']) && $itemCollection['collection_type'] == "3"):?>
                                                                <!--//Item Single-->
                                                                <?php echo(isset($itemCollection['collection_image']) ? "<img width='38px' height='38px' src=".$itemCollection['collection_image'].">" : '');?>
                                                            <?php else:?>
                                                                <!--//Item 2x2 ou 3x3 -->
                                                                <?php 
                                                                    if(isset($itemCollection['collection_piece_image'])){
                                                                        $openImageBase64 = "";
                                                                        $myFile = $itemCollection['collection_piece_image'];
                                                                        $fh = fopen($myFile, 'r');
                                                                        $theData = fread($fh, filesize($myFile));
                                                                        fclose($fh);
                                                                        $openImageBase64 = $theData;
                                                                    }
                                                                ?>
                                                                <?php echo(isset($openImageBase64) ? "<img width='38px' height='38px' src=".$openImageBase64.">" : '');?>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                <?php endforeach;?>
                                            </div>
                                            <div class="send_user">
                                                <input type="submit" value="send >">
                                            </div>
                                        </form>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
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
</body>
</html>