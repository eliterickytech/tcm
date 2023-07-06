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
$session = "";
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['email'])) {$user_email = $_GET['email'];}
if(isset($_GET['session'])) {$session = $_GET['session'];}
//####################################
$session = htmlspecialchars($session, ENT_QUOTES, 'UTF-8');
$session = strip_tags($session);
$session = stripslashes($session);
//####################################
if ($session == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    $user_email = htmlspecialchars($user_email, ENT_QUOTES, 'UTF-8');
    $user_email = strip_tags($user_email);
    $user_email = stripslashes($user_email);
    //####################################
    $sSQL = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 0,1";
    if($get_all_users = get_all_data($sSQL, $connection)){
        //####################################
        $login_code = rand(6, 999999);
        if ($login_code < 1) {
            $login_code = 060577;
        }
        //####################################
        foreach($get_all_users as $key => $value){
            $token[$key] = $value;
        }
        //####################################
        $token['access'] = $get_all_users[0]['user_registry_key'];
        $token['login_code'] = (int) $login_code;
        $token['user_email'] = $user_email;
        $token['session'] = session_id();
        $token['forgot_password'] = 1;
        //####################################
        //print_r($token);
        //echo "<br/>";
        $access_token = base64_encode(json_encode($token));
        $token['token'] = $access_token;        
        //##################################################################################
        $myFile = "/home/wvvlp0k9oibo/public_html/email_2/collectibles.html";
        $fh = fopen($myFile, 'r');
        $theData = fread($fh, filesize($myFile));
        fclose($fh);
        //##################################################################################
        $message = $theData;
        //##################################################################################
        if (SendEmail("Forgot Password Access Code", $login_code, $user_email, $message, $HostEmail, $EmailFaleConosco, $PortaParaEnvioEmailSMTP, $PasswordParaEnvioEmail, $NomeSistemaParaMostrarNoCabecalho)) {
            //print_r($get_all_users);
            //exit('Debug Forgot Password');
            setcookie('forgot', '1', time() + (86400 * 30), "/");
            echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/login-code.php?token=" . $access_token . "'/>";
        } else {
            setcookie('forgot', '', time() - 3600, "/");
            echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
        }
    } else {
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/error.php'/>";
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
//echo "###05";
exit();
?>
