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
    if(!$user_group == "0"){
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
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap"/>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </head>
  <body onload="onLoad()" class="access">
    <section id="container_login">
        <div class="container_login">
            <div class="container_login_int">
                <div class="area_login">
                    <div class="arrow">
                        <a target="_self" href="<?php echo "https://thechefmelo.com/my_profile.php?token=".$access_token_seting . "&v=".$time;?>">
                            <img width="7px" height="12px" src="img/Arrow.png" alt="">
                        </a>
                    </div>
                    <div class="close_email">
                        <a target="_self" href="<?php echo "https://thechefmelo.com/my_profile.php?token=".$access_token_seting . "&v=".$time;?>">
                            <img width="10px" height="10px" src="img/Close.png" alt="">
                        </a>
                    </div>
                    <div class="logo">
                        <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">                           
                    </div>
                    <div class="configurations_title">
                        <h2>Configurations</h2>
                    </div>
                    <div class="configurations_sub_title">
                        <p>Tap the edit button to change your configurations and confirm your password to save the
                            changes.</p>
                    </div>
                    <form action="#" method="POST">
                        <div class="area_form">
                            <label for="email" class="email_text">
                                E-mail
                               <img width="10px" height="10px" src="img/edit.png" alt="">
                            </label>
                            <input class="email" type="text" name="email" placeholder="example@mail.com" required>
                        </div>
                        <div class="area_form">
                            <label for="name" class="username">
                                Username
                                <img width="10px" height="10px" src="img/edit.png" alt="">
                            </label>
                            <input type="text" name="name" placeholder="enter your e-mail address" required>
                        </div>
                        <div class="area_form">
                            <label for="Mobile" class="mobile">
                                Mobile
                                <img width="10px" height="10px" src="img/edit.png" alt="">
                            </svg>
                            </label>
                            <input type="text" name="mobile" placeholder="555-555-5555" required>
                        </div>
                        <div class="area_form">
                            <label for="password" class="password">
                                Confirm password*
                            </label>
                            <input class="pass" type="text" name="password" placeholder="********" required>
                        </div>
                        <input type="submit" name="submit" class="submit" value="SAVE CHANGES">
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <div class="collectibles">
                <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                <h2>My Collectibles</h2>
            </div>
        </footer>
    </section>
    <div id="loader"></div>
</body>
</html>