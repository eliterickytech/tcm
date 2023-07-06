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
//####################################
$errors = [];
$data = [];
$data_send = [];
$banner = [];
$bannerBig = [];
$user_email = "";
$login_code = 0;
$myFile = "";
$fh = "";
$theData = "";
$message = "";
$token = [];
$access_token = "";
$s_user_id = 0;
$user_id = 0;
$user_group = 0;
$get_data_sql = "";
$time = "";
$data_admin_user = [];
$data_user = [];
$user_id = 0;
$user_registry_key = "";
$i = 0;
$get_newst_five_feed_my_frieds = "";
$total_chat = 0;
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//####################################
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}
////
if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    $user_id = $data_token['user_id'];
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
        $get_data_sql = "SELECT * FROM banner WHERE banner_id = '1' and banner_type = '0' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //###############
        if (!$banner = get_all($get_data_sql, $connection)) {
            echo "Error conected database -> banner 0";
            exit();
        }
        $get_data_sql = "SELECT * FROM banner WHERE banner_id = '2' and banner_type = '1' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlTwo'] = $sSQL_Debug;
        //###############
        if (!$bannerBig = get_all($get_data_sql, $connection)) {
            echo "Error conected database -> banner 0";
            exit();
        }
        ////###############
        $get_data_sql = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $data_user = get_all_data($get_data_sql, $connection);
        //print_r($data_user);
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1' ORDER BY collection_id DESC LIMIT 0,10";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $collections_list = get_all_data($get_data_sql, $connection);
        //print_r($collections_list);
        //exit('debug collections');
        ////############### 
        $get_newst_five_feed_my_frieds = "SELECT f.*, u.user_name FROM feeds f INNER JOIN users u ON f.feed_my_user_id = u.user_id INNER JOIN connections c ON c.connection_my_friend_id = u.user_id WHERE c.connection_invite = 1 and c.connection_my_user_id = 1 ORDER BY f.feed_id DESC LIMIT 3";
        if(!$get_newst_five_feed_my_frieds = get_all_data($get_newst_five_feed_my_frieds, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          $result = array();
          foreach($get_newst_five_feed_my_frieds as $item) {
              $result[] = array(
                  'user_name' => $item['user_name'],
                  'feed_message' => $item['feed_message'],
                  'feed_date' => $item['feed_date'],
                  'feed_image' => $item['feed_image']
              );
          }
        }
        //print_r($get_newst_five_feed_my_frieds);
        //echo "<br/>############################<br/>";
        //print_r($result);
        //exit('Debug Comunnity');
        ////###############
        $total_chat = (int)get_total_rows("SELECT * FROM conversations WHERE conversation_read = '0' and conversation_sender = '$user_id' ", $connection);
        //#################
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
    <title>Community</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo $time;?>">
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/user_admin.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</head>

<body onload="onLoad()" class="access" style="background-color: #fff;">

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
                        <div class="area_form_community">
                            <input type="text" name="search" class="search_community" placeholder="Search">
                            <img class="icon_search_community" src="img/Icon_Search.png" alt="">
                        </div>
                    </form>


                    <div class="title_community">
                        <h2>Collectible delights in the Community</h2>
                    </div>

                    <div class="area_community">

                        <?php if(isset($collections_list)):?>
                            <?php foreach($collections_list as $data_collection):?>
                                <?php $i++;?>                                                                        
                                <img width="80px" height="60px" class="image-<?php echo $i;?>-icon" src="<?php echo(!empty($data_collection['collection_miniature']) ? $data_collection['collection_miniature'] : '');?>" alt="<?php echo(isset($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>">
                                <!-- <h2>
                                  <?php //echo(!empty($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>
                                </h2> -->
                            <?php endforeach;?>
                        <?php endif;?>

                    </div>

                    <div class="bar_community"></div>


                    <div class="friends_community">
                        <div class="title_friends_community">
                            <h2>Friend's activity</h2>
                        </div>

                        
                        <?php foreach($result as $item):?>
                            <div class="area_user_name_community">
                              <div class="user_name_community">
                                  <p><b><?php echo(isset($item['user_name']) ? $item['user_name'] : '');?></b> <?php echo(isset($item['feed_message']) ? $item['feed_message'] : '');?></p>
                                  <div class="date_community">
                                      <p><?php echo(isset($item['eed_date']) ? $item['feed_date'] : '');?></p>
                                  </div>
                              </div>
                              <div class="img_friend_community">
                                  <img src="" alt="">
                              </div>
                            </div>                          
                        <?php endforeach;?>

                        <div class="see_all_community">
                            <p>See all your connections</p>
                        </div>

                    </div>


                    <div class="bar_community"></div>

                    <div class="area_chats_community">
                        <div class="title_chats_community">
                            <h2>You have <b><?php echo $total_chat;?></b> unread chats</h2>
                        </div>
                        <div class="sub_chats_community">
                            <p>A strong community is made of sharing, love and good conversations!</p>
                        </div>
                        <div class="unread_chats">
                            <p>Go to your unread chats</p>
                        </div>
                    </div>                   


                    <div class="banner_home">
                        <?php if(isset($banner)):?>
                            <?php echo(isset(array_values($banner)[3]) ? '<a href="'.array_values($banner)[3].'" target="_blank">' : '');?>
                                <img width="375px" height="70px" src="<?php echo(isset(array_values($banner)[4]) ? array_values($banner)[4] : '');?>" alt="<?php echo(isset(array_values($banner)[1]) ? array_values($banner)[1] : '');?>">
                            <?php echo(isset(array_values($banner)[3]) ? '</a>' : '');?>
                        <?php endif;?>
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
</body>

</html>
