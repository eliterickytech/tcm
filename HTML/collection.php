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
$insert_sql = "";
$url_redirect = "";
$img_new_banner = "";
$user_group = 0;
$collection_hash = "";
$collection_name = "";
$single = 0;
$miniature_collection_piece_description = "";
$single_part_collection_piece_description = "";
$collection_available_now = 1;
$collection_date_available = "";
$collection_time_available = "";
$collection_active = 1;
$parts_base64 = "";
$imagem_part_1 = "";
$imagem_part_2 = "";
$imagem_part_3 = "";
$imagem_part_4 = "";
$imagem_part_5 = "";
$imagem_part_6 = "";
$folder_upload = "";
$description_part_1 = "";
$description_part_2 = "";
$description_part_3 = "";
$description_part_4 = "";
$description_part_5 = "";
$description_part_6 = "";
$description_part_7 = "";
$description_part_8 = "";
$description_part_9 = "";
$fh = "";
$theData = "";
$myFile = "";          
$get_data_sql = "";
$data_collection = [];
$collecion_id = 0;
$video = 0;
$new_video = "";
$collection_video_description = "";
//####################################
//####################################
if(isset($_POST['data'])) {$user_data = $_POST['data'];}
//####################################
if(isset($user_data)){
    $user_data = json_decode($user_data, true);
    foreach ($user_data as $key => $value) {
        $data_send[$key] = $value;
    }
    //############################################
    if(!empty($data_send)){        
        $access_token_setting = $data_send['token'];
        $type = $data_send['type'];

        if(isset($data_send['single'])){
            $single = (int)$data_send['single'];
        }
        if(isset($data_send['video'])){
            $video = (int)$data_send['video'];
        }
    }    
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
    if($video < 1){
        if ($single > 0) {
            if (empty($data_send['miniature_collection_piece_description'])) {
                $errors['collection_hash'] = 'Description miniature is required.';
                $check_error = true;
            } else {
                $miniature_collection_piece_description = filter_var(trim($data_send['miniature_collection_piece_description']), FILTER_SANITIZE_STRING);
                // Validate
                if (strlen($miniature_collection_piece_description) < 1) {
                    $errors['collection_hash'] = 'Error, Description miniature empty.';
                    $check_error = true;
                }
            }
            if($type < 4){
                if (empty($data_send['single_part_collection_piece_description'])) {
                    $errors['collection_hash'] = 'Description collection is required.';
                    $check_error = true;
                } else {
                    $single_part_collection_piece_description = filter_var(trim($data_send['single_part_collection_piece_description']), FILTER_SANITIZE_STRING);
                    // Validate
                    if (strlen($single_part_collection_piece_description) < 1) {
                        $errors['collection_hash'] = 'Error, Description collection empty.';
                        $check_error = true;
                    }
                }
            } else {
                if($type == "4"){
                    if (empty($data_send['description_part_1'])) {
                        $errors['description_1'] = 'Description part 1 is required.';
                        $check_error = true;
                    } else {
                        $description_part_1 = filter_var(trim($data_send['description_part_1']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_1) < 1) {
                            $errors['description_1'] = 'Error, Description part 2 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_2'])) {
                        $errors['description_2'] = 'Description part 2 is required.';
                        $check_error = true;
                    } else {
                        $description_part_2 = filter_var(trim($data_send['description_part_2']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_2) < 1) {
                            $errors['description_2'] = 'Error, Description part 2 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_3'])) {
                        $errors['description_3'] = 'Description part 3 is required.';
                        $check_error = true;
                    } else {
                        $description_part_3 = filter_var(trim($data_send['description_part_3']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_3) < 1) {
                            $errors['description_3'] = 'Error, Description part 3 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_4'])) {
                        $errors['description_4'] = 'Description part 4 is required.';
                        $check_error = true;
                    } else {
                        $description_part_4 = filter_var(trim($data_send['description_part_4']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_4) < 1) {
                            $errors['description_4'] = 'Error, Description part 4 empty.';
                            $check_error = true;
                        }
                    }
                }
                if($type == "5"){
                    if (empty($data_send['description_part_1'])) {
                        $errors['description_1'] = 'Description part 1 is required.';
                        $check_error = true;
                    } else {
                        $description_part_1 = filter_var(trim($data_send['description_part_1']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_1) < 1) {
                            $errors['description_1'] = 'Error, Description part 2 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_2'])) {
                        $errors['description_2'] = 'Description part 2 is required.';
                        $check_error = true;
                    } else {
                        $description_part_2 = filter_var(trim($data_send['description_part_2']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_2) < 1) {
                            $errors['description_2'] = 'Error, Description part 2 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_3'])) {
                        $errors['description_3'] = 'Description part 3 is required.';
                        $check_error = true;
                    } else {
                        $description_part_3 = filter_var(trim($data_send['description_part_3']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_3) < 1) {
                            $errors['description_3'] = 'Error, Description part 3 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_4'])) {
                        $errors['description_4'] = 'Description part 4 is required.';
                        $check_error = true;
                    } else {
                        $description_part_4 = filter_var(trim($data_send['description_part_4']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_4) < 1) {
                            $errors['description_4'] = 'Error, Description part 4 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_5'])) {
                        $errors['description_5'] = 'Description part 5 is required.';
                        $check_error = true;
                    } else {
                        $description_part_5 = filter_var(trim($data_send['description_part_5']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_5) < 1) {
                            $errors['description_5'] = 'Error, Description part 5 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_6'])) {
                        $errors['description_6'] = 'Description part 6 is required.';
                        $check_error = true;
                    } else {
                        $description_part_6 = filter_var(trim($data_send['description_part_6']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_6) < 1) {
                            $errors['description_6'] = 'Error, Description part 6 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_7'])) {
                        $errors['description_7'] = 'Description part 7 is required.';
                        $check_error = true;
                    } else {
                        $description_part_7 = filter_var(trim($data_send['description_part_7']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_7) < 1) {
                            $errors['description_7'] = 'Error, Description part 7 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_8'])) {
                        $errors['description_8'] = 'Description part 8 is required.';
                        $check_error = true;
                    } else {
                        $description_part_8 = filter_var(trim($data_send['description_part_8']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_8) < 1) {
                            $errors['description_8'] = 'Error, Description part 8 empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['description_part_9'])) {
                        $errors['description_9'] = 'Description part 9 is required.';
                        $check_error = true;
                    } else {
                        $description_part_9 = filter_var(trim($data_send['description_part_9']), FILTER_SANITIZE_STRING);
                        // Validate
                        if (strlen($description_part_9) < 1) {
                            $errors['description_9'] = 'Error, Description part 9 empty.';
                            $check_error = true;
                        }
                    }
                }
            }
            if (empty($data_send['collection_available_now'])) {
                $collection_available_now = 1;
            } else {
                $collection_available_now = (int)filter_var(trim($data_send['collection_available_now']), FILTER_SANITIZE_STRING);
                // Validate
                if ($collection_available_now < 1) {
                    $errors['collection_hash'] = 'Error, Available empty.';
                    $check_error = true;
                }
                if ($collection_available_now > 1) {
                    if (empty($data_send['collection_date_available'])) {
                        $errors['collection_hash'] = 'Date available is required.';
                        $check_error = true;
                    } else {
                        $collection_date_available = $data_send['collection_date_available'];
                        // Validate
                        if (strlen($collection_date_available) < 10) {
                            $errors['collection_hash'] = 'Error, Date available empty.';
                            $check_error = true;
                        }
                    }
                    if (empty($data_send['collection_time_available'])) {
                        $errors['collection_hash'] = 'Time available is required.';
                        $check_error = true;
                    } else {
                        $collection_time_available = $data_send['collection_time_available'];
                        // Validate
                        if (strlen($collection_time_available) < 5) {
                            $errors['collection_hash'] = 'Error, Time available empty.';
                            $check_error = true;
                        }
                    }
                } else {
                    $collection_date_available = date('Y-m-d');
                    $collection_time_available = date('H:i:s');
                }
            }
        } else {
            if (empty($data_send['collection_name'])) {
            $errors['collection_name'] = 'Name collection is required.';
            $check_error = true;
            } else {
                $collection_name = $data_send['collection_name'];
                $collection_name = filter_var($collection_name, FILTER_SANITIZE_STRING);
                if (strlen($collection_name) < 2) {
                    $errors['collection_name'] = 'Not validd collection_name. Name less than 2 characters.';
                    $check_error = true;
                } 
            }
        }
        if (empty($data_send['img_new_banner'])) {
            $errors['img_new_banner'] = 'New image is required.';
            $check_error = true;
        } else {
            $img_new_banner = filter_var(trim($data_send['img_new_banner']), FILTER_SANITIZE_STRING);
            
            if (strlen($img_new_banner) < 3) {
                $errors['img_new_banner'] = 'Error, link of image very short.';
                $check_error = true;
            }
        }
    } else {
        if (empty($data_send['img_new_banner'])) {
            $errors['new_video'] = 'New video is required.';
            $check_error = true;
        } else {
            $new_video = filter_var(trim($data_send['img_new_banner']), FILTER_SANITIZE_STRING);
            if (strlen($new_video) < 3) {
                $errors['new_video'] = 'Error, link of video very short.';
                $check_error = true;
            }
        }
        if (empty($data_send['collection_video_description'])) {
            $errors['collection_video_description'] = 'Description video is required.';
            $check_error = true;
        } else {
            $collection_video_description = filter_var(trim($data_send['collection_video_description']), FILTER_SANITIZE_STRING);
            if (strlen($collection_video_description) < 3) {
                $errors['collection_video_description'] = 'Error, collection video description very short.';
                $check_error = true;
            }
        }
    }
    if (empty($data_send['collection_hash'])) {
        $errors['collection_hash'] = 'Hash is required.';
        $check_error = true;
    } else {
        $collection_hash = filter_var(trim($data_send['collection_hash']), FILTER_SANITIZE_STRING);
        // Validate hash
        if (strlen($collection_hash) < 1) {
            $errors['collection_hash'] = 'Error, Hash empty.';
            $check_error = true;
        }
    }
} else {
  $errors['session'] = 'Invalid Session';
}
if(!$check_error){
    if ($single < 1) {
        $insert_sql = "INSERT INTO collections(collection_hash, collection_type, collection_name, collection_image, collection_date, collection_user_id_create) SELECT * FROM (SELECT '$collection_hash' as collection_hash, '$type' as collection_type, '$collection_name' as collection_name, '$img_new_banner' as collection_image, NOW() as collection_date, '$user_id' as collection_user_id_create) AS tmp WHERE NOT EXISTS (SELECT collection_hash FROM collections WHERE collection_hash = '$collection_hash') LIMIT 1";
        //###############
        $sSQL_Debug = base64_encode($insert_sql);
        $data['controlOne'] = $sSQL_Debug;
        //###############
        if (Request_DB($insert_sql, $connection)) {
            if ($type == "3") {
                $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
            }
            if ($type == "4") {
                $get_data_sql = "SELECT * FROM collections WHERE collection_hash = '$collection_hash' and collection_active = '0' LIMIT 0,1";
                $sSQL_Debug = base64_encode($get_data_sql);
                $data['controlIdCollection'] = $sSQL_Debug;
                //###############
                if (!$data_collection = get_all($get_data_sql, $connection)) {
                    $errors['database'] = 'Error conected database -> collection ID.';
                    $check_error = true;
                } else {
                    $collecion_id = array_values($data_collection)[0];
                }
                //###############################################################################
                $folder_upload = getcwd() . "/upload/" . $collecion_id . "_";
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_01.txt";
                    $imagem_part_1 = save_file_part($myFile, $data_send['imagem_part_1']);
                    if(!$imagem_part_1){
                        $errors['pieces_1'] = 'Error save file piece -> part one.';
                        $check_error = true;
                    } else {
                        $imagem_part_1 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '1' as collection_piece_col, '1' as collection_piece_line, '$imagem_part_1' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_1') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_1'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part one.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_02.txt";
                    $imagem_part_2 = save_file_part($myFile, $data_send['imagem_part_2']);
                    if(!$imagem_part_2){
                        $errors['pieces_2'] = 'Error save file piece -> part two.';
                        $check_error = true;
                    } else {
                        $imagem_part_2 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '2' as collection_piece_col, '1' as collection_piece_line, '$imagem_part_2' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_2') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_2'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part two.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_03.txt";
                    $imagem_part_3 = save_file_part($myFile, $data_send['imagem_part_3']);
                    if(!$imagem_part_3){
                        $errors['pieces_3'] = 'Error save file piece -> part three.';
                        $check_error = true;
                    } else {
                        $imagem_part_3 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '1' as collection_piece_col, '2' as collection_piece_line, '$imagem_part_3' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_3') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_3'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part three.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_04.txt";
                    $imagem_part_4 = save_file_part($myFile, $data_send['imagem_part_4']);
                    if(!$imagem_part_4){
                        $errors['pieces_4'] = 'Error save file piece -> part four.';
                        $check_error = true;
                    } else {
                        $imagem_part_4 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '2' as collection_piece_col, '2' as collection_piece_line, '$imagem_part_4' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_4') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_4'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part four.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################                
                if (!$check_error) {
                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config-2x2.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                }
                
            }
            if ($type == "5") {
                $get_data_sql = "SELECT * FROM collections WHERE collection_hash = '$collection_hash' and collection_active = '0' LIMIT 0,1";
                $sSQL_Debug = base64_encode($get_data_sql);
                $data['controlIdCollection'] = $sSQL_Debug;
                //###############
                if (!$data_collection = get_all($get_data_sql, $connection)) {
                    $errors['database'] = 'Error conected database -> collection ID.';
                    $check_error = true;
                } else {
                    $collecion_id = array_values($data_collection)[0];
                }
                //###############################################################################
                $folder_upload = getcwd() . "/upload/" . $collecion_id . "_";
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_01.txt";
                    $imagem_part_1 = save_file_part($myFile, $data_send['imagem_part_1']);
                    if(!$imagem_part_1){
                        $errors['pieces_1'] = 'Error save file piece -> part one.';
                        $check_error = true;
                    } else {
                        $imagem_part_1 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '1' as collection_piece_col, '1' as collection_piece_line, '$imagem_part_1' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_1') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_1'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part one.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_02.txt";
                    $imagem_part_2 = save_file_part($myFile, $data_send['imagem_part_2']);
                    if(!$imagem_part_2){
                        $errors['pieces_2'] = 'Error save file piece -> part two.';
                        $check_error = true;
                    } else {
                        $imagem_part_2 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '2' as collection_piece_col, '1' as collection_piece_line, '$imagem_part_2' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_2') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_2'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part two.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_03.txt";
                    $imagem_part_3 = save_file_part($myFile, $data_send['imagem_part_3']);
                    if(!$imagem_part_3){
                        $errors['pieces_3'] = 'Error save file piece -> part three.';
                        $check_error = true;
                    } else {
                        $imagem_part_3 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '3' as collection_piece_col, '1' as collection_piece_line, '$imagem_part_3' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_3') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_3'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part three.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_04.txt";
                    $imagem_part_4 = save_file_part($myFile, $data_send['imagem_part_4']);
                    if(!$imagem_part_4){
                        $errors['pieces_4'] = 'Error save file piece -> part four.';
                        $check_error = true;
                    } else {
                        $imagem_part_4 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '1' as collection_piece_col, '2' as collection_piece_line, '$imagem_part_4' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_4') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_4'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part four.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################                
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_05.txt";
                    $imagem_part_5 = save_file_part($myFile, $data_send['imagem_part_5']);
                    if(!$imagem_part_5){
                        $errors['pieces_5'] = 'Error save file piece -> part five.';
                        $check_error = true;
                    } else {
                        $imagem_part_5 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '2' as collection_piece_col, '2' as collection_piece_line, '$imagem_part_5' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_5') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_5'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part five.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_06.txt";
                    $imagem_part_6 = save_file_part($myFile, $data_send['imagem_part_6']);
                    if(!$imagem_part_6){
                        $errors['pieces_6'] = 'Error save file piece -> part six.';
                        $check_error = true;
                    } else {
                        $imagem_part_6 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '3' as collection_piece_col, '2' as collection_piece_line, '$imagem_part_6' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_6') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_6'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part six.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_07.txt";
                    $imagem_part_7 = save_file_part($myFile, $data_send['imagem_part_7']);
                    if(!$imagem_part_7){
                        $errors['pieces_7'] = 'Error save file piece -> part seven.';
                        $check_error = true;
                    } else {
                        $imagem_part_7 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '1' as collection_piece_col, '3' as collection_piece_line, '$imagem_part_7' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_7') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_7'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part seven.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_08.txt";
                    $imagem_part_8 = save_file_part($myFile, $data_send['imagem_part_8']);
                    if(!$imagem_part_8){
                        $errors['pieces_8'] = 'Error save file piece -> part eigth.';
                        $check_error = true;
                    } else {
                        $imagem_part_8 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '2' as collection_piece_col, '3' as collection_piece_line, '$imagem_part_8' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_8') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_8'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part eigth.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    $myFile = $folder_upload . $collection_hash . "_part_09.txt";
                    $imagem_part_9 = save_file_part($myFile, $data_send['imagem_part_9']);
                    if(!$imagem_part_9){
                        $errors['pieces_9'] = 'Error save file piece -> part nine.';
                        $check_error = true;
                    } else {
                        $imagem_part_9 = $myFile;
                        $insert_sql = "INSERT INTO collections_pieces(`collection_master_hash`, `collection_master_id`, `collection_part`, `collection_piece_type`, `collection_piece_integer`, `collection_piece_col`, `collection_piece_line`, `collection_piece_image`) SELECT * FROM (SELECT '$collection_hash' as collection_master_hash, '$collecion_id' as collection_master_id, '0' as collection_part, '$type' as collection_piece_type, '0' as collection_piece_integer, '3' as collection_piece_col, '3' as collection_piece_line, '$imagem_part_9' as collection_piece_image) AS tmp WHERE NOT EXISTS (SELECT collection_master_hash FROM collections_pieces WHERE collection_master_hash = '$collection_hash' and collection_piece_image = '$imagem_part_9') LIMIT 1;";
                        //###############
                        $sSQL_Debug = base64_encode($insert_sql);
                        $data['controlParts_9'] = $sSQL_Debug;
                        //###############
                        if (!Request_DB($insert_sql, $connection)) {
                            $errors['parts'] = 'Error update piece in database collection - part nine.';
                            $check_error = true;
                        }
                    }
                }
                //###############################################################################
                if (!$check_error) {
                    if($type == "4"){
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config-2x2.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                    }                
                    if($type == "5"){
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config-3x3.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                    }                    
                }
                
            }
        } else {
            $errors['update'] = 'Error update collection.';
        }
    } else {
        // Update collection
        if($video < 1){
            if($collection_available_now == "1"){
                $collection_active = 1;
            } else {
                $collection_active = 0;
            }
            $update_sql = "UPDATE collections SET collection_description = '$single_part_collection_piece_description', collection_miniature = '$img_new_banner', collection_miniature_description = '$miniature_collection_piece_description', collection_available_now = '$collection_available_now', collection_date_available = '$collection_date_available', collection_time_available = '$collection_time_available', collection_active = '$collection_active' WHERE collection_hash = '$collection_hash' ";
            //###############
            $sSQL_Debug = base64_encode($update_sql);
            $data['controlTwo'] = $sSQL_Debug;
            //###############
            if (Request_DB($update_sql, $connection)) {
                if ($type == "3") {
                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/send_delights.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                }
                if ($type == "4" and $video < 1) {
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_1' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '4' and collection_piece_col = '1' and collection_piece_line = '1' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType4_1'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 1';
                        $check_error = true;
                    }
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_2' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '4' and collection_piece_col = '2' and collection_piece_line = '1' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType4_2'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 2';
                        $check_error = true;
                    }
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_3' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '4' and collection_piece_col = '1' and collection_piece_line = '2' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType4_3'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 3';
                        $check_error = true;
                    }
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_4' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '4' and collection_piece_col = '2' and collection_piece_line = '2' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType4_4'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 4';
                        $check_error = true;
                    }
                    if(!$check_error){
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config-video.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                    }
                }
                if ($type == "5" and $video < 1) {
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_1' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '1' and collection_piece_line = '1' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_1'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 1';
                        $check_error = true;
                    }
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_2' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '2' and collection_piece_line = '1' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_2'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 2';
                        $check_error = true;
                    }
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_3' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '3' and collection_piece_line = '1' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_3'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 3';
                        $check_error = true;
                    }
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_4' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '1' and collection_piece_line = '2' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_4'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 4';
                        $check_error = true;
                    }
                    //###############
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_5' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '2' and collection_piece_line = '2' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_5'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 5';
                        $check_error = true;
                    }
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_6' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '3' and collection_piece_line = '2' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_6'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 6';
                        $check_error = true;
                    }
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_7' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '1' and collection_piece_line = '3' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_7'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 7';
                        $check_error = true;
                    }
                    //###############
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_8' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '2' and collection_piece_line = '3' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_8'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 8';
                        $check_error = true;
                    }
                    //###############
                    $update_sql = "UPDATE collections_pieces SET collection_piece_description = '$description_part_9' WHERE collection_master_hash = '$collection_hash' and collection_piece_type = '5' and collection_piece_col = '3' and collection_piece_line = '3' ";
                    //###############
                    $sSQL_Debug = base64_encode($update_sql);
                    $data['controlType_5_9'] = $sSQL_Debug;
                    //###############
                    if (!Request_DB($update_sql, $connection)) {
                        $errors['parts'] = 'Error update description part 9';
                        $check_error = true;
                    }
                    //###############
                    if(!$check_error){
                        $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/collections-config-video.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
                    }
                    //###############
                }
            } else {
                $errors['update'] = 'Error update collection.';
            }
        } else {
            //Update Video File and Video Description
            $update_sql = "UPDATE collections SET collection_video = '$new_video', collection_video_description = '$collection_video_description' WHERE collection_hash = '$collection_hash' ";
            //###############
            $sSQL_Debug = base64_encode($update_sql);
            $data['controlVideo'] = $sSQL_Debug;
            //###############
            if (!Request_DB($update_sql, $connection)){
                $errors['update'] = 'Error update video file or video description.';
            } else {
                $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/send_delights.php?token=" . $access_token_setting . "&collection_hash=" . $collection_hash . "'</script>";
            }
        }
    }
} else {
    $errors['msg'] = 'Errors collections';
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