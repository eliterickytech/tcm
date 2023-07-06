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
$confirm = "";
$confirm_original = "";
$user_confirm = [];
$autorizou = 0;
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
if(isset($_GET['action'])) {$confirm = $_GET['action'];}
if(isset($_GET['autorizou'])) {$autorizou = $_GET['autorizou'];}

$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//####################################
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}
////
// echo 'Session: ' . $data_token['session'];
// echo 'Session ID: ' . session_id();
// exit(' >> Debug Access Modal Sure');
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
        $confirm_original = $confirm;
        $user_confirm = json_decode(base64_decode($confirm));
        //echo "###01";
        //print_r($user_confirm);
        if($user_confirm->type == '1'){
            //echo "###02";
            if($autorizou == "1"){
                $user_id = $user_confirm->user_id;
                $user_registry_key = $user_confirm->user_registry_key;
                //echo "###03";
                $update_sql = "DELETE FROM users WHERE user_group = '1' and user_id = '$user_id' and user_registry_key = '$user_registry_key' ";
                if(Request_DB($update_sql, $connection)){
                    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/profile.php?token=" . $access_token_seting . "'/>";
                } else {
                    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
                }
                ////###############
                exit();
                ////###############
            }
        }
        //echo "###04";        
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
//echo "###05";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Modal area you sure</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <section id="modal_invitation"> 
            <div class="modal_invitation">
                <div class="modal_invitation_int_sure">
    
                    <div class="area_invitation_sure">
                        <div class="title_invitation">
                            <h2>
                                Are you sure of this action?
                            </h2>
                        </div>
    
                        <div class="area_you_sure">

                            <div class="yes_action">
                                <h2>
                                <a href="https://thechefmelo.com/modal_sure.php?token=<?php echo $access_token_seting;?>&action=<?php echo $confirm_original;?>&autorizou=1" target="_self">Yes</a>
                                </h2>
                            </div>

                            <div class="cancel_action">
                                <h2>                                
                                    <a href="https://thechefmelo.com/profile.php?token=<?php echo $access_token_seting;?>" target="_self">cancel</a>
                                </h2>
                            </div>

                        </div>

                    </div>
    
                </div>
            </div>
        </section>
  
    </body>
</html>