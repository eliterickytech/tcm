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
//####################################################
$errors = [];
$data = [];
$data_send = [];
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
$time = "";
$collections_list = [];
$data_collection = [];
$forgot_password = 0;
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//print_r($access_token_seting);
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
    //echo $key . " = " . $value . "<br/>";
}
if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    echo "<pre>";
    print_r($data_token);
    echo "</pre>";
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
    $user_group = $data_token[0]['user_group'];
    $forgot_password = $data_token['forgot_password'];
    
    //#####################################
    if($user_group < 1){
        setcookie('forgot', '1', time() + (86400 * 30), "/");
        echo "Cookie: " . $_COOKIE['forgot'] . "<br/>";
        if($_COOKIE['forgot'] == "1") {
            exit('<br/>Debug ##01 ' . $user_group);
            echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/my_profile-update.php?token=" . $access_token_seting . "'/>";
        } else {
            echo "Cookie: " . $_COOKIE['forgot'] . "<br/>";
            print_r($data_token);
            exit('<br/>Debug ##02 ' . $user_group);
            echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
        } 
    } else {
        setcookie('forgot', '', time() - 3600, "/");
    }
    exit('<br/>Debug ##03 ' . $user_group);
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "0"){
        //exit('Debug ##02');
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
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1' ORDER BY collection_id DESC LIMIT 0,10";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $collections_list = get_all_data($get_data_sql, $connection);
        //print_r($collections_list);
        //exit('debug collections');
        ////###############
    }
} else {
    //exit('Debug ##03');
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Home Operador</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
</head>
<body>
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
                                            <nav>
                                                <?php require_once("menu-nav.php");?>
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
                    <div class="banner_home">
                        <?php if(isset($banner)):?>
                            <?php echo(isset(array_values($banner)[3]) ? '<a href="'.array_values($banner)[3].'" target="_blank">' : '');?>
                                <img width="375px" height="70px" src="<?php echo(isset(array_values($banner)[4]) ? array_values($banner)[4] : '');?>" alt="<?php echo(isset(array_values($banner)[1]) ? array_values($banner)[1] : '');?>">
                            <?php echo(isset(array_values($banner)[3]) ? '</a>' : '');?>
                        <?php endif;?>
                    </div>
                    <div class="area_video">
                        <img width="100px" height="100px" class="play" src="img/play.png" alt="">
                        <img width="355px" height="200px" src="img/video_home.png" alt="">
                    </div>
                    <a href="#">
                        <div class="btn_home_1">
                            <a href="https://melopatisserie.com/" target="_blank">  
                                <h2>VISIT THE WEBSITE</h2>
                            </a>
                        </div>
                    </a>
                    <div class="bar"></div>
                    <div class="title_community">
                        <h2>Collectible delights in the Community</h2>
                    </div>
                    <div class="area_community" style="max-width: 425px; overflow-x: scroll; overflow-y: hidden; white-space: nowrap;">
                        <?php if(isset($collections_list)):?>
                            <?php foreach($collections_list as $data_collection):?>
                                <div class="community">                                                                        
                                    <img width="80px" height="60px" src="<?php echo(!empty($data_collection['collection_miniature']) ? $data_collection['collection_miniature'] : '');?>" alt="<?php echo(isset($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>">
                                    <h2><?php echo(!empty($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?></h2>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <a href="#">
                        <div class="btn_home_2">
                            <a href="<?php echo "https://thechefmelo.com/chat.php?token=".$access_token_seting . "&v=".$time;?>">
                                <h2>CHAT WITH US</h2>
                            </a>
                        </div>
                    </a>
                    <div class="menu_footer">
                        <div class="menu_footer_int">
                            <div class="area_menu_footer">
                                <?php require_once("menu-footer.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>