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
$destination = "";
$type = 0;
$link_new_banner = "";
$password = "";
$sSQL = "";
$user_id = 0;
$user_login = 0;
$sSQL_Debug = "";
$data = [];
$user_data = [];
$access_token = "";
$data_token = [];
$data_send = [];
$errors = [];
$user_password = "";
$check_error = false;
$update_sql = "";
$url_redirect = "";
$img_new_banner = "";
$user_group = 0;
//####################################
//####################################
if(isset($_POST['data'])) {$user_data = $_POST['data'];}
//####################################
if(isset($user_data)){
    $user_data = json_decode($user_data, true);
    foreach ($user_data as $key => $value) {
        $data_send[$key] = $value;
        //$errors[$key] = $value;
    }
    //############################################
    $access_token_setting = $data_send['token']; 
    //############################################
    $access_token = base64_decode($access_token_setting);
    $access_token = json_decode($access_token, true);
    foreach ($access_token as $key => $value) {
        $data_token[$key] = $value;
    }
    //############################################
    $user_id = $data_token['user_id'];
    $user_group = $data_token['user_group'];
    //############################################
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "1"){
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";    
    }
} else {
    echo "<meta http-equiv='Refresh' content='1; URL= https://thechefmelo.com/error.php?".$time."'/>";
}
if ($data_send['session'] == session_id()) {
    //#####################################
    require_once("con_mysql.php");
    //#####################################
    $link_new_banner = $data_send['link_new_banner'];
    if (empty($data_send['password'])) {
    $errors['password'] = 'Password is required.';
    $check_error = true;
    } else {
        $user_password = $data_send['password'];
        $user_password = filter_var($user_password, FILTER_SANITIZE_STRING);
        if (strlen($user_password) < 8) {
            $errors['password'] = 'Not validd password. Password less than 8 characters.';
            $check_error = true;
        } else {
            $user_password = base64_encode($user_password);
        }
    }
    if (empty($data_send['img_new_banner'])) {
        $errors['img_new_banner'] = 'New image is required.';
        $check_error = true;
    } else {
        $img_new_banner = filter_var(trim($data_send['img_new_banner']), FILTER_SANITIZE_STRING);
        // Validate e-mail
        if (strlen($img_new_banner) < 3) {
            $errors['img_new_banner'] = 'Error, link of image very short.';
            $check_error = true;
        }
    }
} else {
  $errors['session'] = 'Invalid Session';
}
if(!$check_error){
    $sSQL = "SELECT * FROM users WHERE user_id = '$user_id' and user_password = '$user_password' ";
    //###############
    $sSQL_Debug = base64_encode($sSQL);
    $data['controlOne'] = $sSQL_Debug;
    //###############
    $user_login = (int)get_by_data($sSQL, $connection, 'user_id');
    $data['controlTwo'] = $user_login . " " . $user_id;
    if($user_login == $user_id){
        if($data_send['type'] < 1){
            //banner short
            $update_sql = "UPDATE banner SET banner_link = '$link_new_banner', banner_image = '$img_new_banner' WHERE banner_id = '1' ";
        } else {
            //banner big
            $update_sql = "UPDATE banner SET banner_link = '$link_new_banner', banner_image = '$img_new_banner' WHERE banner_id = '2' ";
        }
        //###############
        $sSQL_Debug = base64_encode($update_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        if (Request_DB($update_sql, $connection)) {
            $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/my.php?token=" . $access_token_setting . "'</script>";
        } else {
            $errors['update'] = 'Error update banner.';
        }
    } else {
        $errors['password'] = 'Password is wrong';
    }
} else {
    $errors['msg'] = 'Errors banners';
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