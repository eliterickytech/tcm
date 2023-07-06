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
        $user_password = $data_send['password'];
        $user_password = filter_var($user_password, FILTER_SANITIZE_STRING);
        if (strlen($user_password) < 3) {
            $errors['password'] = 'Not validd password. Password less than 3 characters.';
            $check_error = true;
        } else {
            $user_password = base64_encode($user_password);
        }
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
    if (empty($data_send['mobile'])) {
        $errors['mobile'] = 'Mobile is required.';
        $check_error = true;
    } else {
        $user_phone = $data_send['mobile'];
        $user_phone = filter_var($user_phone, FILTER_SANITIZE_NUMBER_INT);
        if (strlen($user_phone) < 6) {
            $errors['mobile'] = 'Not validd phone number. Less than 5 characters.';
            $check_error = true;
        }
    }
    //####################################
    $sSQL = "SELECT * FROM users WHERE user_password = '$user_password' and user_email = '$user_email' and user_phone = '$user_phone' LIMIT 0,1";
    //$sSQL_Debug = base64_encode($sSQL);
    //$data['mobile'] = $sSQL_Debug;
    //
    if (!$check_error) {
        $query = mysqli_query($connection, $sSQL);
        $rowCount = mysqli_num_rows($query);
        if ($rowCount > 0) {
            while ($dados = mysqli_fetch_array($query)) {
                extract($dados);
                //##################################################################################
                $login_code = rand(6, 999999);
                if ($login_code < 1) {
                    $login_code = 060577;
                }
                //##################################################################################
                $s_user_id = $user_id;
                $token['user_id'] = (int) $s_user_id;
                $token['login_code'] = (int) $login_code;
                $token['user_email'] = $user_email;
                $token['user_group'] = $user_group;
                $token['access'] = substr(str_shuffle("0123456789/*-+._-ABCDEFGHIJLKMNOPQRSTUVWYXZabcdefghijklmnopqrstuvwxyz"), 0, 33);
                $token['session'] = session_id();
                $access_token = base64_encode(json_encode($token));
                $token['token'] = $access_token;
                
                //##################################################################################
                $insert_sql = "INSERT INTO login(login_user_id, login_active, login_token, login_date) SELECT * FROM (SELECT '$s_user_id' as login_user_id, '1' as login_active, '$access_token' as login_token, NOW() as login_date) AS tmp WHERE NOT EXISTS (SELECT login_user_id, login_token FROM login WHERE login_user_id = '$s_user_id' and login_token = '$access_token') LIMIT 1";
                if (Request_DB($insert_sql, $connection)) {
                    //##################################################################################
                    $update_sql = "DELETE FROM login WHERE login_user_id = '$s_user_id' and login_token <> '$access_token' ";
                    Request_DB($update_sql, $connection);
                    //##################################################################################
                    $myFile = "/home/wvvlp0k9oibo/public_html/email-send-code-06051977070120231932.html";
                    $fh = fopen($myFile, 'r');
                    $theData = fread($fh, filesize($myFile));
                    fclose($fh);
                    //##################################################################################
                    $message = $theData;
                    //##################################################################################
                    if (SendEmail("Access Code", $login_code, $user_email, $message, $HostEmail, $EmailFaleConosco, $PortaParaEnvioEmailSMTP, $PasswordParaEnvioEmail, $NomeSistemaParaMostrarNoCabecalho)) {
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/login-code.php?token=" . $access_token . "'</script>";
                    } else {
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/loading.php'</script>";
                        $errors['email'] = 'Error Access Token.';
                    }
                } else {
                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/error.php'</script>";
                    $errors['email'] = 'Error Login.';
                }
            }
        } else {
            $errors['email'] = 'Credentials are not valid.';
            $errors['sql'] = $sSQL;
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