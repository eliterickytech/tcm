<?php 
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
//####################################################
$time = "";
$time = "v=" . base64_encode(date('His'));
?>