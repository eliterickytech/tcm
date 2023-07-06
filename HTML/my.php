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
if(empty(session_id())){
    session_start();
}	
//####################################################
ini_set('max_execution_time', 0);
ini_set('output_buffering', 'off'); 
ini_set('zlib.output_compression', false);
ob_end_flush(); while (@ob_end_flush());
ini_set('zlib.output_compression', false);
ini_set('implicit_flush', true);
ob_implicit_flush(true);
//####################################################
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header('Cache-Control: no-cache');
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
$collections_list = [];
$data_collection = [];
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
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
    $user_group = $data_token['user_group'];
    $forgot_password = $data_token['forgot_password'];
    //#####################################
    if($forgot_password > 0 || isset($_COOKIE['forgot'])){
        setcookie('forgot', '1', time() + (86400 * 30), "/");
        if(isset($_COOKIE['forgot'])) {
            if($user_group == "1"){
                //only admin
                if(!$_COOKIE['forgot'] > 0){
                    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/profile-update.php?token=" . $access_token_seting . "'/>";
                }
            } else {
                echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
            }
        }
    } else {
        setcookie('forgot', '', time() - 3600, "/");
    }
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
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Home</title>
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
                    <div class="banner_home">
                        <?php if(isset($banner)):?>
                            <a target="_self" href="<?php echo "https://thechefmelo.com/banner-manager.php?token=".$access_token_seting . "&v=".$time;?>">
                                <img width="375px" height="70px" src="<?php echo(isset(array_values($banner)[4]) ? array_values($banner)[4] : '<img width="375px" height="200px" src="https://thechefmelo.com/img/banner-blank.png" />');?>" alt="<?php echo(isset(array_values($banner)[1]) ? array_values($banner)[1] : '');?>">
                            </a>
                        <?php else:?>
                            <img width="375px" height="200px" src="https://thechefmelo.com/img/banner-blank.png" />
                        <?php endif;?>
                    </div>
                    <div class="area_video">                        
                        <img width="100px" height="100px" class="play" src="img/play.png" alt="">
                        <?php if(isset($bannerBig)):?>
                            <a target="_self" href="<?php echo "https://thechefmelo.com/banner-manager-two.php?token=".$access_token_seting . "&v=".$time;?>">
                                <img width="375px" height="200px" src="<?php echo(isset(array_values($bannerBig)[4]) ? array_values($bannerBig)[4] : 'https://thechefmelo.com/img/banner-big-blank.png');?>" alt="<?php echo(isset(array_values($bannerBig)[1]) ? array_values($bannerBig)[1] : '');?>" />
                            </a>
                        <?php else:?>
                            <img width="375px" height="200px" src="https://thechefmelo.com/img/banner-big-blank.png" />
                        <?php endif;?>
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
                    <div class="area_admin_view">
                        <div class="admin_view">
                            <h2>admin view</h2>
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
</body>
</html>