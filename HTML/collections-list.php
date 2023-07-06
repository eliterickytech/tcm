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
$collections_list = [];
$data_collection = [];
$collection_hash = "";
$x = 1;
$collection_selected = [];
$first_collection = [];
$total_collections = 0;
//####################################
$time = base64_encode(date('His'));
//####################################
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
        ////###############
        ////###############
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1' ORDER BY collection_id DESC";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
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
    <title>Operador single page</title>
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
                                        <?php if(isset($collections_list)):?>
                                            <?php foreach($collections_list as $data_collection):?>
                                                <div class="community">                                                                        
                                                    <img width="80px" height="60px" src="<?php echo(!empty($data_collection['collection_miniature']) ? $data_collection['collection_miniature'] : '');?>" alt="<?php echo(isset($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>">
                                                    <h2><?php echo(!empty($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?></h2>
                                                </div>
                                                <option value="<?php echo (!empty($data_collection['collection_hash']) ? $data_collection['collection_hash'] : '0'); ?>" <?php echo ((!empty($collection_hash) && $data_collection['collection_hash'] == $collection_hash) ? 'selected' : ''); ?>>Page <?php echo $x;?></option>
                                                <!-- START GET FIRST COLLECTION -->
                                                <?php if($x == "1"):?>
                                                    <?php $first_collection['first_image'] = $data_collection['collection_image'];?>
                                                    <?php $first_collection['first_name'] = $data_collection['collection_name'];?>
                                                <?php endif;?>
                                                <!-- END GET FIRST COLLECTION -->
                                                <!-- START GET SELECTED COLLECTION -->
                                                <?php if($data_collection['collection_hash'] == $collection_hash):?>
                                                    <?php $collection_selected['collection_image'] = $data_collection['collection_image'];?>
                                                    <?php $collection_selected['collection_name'] = $data_collection['collection_name'];?>
                                                <?php endif;?>
                                                <!-- END GET SELECTED COLLECTION -->                        
                                                <?php $x++;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <?php if(!empty($collection_hash)):?>
                                <div class="area_collection_single"><img width="350px" height="350px" src="<?php echo(!empty($collection_selected['collection_image']) ? $collection_selected['collection_image'] : '');?>" alt="<?php echo(isset($collection_selected['collection_name']) ? $collection_selected['collection_name'] : 'empty image');?>"></div>
                                <div class="collection_name">
                                    <h2><?php echo(!empty($collection_selected['collection_name']) ? $collection_selected['collection_name'] : 'empty name');?></h2>
                                </div>
                                <div class="area_dots">
                                    <div class="dot active"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>
                            <?php else:?>
                                <div class="area_collection_single"><img width="350px" height="350px" src="<?php echo(!empty($first_collection['first_image']) ? $first_collection['first_image'] : '');?>" alt="<?php echo(isset($first_collection['first_image']) ? $first_collection['first_image'] : 'empty image');?>"></div>
                                <div class="collection_name">
                                    <h2><?php echo(!empty($first_collection['first_name']) ? $first_collection['first_name'] : 'empty name');?></h2>
                                </div>
                                <div class="area_dots">
                                    <div class="dot active"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>
                            <?php endif;?>
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
    <script>
    function changePage(){
      const page = document.getElementById("pages").value;
      const link_page = "<?php echo "https://thechefmelo.com/collections-list.php?token=".$access_token_seting ."&v=".$time . "&collection_hash=";?>" + page;
      window.location = link_page;
    }
    </script>
</body>
</html>