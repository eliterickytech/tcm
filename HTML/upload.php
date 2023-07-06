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
$destination = "";
$url_redirect = "";
//####################################
//####################################
//####################################
if(isset($_POST['token'])) {$user_data = $_POST['token'];}
if(isset($user_data)){
    $access_token = base64_decode($user_data);
    $access_token = json_decode($access_token, true);
    foreach ($access_token as $key => $value) {
        $data_send[$key] = $value;
    }
} else {
    echo "<meta http-equiv='Refresh' content='1; URL= https://thechefmelo.com/error.php?".$time."'/>";
}
if ($data_send['session'] == session_id()) {
  //####################################
  require_once("con_mysql.php");
  //####################################
  if (isset($_FILES['file'])) {
    $filename   = uniqid() . "-" . time();
    $extension  = pathinfo( $_FILES["file"]["name"], PATHINFO_EXTENSION );
    $basename   = $filename . "." . $extension;
    $source       = $_FILES["file"]["tmp_name"];
    $destination  = "upload/" . $basename;
    if(!move_uploaded_file( $source, $destination )){
      $errors['msg'] = 'Error upload file.';
    }
  } else {
    $errors['msg'] = 'Empty file.';
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
  $data['file'] = $destination;
  $data['redirect'] = $url_redirect;
}
//####################################
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);
?>