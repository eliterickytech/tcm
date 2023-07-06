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
//####################################
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
$time = "";
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}

if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    //##################################################################################
    $myFile = "/home/wvvlp0k9oibo/public_html/email-send-code-06051977070120231932.html";
    $fh = fopen($myFile, 'r');
    $theData = fread($fh, filesize($myFile));
    fclose($fh);
    //##################################################################################
    $message = $theData;
    //##################################################################################
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Loading</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
</head>
    <body>
        <section id="load">
            <div class="logo">
                <img src="img/Logo.png" alt="Patisserie">
            </div>        
        </section>
        <?php 
        
        if($login_code && $user_email){
            if (SendEmail("Resend Code The Chef Melo", $login_code, $user_email, $message, $HostEmail, $EmailFaleConosco, $PortaParaEnvioEmailSMTP, $PasswordParaEnvioEmail, $NomeSistemaParaMostrarNoCabecalho)) {
                echo "<meta http-equiv='Refresh' content='3; URL= https://thechefmelo.com/login-code.php?token=".$access_token_seting. "&v=".$time."'/>";
            } else {
                echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
            }
        } else {
            echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
        }
        //####################################
        mysqli_close($connection);
        //####################################
        
        ?>
        <footer id="load_footer">
            <div class="collectibles">
                <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                <h2>My Collectibles</h2>
            </div>
        </footer>
    </body>
</html>
