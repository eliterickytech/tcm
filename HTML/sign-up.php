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
$check_error = false;
$sSQL = "";
//
$user_password = "";
$user_password_confirm = "";
$user_email = "";
$user_phone = "";
$user_name = "";
$user_data = "";
$user_registry_key = "";
//
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
$update_sql = "";
$s_user_id = 0;
$user_id = 0;
//####################################
if(isset($_POST['data'])) {$user_data = $_POST['data'];}
$get_data = json_decode($user_data, true);
foreach ($get_data as $key => $value) {
    $data_send[$key] = $value;
}

if ($data_send['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    if (empty($data_send['password'])) {
        $errors['password'] = 'Password is required.';
        $check_error = true;
    } else {
        $user_password = trim($data_send['password']);
        $user_password = filter_var($user_password, FILTER_SANITIZE_STRING);
        if (strlen($user_password) < 3) {
            $errors['password'] = 'Not validd password. Password less than 3 characters.';
            $check_error = true;
        } else {
            $user_password = base64_encode($user_password);
        }
    }
    if (empty($data_send['confirm_password'])) {
        $errors['confirm_password'] = 'Confirm password is required.';
        $check_error = true;
    } else {
        $user_confirm_password = trim($data_send['confirm_password']);
        $user_confirm_password = filter_var($user_confirm_password, FILTER_SANITIZE_STRING);
        if (strlen($user_confirm_password) < 7) {
            $errors['confirm_password'] = 'Not validd confirm password. Password less than 7 characters.';
            $check_error = true;
        } else {
            $user_confirm_password = base64_encode($user_confirm_password);
        }
    }
    if($user_confirm_password <> $user_password){
        $errors['confirm_password'] = 'Confirm password not equal.';
        $check_error = true;
    }
    if (empty($data_send['email'])) {
        $errors['email'] = 'Email is required.';
        $check_error = true;
    } else {
        $user_email = filter_var(trim($data_send['email']), FILTER_SANITIZE_EMAIL);
        // Validate e-mail
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Not a valid email address.';
            $check_error = true;
        }
    }
    if (empty($data_send['username'])) {
        $errors['username'] = 'Username is required.';
        $check_error = true;
    } else {
        $user_name = trim($data_send['username']);
        $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
        if (strlen($user_name) < 3) {
            $errors['username'] = 'Not validd username. Less than 3 characters.';
            $check_error = true;
        } 
    }
    if (empty($data_send['mobile'])) {
        $errors['mobile'] = 'Mobile is required.';
        $check_error = true;
    } else {
        $user_phone = trim($data_send['mobile']);
        $user_phone = filter_var($user_phone, FILTER_SANITIZE_NUMBER_INT);
        if (strlen($user_phone) < 6) {
            $errors['mobile'] = 'Not validd phone number. Less than 5 characters.';
            $check_error = true;
        }
    }
    //####################################
    $sSQL = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 0,1";
    //$sSQL_Debug = base64_encode($sSQL);
    //$data['mobile'] = $sSQL_Debug;
    //
    if (!$check_error) {
        $query = mysqli_query($connection, $sSQL);
        $rowCount = mysqli_num_rows($query);
        if ($rowCount < 1) {
            //##################################################################################
            $login_code = rand(6, 999999);
            if ($login_code < 1) {
                $login_code = 060577;
            }
            //##################################################################################
            $user_registry_key = substr(str_shuffle("0123456789/*-+._-ABCDEFGHIJLKMNOPQRSTUVWYXZabcdefghijklmnopqrstuvwxyz"), 0, 33);
            $user_group = 0;
            //##################################################################################
            $insert_sql = "INSERT INTO users(user_name, user_email, user_password, user_phone, user_group, user_registry_key, user_date) SELECT * FROM (SELECT '$user_name' as user_name, '$user_email' as user_email, '$user_password' as user_password, '$user_phone' as user_phone, '$user_group' as user_group, '$user_registry_key' as user_registry_key, NOW() as user_date) AS tmp WHERE NOT EXISTS (SELECT user_email FROM users WHERE user_email = '$user_email') LIMIT 1";
            if (Request_DB($insert_sql, $connection)) {
                $sSQL = "SELECT * FROM users WHERE user_email = '$user_email' and user_registry_key = '$user_registry_key' LIMIT 0,1";
                if($s_user_id = get_by_data($sSQL, $connection, "user_id")){
                    $token['user_id'] = (int) $s_user_id;
                    $token['login_code'] = (int) $login_code;
                    $token['user_email'] = $user_email;
                    $token['user_group'] = $user_group;
                    $token['user_name'] = $user_name;
                    $token['access'] = $user_registry_key;
                    $token['session'] = session_id();
                    $access_token = base64_encode(json_encode($token));
                    $token['token'] = $access_token;
                    //##################################################################################
                    $insert_sql = "INSERT INTO connections(connection_my_user_id, connection_my_friend_id, connection_invite, connection_date) SELECT * FROM (SELECT '$s_user_id' as connection_my_user_id, '1' as connection_my_friend_id, '1' as connection_invite, NOW() as connection_date) AS tmp WHERE NOT EXISTS (SELECT connection_my_user_id, connection_my_friend_id FROM connections WHERE connection_my_user_id = '$s_user_id' AND connection_my_friend_id  = '1' ) LIMIT 1";
                    if (Request_DB($insert_sql, $connection)) {
                        $insert_sql = "INSERT INTO connections(connection_my_user_id, connection_my_friend_id, connection_invite, connection_date) SELECT * FROM (SELECT '1' as connection_my_user_id, '$s_user_id' as connection_my_friend_id, '1' as connection_invite, NOW() as connection_date) AS tmp WHERE NOT EXISTS (SELECT connection_my_user_id, connection_my_friend_id FROM connections WHERE connection_my_user_id = '1' AND connection_my_friend_id  = '$s_user_id' ) LIMIT 1";
                        if (!Request_DB($insert_sql, $connection)) {
                            $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/loading.php'</script>";
                            $errors['email'] = 'Error create connections with user and Melo User.';
                        }                            
                    }
                    //##################################################################################
                    $myFile = "/home/wvvlp0k9oibo/public_html/email_2/collectibles.html";
                    $fh = fopen($myFile, 'r');
                    $theData = fread($fh, filesize($myFile));
                    fclose($fh);
                    //##################################################################################
                    $message = $theData;
                    //##################################################################################
                    if (SendEmail("First Access Code", $login_code, $user_email, $message, $HostEmail, $EmailFaleConosco, $PortaParaEnvioEmailSMTP, $PasswordParaEnvioEmail, $NomeSistemaParaMostrarNoCabecalho)) {
                        $data['EmailCodeAccess'] = $user_email;
                        //##################################################################################
                        $myFile = "/home/wvvlp0k9oibo/public_html/email_1/welcome.html";
                        $fh = fopen($myFile, 'r');
                        $theData = fread($fh, filesize($myFile));
                        fclose($fh);
                        //##################################################################################
                        $message = $theData;
                        //##################################################################################
                        if (SendEmail("Welcome My Collectibles", '', $user_email, $message, $HostEmail, $EmailFaleConosco, $PortaParaEnvioEmailSMTP, $PasswordParaEnvioEmail, $NomeSistemaParaMostrarNoCabecalho, $user_name)) {
                            $data['EmailCollectiblesEnviado'] = $user_name;
                            $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/login-code.php?token=" . $access_token . "'</script>";
                        } else {
                            $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/loading.php'</script>";
                            $errors['email'] = 'Error send Email My Collectibles.';
                        }
                    } else {
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/loading.php'</script>";
                        $errors['email'] = 'Error Sign Up.';
                    }
                } else {
                    $update_sql = "DELETE FROM users WHERE user_email = '$user_email' ";
                    Request_DB($update_sql, $connection);
                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/error.php'</script>";
                    $errors['email'] = 'Error Sign Up. Try again.';
                }               
            } else {
                $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/error.php'</script>";
                $errors['email'] = 'Error Sign Up. Try again.';
            }
        } else {
            $errors['email'] = 'Error Sign Up. Not possible sign up with that email. Try with another email Or Case these email it`s yours, access link recovery of account.';
            //$errors['sql'] = $sSQL;
            $check_error = true;
        }
        mysqli_free_result($query);
        mysqli_close($connection);
    }
} else {
    $errors['session'] = 'Invalid Session';
}
//####################################
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
    $data['redirect'] = $url_redirect;
}
//####################################
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);
?>