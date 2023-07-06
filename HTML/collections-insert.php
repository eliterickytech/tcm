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
$total_collections = 0;
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
    <title>Operador single page</title>
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
                                    <option value="3" selected>Single</option>
                                    <option value="4">2x2 grid</option>
                                    <option value="5">3x3 grid</option>
                                </select>
                                </div>
                            </div>
                            <div>
                                <button id="upload-button" style="border:none; background-color: #FFF;">
                                    <img max-width="350px" max-height="350px" id="imageid" src="https://thechefmelo.com/img/collection-single-part-blank.png">
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
                                    <input type="hidden" name="type" value="3">
                                    <input type="hidden" name="single" value="0">
                                    <input type="hidden" name="session" value="<?php echo session_id();?>">
                                    <input type="hidden" id="img_new_banner" name="img_new_banner">
                                    <input type="hidden" id="collection_hash" name="collection_hash" value="<?php echo sha1(time()) . "-" .uniqid() . "-" . time();?>">
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