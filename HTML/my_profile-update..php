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
$slq_all_users = "";
$get_all_users = [];
$user_confirm = [];
$confirm = "";
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
        $get_data_sql = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $data_user = get_all_data($get_data_sql, $connection);
        //print_r($data_user);
        //exit('debug collections');
        ////###############
        $slq_all_users = "SELECT * FROM users WHERE user_id > '1' and user_group = '1' ";
        if(!$get_all_users = get_all_data($slq_all_users, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          $result = array();
          foreach($get_all_users as $item) {
              $result[] = array(
                  'user_id' => $item['user_id'],
                  'user_registry_key' => $item['user_registry_key'],
                  'user_name' => $item['user_name'],
                  'user_email' => $item['user_email']
              );
          }
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
    <title>Permissions</title>
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

<body  onload="onLoad()" class="access">

    <section id="container_login">

        <div class="container_login">
            <div class="container_login_int">

                <div class="area_login">

                    <div class="arrow">
                      <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">  
                        <img width="7px" height="12px" src="img/Arrow.png" alt="">
                      </a>
                    </div>

                    <div class="close_email">
                        <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">
                          <img width="10px" height="10px" src="img/Close.png" alt="">
                        </a>
                    </div>

                    <div class="logo_permissions">
                        <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">                           
                    </div>

                    <div class="admin_console">
                        <h2>admin console</h2>
                    </div>


                    <div class="configurations_title">
                        <h2>Permissions</h2>
                    </div>

                    <div class="configurations_sub_title_permissions">
                        <p>
                            Tap the delete button to change the app permissions or add a new admin and confirm your password to apply the changes.
                        </p>
                        <!-- <a target="_self" href="<?php echo "https://thechefmelo.com/insert-admin-user.php?token=".$access_token_seting . "&v=".$time;?>">Add new user</a><br/><a target="_self" href="<?php echo "https://thechefmelo.com/profile.php?token=".$access_token_seting . "&v=".$time;?>">Change Password</a> -->
                    </div>

                    <div class="area_permissions_admin">
                        <div class="admins_permissions">
                            <h2>Admins</h2>
                        </div>

                        <div class="area_total_admin_permissions">
                            <?php if(is_array($result)):?>
                                <?php foreach($result as $item):?>
                                <div class="new_admin_permissions">
                                        <?php 
                                            $user_confirm['user_id'] = (int) $item['user_id'];
                                            $user_confirm['user_registry_key'] = $item['user_registry_key'];
                                            $user_confirm['type'] = 1;
                                            $confirm = base64_encode(json_encode($user_confirm));
                                            $confirm = "https://thechefmelo.com/modal_sure.php?token=" . $access_token_seting . "&action=" . $confirm;
                                        ?>
                                        <h2><?php echo(isset($item['user_email']) ? $item['user_email'] : '');?></h2>
                                        <a href="<?php echo $confirm;?>" target="_self">
                                            <img src="img/trash.png">
                                        </a>
                                </div>
                                <?php endforeach;?>
                            <?php endif;?>                            
                        </div>
                    </div>
                    <form action="#" method="POST">

                        <div class="area_form">
                            <label for="email" class="email_text">
                                E-mail
                            </label>
                            <input class="email" type="text" id="email" name="email" placeholder="Tap here to insert their e-mail" required autocomplete="off">
                        </div>

                        <div class="area_form">
                            <label for="confirme_email" class="confirme_email">
                                Confirm your e-mail
                            </label>
                            <input type="text" class="email" name="confirm-email" id="confirm-email" onkeypress="validateChangeEmail()" placeholder="The same e-mail you use to log in the app"  required autocomplete="off">
                            <span class="errorData" role="alert" id="emailError" aria-hidden="true"></span>
                        </div>

                        <div class="area_form">
                            <label for="password" class="password">
                                Confirm your password*
                            </label>
                            <input class="pass" type="password" id="password" name="password" placeholder="The same password you use to log in the app"  onkeypress="validateChangeEmail()" required  required autocomplete="off">
                        </div>
                        
                        <?php if(isset($data_user)):?>
                            <?php foreach($data_user as $data_admin_user):?>
                              <!--<div class="enter-password-child">
                                    <?php 
                                        //echo(!empty($data_admin_user['user_email']) ? $data_admin_user['user_email'] : 'empty email');
                                    ?>
                            </div>-->
                              <input type="hidden" name="type" id="type" value="1">
                              <input type="hidden" name="user_group" id="user_group" value="1">
                              <input type="hidden" name="session" id="session" value="<?php echo session_id();?>">
                              <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
                            <?php endforeach;?>
                        <?php endif;?>


                        <input type="submit" name="submit" class="new_admin" value="Add a new admin">

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


   

</body>

</html>
