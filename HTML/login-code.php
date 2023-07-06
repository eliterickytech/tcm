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
//####################################
$time = "";
$time = base64_encode(date('His'));
//####################################

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
$check_error = false;
$sSQL = "";
$user_password = "";
$user_email = "";
$user_phone = "";
$user_data = "";
$get_data = "";
$url_redirect = "";
$rowCount = 0;
$login_code = 0;
$insert_sql = "";
$control_insert = false;
$myFile = "";
$fh = "";
$theData = "";
$message = "";
$token = [];
$access_token = "";
//####################################

if(isset($_GET['token'])) {$user_data = $_GET['token'];}

if(isset($user_data)){
    $access_token = base64_decode($user_data);
    $access_token = json_decode($access_token, true);
    foreach ($access_token as $key => $value) {
        $data_send[$key] = $value;
    }
    if($data_send['session'] <> session_id()){
        echo "<meta http-equiv='Refresh' content='1; URL= https://thechefmelo.com/error.php?".$time."'/>";    
    }
} else {
    echo "<meta http-equiv='Refresh' content='1; URL= https://thechefmelo.com/error.php?".$time."'/>";
}
//####################################
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Login validate</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/login-check.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
            var chronometer = document.createElement("script");  
            chronometer.type = "text/javascript";  
            chronometer.src = "/js/time.js?v=" + versionUpdate;  
            document.body.appendChild(chronometer);
        }
    </script>
</head>
    <body onload="onLoad()" class="access">
        <section id="container_login_validate">
            <div class="container_login_validate">
                <div class="container_login_validate_int">
                    <div class="area_login_validate">
                        <div class="logo">
                            <a href="https://thechefmelo.com/" alt="Home">
                                <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                            </a>
                        </div>
                        <form method="POST">
                            <div id="code-group" class="area_form">
                                <label for="code" class="code">
                                    <span id="timer"></span><span id="insert_code"></span>
                                </label>
                                <input class="code_input" type="text" id="code_numbers" name="code_numbers" placeholder="_ _ _ _ _ _" maxlength="6" autocomplete="off" onkeypress="validateCode()" onpaste="validateCode()">
                                <span class="errorData" role="alert" id="codenumberError" aria-hidden="true"></span>
                            </div>
                            <input type="submit" name="submit" class="submit" value="GO">
                            <input type="hidden" name="token" value="<?php echo $user_data;?>">
                            <div class="send_email">
                                <p>Did't receive the code?<br> <a target="_self" href="https://thechefmelo.com/login-send-code.php?token=<?php echo $user_data;?>"><span style="text-decoration: none; color: var(--color-font-form);">Tap here to </span><b>send a new one to your e-mail.</b></a></p>
                            </div>
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
            <div id="loader"></div>
        </section>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </body>
</html>