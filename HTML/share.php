<?php
//####################################################
//####################################################
//####################################################
//Projeto Contratado Via Workana 
//Desenvolvedor Giovanni Barbosa
//https://www.workana.com/freelancer/8f1f0c0f1e3374c5aecbd8edb6a19a06
//####################################################
//####################################################
//####################################################
require_once("header.php");
//####################################################
//####################################################
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
$send_today = [];
$total_users = 0;
$list_users_random = [];
$detect_type_collecion = "";
$collection = [];
$distribuidas = [];
$pessoas = [];
$figurinhas = [];
$user_selected = 0;
$exchange_hash = "";
$inventory_hash = "";
$imageCollectionSend = "";
$name_collection = "";
$data_collection = "";
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
    if ($type > 0) {
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
        $get_data_sql = "SELECT * FROM collections_share_daily WHERE collection_share_daily_date = '$today' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        $data['Debug'] = $data['Debug'] . "#001";
        //###############
        if ($send_today = get_all($get_data_sql, $connection)) {
            //$errors['share'] = 'Dont send more one randomly collections today.';
            //$check_error = true;
        } else {
            //
            $data['Debug'] = $data['Debug'] . "#002";
            $get_data_sql = "SELECT * FROM users WHERE user_group = '0' ";
            if (!$total_users = get_total_rows($get_data_sql, $connection)) {
                $errors['share'] = 'Error -> list users smaller one';
                $check_error = true;
            } else {
                $data['Debug'] = $data['Debug'] . "#003";
                $data['totalUsers'] = $total_users;
                if($total_users > 5){
                    //Somente calcular o percentual de 20% de usuários se a lista usuários for maior que 5
                    $total_users = (int)$total_users * (float)0.2;
                }                
                if($total_users < 1){
                    $errors['share'] = 'Error -> list users smaller one';
                    $check_error = true;
                }
                if(!$check_error){
                    $data['Debug'] = $data['Debug'] . "#004";
                    $get_data_sql = "SELECT * FROM users Where user_group = '0' ORDER BY RAND() LIMIT $total_users ";
                    $data['controlUsersRandom'] = base64_encode($get_data_sql);
                    if (!$list_users_random = get_by_data($get_data_sql, $connection, "user_id")) {
                        $errors['share'] = 'Error conected database -> list users random';
                        $check_error = true;
                    } else {
                        $data['Debug'] = $data['Debug'] . "#005";
                        $data['list_users_random'] = base64_encode($list_users_random);
                        $pessoas = array($list_users_random);
                        shuffle($pessoas); //Embaralhar o array para distribuir as coleções aleatoriamente
                        if(!empty($collection_hash)){
                            $detect_type_collecion = "SELECT * FROM collections Where collection_hash = '$collection_hash' ";
                        } else {
                            $detect_type_collecion = "SELECT * FROM collections Where (collection_type > 0) and collection_active < 2 ORDER BY RAND() LIMIT 1";
                        }
                        $data['detect_type_collecion'] = base64_encode($detect_type_collecion);
                        if (!$collection = get_all($detect_type_collecion, $connection)) {
                            $errors['share'] = 'Error -> collection return empty';
                            $check_error = true;
                        } else {
                            $data['Debug'] = $data['Debug'] . "#006";
                            $data['collection'] = array_values($collection)[2];
                            $collection_hash = array_values($collection)[1];
                            if(array_values($collection)[2] < 4){
                                // Single Image
                                $data['Debug'] = $data['Debug'] . "#007a";
                                $figurinha = array_values($collection)[0]; // especificar id collection
                                foreach ($pessoas as $pessoa) {
                                    $user_selected = array_pop($pessoas); //Selecionar aleatoriamente um usuário
                                    $distribuidas[$pessoa] = (isset($distribuidas[$pessoa])) ? $distribuidas[$pessoa] + 1 : 1; //Armazenar a quantidade de figurinhas que a pessoa recebeu
                                    $data['shareCollectionRandom'] = "A pessoa $pessoa recebeu a figurinha $figurinha <br/>"; //Exibir a figurinha que a pessoa recebeu
                                    //##################################################################################
                                    $exchange_hash = substr(str_shuffle("0123456789/*-+._-ABCDEFGHIJLKMNOPQRSTUVWYXZabcdefghijklmnopqrstuvwxyz"), 0, 33);
                                    $inventory_hash = $pessoa . '-' . $figurinha . '-' . $exchange_hash;
                                    $exchange_hash = $pessoa . '-' . $figurinha . '-' . date('Y-m-d-H-i-s') . '-' . $exchange_hash;
                                    //##################################################################################
                                    $insert_sql = "INSERT INTO exchange(exchange_hash, exchange_active, exchange_from, exchange_from_admin, exchange_send, exchange_collection_id, exchange_collection_hash, exchange_collection_type, exchange_date) SELECT * FROM (SELECT '$exchange_hash' as exchange_hash, '1' as exchange_active, '1' as exchange_from, '0' as exchange_from_admin, '$pessoa' as exchange_send, '$figurinha' as exchange_collection_id, '$collection_hash' as exchange_collection_hash, '3' as exchange_collection_type, NOW() as exchange_date) AS tmp WHERE NOT EXISTS (SELECT exchange_hash FROM exchange WHERE exchange_hash = '$exchange_hash') LIMIT 1";
                                    if (Request_DB($insert_sql, $connection)) {
                                        $data['createRegistryExchange'] = $insert_sql;
                                        $insert_sql = "INSERT INTO inventory(inventory_hash, inventory_exchange_hash, inventory_user_id, inventory_collection_id, inventory_collection_hash, inventory_collection_part, inventory_from, inventory_message, inventory_collection_complete, inventory_open_video, inventory_randomly, inventory_owner) SELECT * FROM (SELECT '$inventory_hash' as inventory_hash, '$exchange_hash' as inventory_exchange_hash, '$pessoa' as inventory_user_id, '$figurinha' as inventory_collection_id, '$collection_hash' as inventory_collection_hash, '' as inventory_collection_part, '1' as inventory_from, 'Chef Melo sent One Collectible' as inventory_message, '0' as inventory_collection_complete, '0' as inventory_open_video, '1' as inventory_randomly, '1' as inventory_owner) AS tmp WHERE NOT EXISTS (SELECT inventory_hash, inventory_exchange_hash FROM inventory WHERE inventory_hash = '$inventory_hash' and inventory_exchange_hash = '$exchange_hash') LIMIT 1";
                                        if (Request_DB($insert_sql, $connection)) {
                                            $data['createRegistryInventory'] = $insert_sql;
                                            $imageCollectionSend = array_values($collection)[5];
                                            $name_collection = array_values($collection)[3];
                                            $insert_sql = "INSERT INTO feeds(feed_hash, feed_my_user_id, feed_message, feed_image, feed_date) SELECT * FROM (SELECT '$exchange_hash' as feed_hash, '$pessoa' as feed_my_user_id, 'Received One Collectible ".$name_collection." by Chef Melo' as feed_message, '$imageCollectionSend' as feed_image, NOW() AS feed_date) AS tmp WHERE NOT EXISTS (SELECT feed_hash FROM feeds WHERE feed_hash = '$exchange_hash') LIMIT 1";
                                            if (Request_DB($insert_sql, $connection)) {
                                                $data['createRegistryFeed'] = $insert_sql;
                                                $insert_sql = "INSERT INTO feeds(feed_hash, feed_my_user_id, feed_message, feed_image, feed_date) SELECT * FROM (SELECT '$exchange_hash' as feed_hash, '1' as feed_my_user_id, 'Share One Collectible ".$name_collection."' as feed_message, '$imageCollectionSend' as feed_image, NOW() AS feed_date) AS tmp WHERE NOT EXISTS (SELECT feed_hash FROM feeds WHERE feed_hash = '$exchange_hash') LIMIT 1";
                                                if (Request_DB($insert_sql, $connection)) {
                                                    $data['createRegistryFeedAdmin'] = $insert_sql;
                                                }
                                            }
                                        }
                                    }
                                    $inventory_hash = "";
                                    $exchange_hash = "";
                                }
                            } else {
                                // Collection 2x2 or 3x3
                                $data['Debug'] = $data['Debug'] . "#007b";
                                $detect_type_collecion = "SELECT * FROM collections_pieces Where collection_master_hash = '$collection_hash' LIMIT 0,9";
                                $data['detect_type_collecion>3'] = base64_encode($detect_type_collecion);
                                if (!$collection = get_all_data($detect_type_collecion, $connection)) {
                                    $errors['share'] = 'Error -> collection return empty';
                                    $check_error = true;
                                }
                                if(!$check_error){                                    
                                    $figurinhas = ""; //Criar um array com as figurinhas
                                    $data['parts'] = $collection;
                                    //
                                    $data_collection = json_decode($collection);
                                    foreach ($data_collection as $value) {
                                        $figurinhas = $figurinhas . $value->collection_piece_id .',';
                                    }
                                    //
                                    $figurinhas = explode(',', $figurinhas);
                                    shuffle($figurinhas); //Embaralhar o array para distribuir as figurinhas aleatoriamente
                                    $data['figurinhas'] = $figurinhas;
                                    $distribuidas = array(); //Criar um array para armazenar a quantidade de figurinhas distribuídas
                                    //
                                    foreach($figurinhas as $item) {
                                        foreach ($pessoas as $pessoa) {
                                            $figurinha = array_pop($figurinhas); //Selecionar aleatoriamente uma figurinha
                                            $distribuidas[$pessoa] = (isset($distribuidas[$pessoa])) ? $distribuidas[$pessoa] + 1 : 1; //Armazenar a quantidade de figurinhas que a pessoa recebeu
                                            $data['CollectionRandom>3'] = "A pessoa $pessoa recebeu a figurinha $figurinha <br/>"; //Exibir a figurinha que a pessoa recebeu
                                        }
                                    }
                                }
                            }
                        }                        
                    }
                }
            }
           if(!$check_error){
                $data['Debug'] = $data['Debug'] . "#008";
                $insert_sql = "INSERT INTO collections_share_daily(`collection_share_daily_date`) SELECT * FROM (SELECT '$today' as collection_share_daily_date) AS tmp WHERE NOT EXISTS (SELECT collection_share_daily_date FROM collections_share_daily WHERE collection_share_daily_date = '$today') LIMIT 1;";
                //###############
                $sSQL_Debug = base64_encode($insert_sql);
                $data['shareRandomly'] = $sSQL_Debug;
                //###############
                if (!Request_DB($insert_sql, $connection)) {
                    $errors['share'] = 'Error dont send collections randomly.';
                    $check_error = true;
                } else {
                    $url_redirect = "<script type='text/javascript'>window.location = 'https://thechefmelo.com/my.php?token=" . $access_token_setting . "'</script>";
                }
           }
        }
    }
} else {
  $errors['session'] = 'Invalid Session';
}
if(!$check_error){
    $data['Debug'] = $data['Debug'] . "#009";
    if ($single < 1) {
        $data['Debug'] = $data['Debug'] . "#0010";
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
        $data['Debug'] = $data['Debug'] . "#0011";
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