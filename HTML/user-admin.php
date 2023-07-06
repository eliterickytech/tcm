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
$type = 0;
$user_registry_key = "";
$user_id = 0;
$user_email = "";
$user_confirm = [];
$confirm = "";
//####################################
if(isset($_POST['data'])) {$user_data = $_POST['data'];}
$get_data = json_decode($user_data, true);
foreach ($get_data as $key => $value) {
    $data_send[$key] = $value;
}
//
if ($data_send['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    if(!$data_send['user_group'] == "1"){
        $errors['session'] = 'Invalid Session #01';
    } else {
        if($data_send['type'] < 2){
            if (empty($data_send['user_email'])) {
                $errors['user_email'] = 'Email is required.';
                $check_error = true;
            } else {
                $user_email = filter_var(trim($data_send['user_email']), FILTER_SANITIZE_EMAIL);
                // Validate e-mail
                if (filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
                    $errors['user_email'] = 'Not a valid email address.';
                    $check_error = true;
                }
            }
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
            if (empty($data_send['confirm_email'])) {
                $errors['confirm_email'] = 'Confirm email is required.';
                $check_error = true;
            } else {
                $user_confirm_email = trim($data_send['confirm_email']);
                $user_confirm_email = filter_var($user_confirm_email, FILTER_SANITIZE_STRING);
                if (strlen($user_confirm_email) < 3) {
                    $errors['confirm_email'] = 'Not validd confirm email. Email less than 3 characters.';
                    $check_error = true;
                }
            }
            if (strcmp($user_confirm_email, $user_email) != 0) {
                $errors['confirm_email'] = "Confirm email not equal. > " . $user_confirm_email . " >> " . $user_email;
                $check_error = true;
            }
            if (empty($data_send['token'])) {
                $errors['token'] = 'Token is required.';
                $check_error = true;
            } else {
                $access_token = trim($data_send['token']);
                $access_token = filter_var($access_token, FILTER_SANITIZE_STRING);
                if (strlen($access_token) < 1) {
                    $errors['access_token'] = 'Not validd token.';
                    $check_error = true;
                }
            }
            
            if (empty($data_send['user_group'])) {
                $errors['user_group'] = 'User group is required.';
                $check_error = true;
            } else {
                $user_group = trim($data_send['user_group']);
                $user_group = filter_var($user_group, FILTER_SANITIZE_NUMBER_INT);
                if (strlen($user_group) < 1) {
                    $errors['user_group'] = 'Not validd user group.';
                    $check_error = true;
                }
            }
            //####################################
            if (empty($data_send['type'])) {
                if (empty($data_send['user_registry_key'])) {
                    $errors['user_registry_key'] = 'User registry key is required.';
                    $check_error = true;
                } else {
                    $user_registry_key = trim($data_send['user_registry_key']);
                    $user_registry_key = filter_var($user_registry_key, FILTER_SANITIZE_STRING);
                    if (strlen($user_registry_key) < 3) {
                        $errors['user_registry_key'] = 'Not validd user registry key. Less than 3 characters.';
                        $check_error = true;
                    } 
                }        
                //
                if (empty($data_send['user_id'])) {
                    $errors['user_id'] = 'User id is required.';
                    $check_error = true;
                } else {
                    $user_id = trim($data_send['user_id']);
                    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
                    if (strlen($user_id) < 1) {
                        $errors['user_id'] = 'Not validd user id.';
                        $check_error = true;
                    }
                }
                //
                if (!$check_error) {
                    //###############
                    $update_sql = "UPDATE users SET user_password = '$user_password' WHERE user_registry_key = '$user_registry_key' and user_id = '$user_id' and user_email = '$user_email' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlChangePassword'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['update_password'] = 'Error update password user.';
                        $check_error = true;
                    } else {
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/profile.php?token=" . $access_token . "'</script>";
                    }
                }
            } else {
                if($data_send['type'] == "1"){
                    //Add new User
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
                            //##################################################################################
                            $insert_sql = "INSERT INTO users(user_name, user_email, user_password, user_phone, user_group, user_registry_key, user_date) SELECT * FROM (SELECT '$user_name' as user_name, '$user_email' as user_email, '$user_password' as user_password, '$user_phone' as user_phone, '$user_group' as user_group, '$user_registry_key' as user_registry_key, NOW() as user_date) AS tmp WHERE NOT EXISTS (SELECT user_email FROM users WHERE user_email = '$user_email') LIMIT 1";
                            if (Request_DB($insert_sql, $connection)) {
                                $sSQL = "SELECT * FROM users WHERE user_email = '$user_email' and user_registry_key = '$user_registry_key' LIMIT 0,1";
                                if($s_user_id = get_by_data($sSQL, $connection, "user_id")){
                                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/profile.php?token=" . $access_token . "'</script>";
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
                    //
                    $errors['session'] = 'Type not defnied';
                }
            }
        } 
    }
} else {
    $errors['session'] = 'Invalid Session #02 > ' . $data_send['session'] . ' >> ' . session_id();
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