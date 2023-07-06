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

if(isset($_POST['data'])) {$user_data = $_POST['data'];}
$get_data = json_decode($user_data, true);

foreach ($get_data as $key => $value) {
    $data_send[$key] = $value;
}
//####################################
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Login validate</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <section id="container_login_validate">
            <div class="container_login_validate">
                <div class="container_login_validate_int">
                    <div class="area_login_validate">
                        <div class="logo">
                            <a href="https://thechefmelo.com/" alt="Home">
                                <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                            </a>
                        </div>
                        <form action="#" method="POST">
                            <div class="area_form">
                                <label for="code" class="code">
                                    We sent you a 6 digit code. Insert it here.
                                </label>
                                <input class="code_input" type="text" name="code" placeholder="_ _ _ _ _ _" MAXLENGTH=6>
                            </div>
                            <input type="submit" name="submit" class="submit" value="GO">
                            <div class="send_email">
                                <p>Didn’t receive the code?<br> Tap here to <b>send a new one to your e-mail.</b></p>
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
        </section>
    </body>
</html>