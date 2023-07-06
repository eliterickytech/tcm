<?php
//##############################
$db_host = "localhost";
$db_username = "integra_api";
$db_password = "&(d2Ym6{X[s^+)TleU";
$db_name = "integra_api";
$errorDescription = "";
$connection = new mysqli($db_host, $db_username, $db_password, $db_name, "3306");
// Check connection
if ($errorDescription = $connection -> connect_errno) {
    echo "Error Connections DB: " . $mysqli -> $errorDescription;
    exit();
  }
//##############################
$EmailFaleConosco = "info@thechefmelo.com";
$MySiteURL = "";
$ChavePrincipal = "79b5062f23890825fe91cf19490bc189";
$ChavePaginaParaAcessoLogin = "1";
$MySiteURL = "/";
$NomeSistemaParaMostrarNoCabecalho = "The Chef Melo";
$HostEmail = "p3plzcpnl472840.prod.phx3.secureserver.net";
$PortaParaEnvioEmailSMTP = "465";
$PasswordParaEnvioEmail = "SaRf%89+NC}J";
$today = date('Y-m-d');
//##############################
function Request_DB($sSQL = NULL, $connection = NULL){
  $sql = "";
	$sReturn = "";
	$sql = $sSQL;
  $control = false;
  try {
      if(mysqli_query($connection, $sql)){
          $control_insert = true;
      } else{
          $control_insert = false;
          throw new Exception('Error Insert Data.');
      }
  } catch (Exception $e) {
      $control_insert = false;
  } finally {
      $control_insert = true;
  }
  return $control_insert;
}
//############################
function get_by_data($sSQL = NULL, $connection, $field = NULL){
  $sql = "";
  $sReturn = "";
  $sql = $sSQL;
  $control = false;
  try {
    if($query = mysqli_query($connection, $sql)){
      $row_Ret = mysqli_fetch_assoc($query);
      if(isset($row_Ret[$field])) {$sReturn = utf8_decode($row_Ret[$field]);}
    } else{
        $sReturn = "";
        throw new Exception('Error get data.');
    }
  } catch (Exception $e) {
    $sReturn = "";
  } finally {
      $control = true;
  }
  return $sReturn;
}	

function get_all($sSQL = NULL, $connection){
  $sql = "";
  $sReturn = "";
  $sql = $sSQL; 
  try {
    if($query = mysqli_query($connection, $sql)){
      $row_Ret = mysqli_fetch_assoc($query);
      if(is_array($row_Ret)){
        $sReturn = $row_Ret;
      } else {
        $sReturn = "";
        throw new Exception('Error query empty.');
      }        
    } else{
        $sReturn = "";
        throw new Exception('Error get data.');
    }
  } catch (Exception $e) {
    $sReturn = "";
  } finally {
      $control_insert = true;
  }
  return $sReturn;
}	

function get_all_data($sSQL = NULL, $connection){
  $sql = "";
  $sReturn = "";
  $sql = $sSQL; 
  $rows = array();
  try {
    if($query = mysqli_query($connection, $sql)){
      while($r = mysqli_fetch_assoc($query)) {
          $rows[] = $r;
      }
      if(is_array($rows)){
        $sReturn = $rows;
      } else {
        $sReturn = "";
        throw new Exception('Error query empty.');
      }        
    } else{
        $sReturn = "";
        throw new Exception('Error get data.');
    }
  } catch (Exception $e) {
    $sReturn = "";
  } finally {
      $control_insert = true;
  }
  return $sReturn;
}	
function save_file_part($myFile = null, $content = null){
  $controle_save_file = false;
  try {
    $fh = fopen($myFile, 'wb') or die("Unable to open file!");
    $theData = fread($fh, filesize($myFile));
    fclose($fh);                
    $myfile = fopen($myFile, "wb") or die("Unable to open file!");
    fwrite($myfile, $content);
    fclose($myfile);
  } catch (Exception $e) {
    $controle_save_file = false;
  } finally {
    $controle_save_file = true;
  }
  return $controle_save_file;
}
function get_total_rows($sSQL = NULL, $connection){
  $sql = "";
  $sReturn = "";
  $sql = $sSQL; 
  try {
    if($query = mysqli_query($connection, $sql)){
      $row_Ret = (int)mysqli_num_rows($query);
      if($row_Ret){
        $sReturn = $row_Ret;
      } else {
        $sReturn = "";
        throw new Exception('Error query empty.');
      }        
    } else{
        $sReturn = "";
        throw new Exception('Error get data.');
    }
  } catch (Exception $e) {
    $sReturn = "";
  } finally {
      $control_insert = true;
  }
  return $sReturn;
}	

function SendEmail($title = NULL, $access_code = NULL, $email = NULL, $message = NULL, $smtp_host = NULL, $email_sender = NULL, $smtp_port = NULL, $email_password = NULL, $email_sender_name = NULL, $user_name = NULL){
  require_once("class.phpmailer.php");
  $control_email = false;
  if (isset($access_code)) {
    $message = str_replace("[@AccessCode]", $access_code, $message);
    $message = utf8_decode($message);
    if(isset($title)){
      $Assunto = utf8_decode($title . " " . $access_code);
    } else {
      $Assunto = utf8_decode("Code The Chef Melo " . $access_code);
    }
  } else {
    $message = utf8_decode($message);
    if(isset($title)){
      $Assunto = utf8_decode($title);
    } else {
      $Assunto = utf8_decode("IMPORTANT");
    }
  }

  //###################################
  if($user_name){
    $message = str_replace("[@User]", $user_name, $message);
  } else {
    $message = str_replace("[@User]", '', $message);
  }
  //###################################

  $mail = new PHPMailer();
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'ssl';
  $mail->Host = $smtp_host;
  $mail->Port = $smtp_port;
  $mail->Username = $email_sender;
  $mail->Password = $email_password; // password SMTP
  $mail->From = $email_sender;    
  $mail->FromName = $email_sender_name;
  $mail->AddAddress($email);
  $mail->AddReplyTo($email_sender_name,$email_sender);
  $mail->Subject = $Assunto;
  $mail->Body = $message;
  $mail->IsHTML(true);
  try {
      if($mail->Send()){
          $control_email = true;
      } else{
        $control_email = false;
          throw new Exception('Error Send Email.');
      }
  } catch (Exception $e) {
    $control_email = false;
  } finally {
    $control_email = true;
  }  
  return $control_email;
}
?>