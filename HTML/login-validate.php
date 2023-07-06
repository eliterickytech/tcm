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
//#####################################################
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
$data_token = [];
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
$theData = "";
$message = "";
$token = [];
$token_decode = [];
$access_token = "";
$time = "";
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_POST['data'])) {$user_data = $_POST['data'];}
if(isset($user_data)){
    $user_data = json_decode($user_data, true);
    foreach ($user_data as $key => $value) {
        $data_send[$key] = $value;
        $errors[$key] = $value;
    }
    //############################################
    $access_token = $data_send['token']; 
    //############################################
    $access_token = base64_decode($access_token);
    $access_token = json_decode($access_token, true);
    foreach ($access_token as $key => $value) {
        $data_token[$key] = $value;
    }
    $login_code = filter_var($data_send['code_numbers'], FILTER_SANITIZE_NUMBER_INT);
    if($data_token['session'] == session_id()){
        if($login_code == $data_token['login_code']){
            if($data_token['user_group'] == "1"){
                $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/my.php?token=" . $data_send['token'] . "&v=".$time."'</script>";
            } else {
                $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/home.php?token=" . $data_send['token'] . "&v=".$time."'</script>";
            }
            $errors = [];
        } else {
            $errors['code_numbers'] = 'Code not valid.';
        }
    } else {
        $errors['session'] = 'Credentials are not valid.';
    }
} else {
    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/error.php'</script>";
    $errors['session'] = 'Credentials are not valid.';
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