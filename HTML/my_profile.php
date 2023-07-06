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
$banner = [];
$bannerBig = [];
$user_email = "";
$login_code = 0;
$myFile = "";
$fh = "";
$theData = "";
$message = "";
$token = [];
$access_token = "";
$s_user_id = 0;
$user_id = 0;
$user_group = 0;
$get_data_sql = "";
$time = "";
$collections_list = [];
$data_collection = [];
$collection_hash = "";
$x = 1;
$collection_selected = [];
$first_collection = [];
$total_collections = 0;
$total_conections = 0;
$total_chat_unread = 0;
$i = 1;
$result = array();
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
if(isset($_GET['collection_hash'])) {$collection_hash = $_GET['collection_hash'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//####################################
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}
//
if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
    $user_group = $data_token['user_group'];
    $user_name = $data_token['user_name'];
    $user_id = $data_token['user_id'];
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "0"){
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
    } else {
        ////###############
        $get_data_sql = "SELECT * FROM exchange WHERE exchange_send = '$user_id'";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //############### get_total_rows($sSQL = NULL, $connection)
        if (!$total_collections = get_total_rows($get_data_sql, $connection)) {
          $total_collections = 0;
        }
        ////###############
        $get_data_sql = "SELECT * FROM connections WHERE connection_my_user_id = '$user_id'";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //############### get_total_rows($sSQL = NULL, $connection)
        if (!$total_conections = get_total_rows($get_data_sql, $connection)) {
            $total_conections = 0;
        }
        ////###############
        $get_data_sql = "SELECT * FROM conversations WHERE conversation_sender = '$user_id'";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //############### get_total_rows($sSQL = NULL, $connection)
        if (!$total_chat_unread = get_total_rows($get_data_sql, $connection)) {
            $total_chat_unread = 0;
        }
        ////###############
        $get_data_sql = "SELECT * FROM inventory WHERE inventory.inventory_user_id = '$user_id' ORDER BY inventory_id DESC";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //###############
        $collections_list = get_all_data($get_data_sql, $connection);
        //print_r($collections_list);
        //exit('debug collections');
        ////###############
        ////#############
        $get_collections_plataform = "SELECT * FROM inventory LEFT JOIN collections ON inventory.inventory_collection_hash = collections.collection_hash WHERE inventory.inventory_user_id = '$user_id' and (collections.collection_type > 3 OR collections.collection_type = 3)";
        if(!$get_collections_plataform = get_all_data($get_collections_plataform, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          foreach($get_collections_plataform as $item) {
              $result[] = array(
                  'inventory_id' => $item['inventory_id'],
                  'inventory_user_id' => $item['inventory_user_id'],
                  'collection_type' => $item['collection_type'],
                  'collection_name' => $item['collection_name'],
                  'collection_image' => $item['collection_image'],
                  'collection_hash' => $item['collection_hash'],
                  'collection_piece_id' => $item['collection_piece_id'],
                  'collection_piece_image' => $item['collection_piece_image'],
                  'collection_part' => $item['collection_part'],
                  'collection_piece_col' => $item['collection_piece_col'],
                  'collection_piece_line' => $item['collection_piece_line']
              );
          }
        }
        //###############
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
</head>
<body>
    <section id="container_home">
        <div class="container_home">
            <div class="container_home_int">
                <div class="area_home">
                    <div class="menu_header">
                        <div class="icon_menu">
                            <nav class="nav">
                                <input type="checkbox" class="checkbox" id="checkbox">
                                <label for="checkbox" class="label_menu">
                                    <!--<img width="27px" height="27px" src="img/Icon_Menu.png" alt="">-->
                                    <span class="menu_hamburguer"></span>
                                </label>
                                <div class="container_menu home">
                                    <div class="container_menu_int">
                                        <div class="area_menu">
                                            <div class="logo_menu">
                                                <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                                            </div>
                                            <div class="social_icons">
                                                <img src="img/instagram.png" alt="">
                                                <img src="img/facebook.png" alt="">
                                                <img src="img/world.png" alt="">
                                            </div>
                                            <nav>
                                                <?php require_once("menu-nav.php");?>
                                            </nav>
                                        </div>
                                    </div>
                                    <footer>
                                        <div class="collectibles">
                                            <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                                            <h2>My Collectibles</h2>
                                        </div>
                                    </footer>
                                </div>
                            </nav>
                        </div>
                        <div class="logo_home">
                            <img width="30px" height="30px" src="img/logo_small.png" alt="Patisserie">
                            <div class="collectibles_home">
                                <h2>My Collectibles</h2>
                            </div>
                        </div>
                    </div>
                    <form action="#" method="POST">
                        <div class="area_form">
                            <input type="text" name="search" class="search" placeholder="Search">
                            <img class="icon_search" src="img/Icon_Search.png" alt="">
                        </div>
                    </form>
                    <div class="area_profile">
                        <div class="area_profile_int">
                            <div class="title_profile">
                                <h2>Hello, <?php echo $user_name;?></h2>
                                <a target="_self" href="<?php echo "https://thechefmelo.com/account.php?token=".$access_token_seting . "&v=".$time;?>">
                                    <img width="10px" height="10px" src="img/edit.png" alt="">
                                </a>
                            </div>
                            <div class="icons_profile">
                                <div class="icons_collectibles">
                                    <div class="area_icons_collectibles">
                                        <img src="img/collectibles.png" alt="">
                                        <h2><p><?php echo(isset($total_collections) ? $total_collections : '0');?></p></h2>
                                    </div>
                                    <div class="title_icons_collectibles">
                                        <p>collectibles</p>
                                    </div>
                                </div>
                                <div class="icons_connections">
                                    <div class="area_icons_connections">
                                        <img src="img/connections.png" alt="">
                                        <h2><p><?php echo(isset($total_conections) ? $total_conections : '0');?></p></h2>
                                    </div>
                                    <div class="title_icons_connections">
                                        <p>connections</p>
                                    </div>
                                </div>
                                <a target="_self" href="<?php echo "https://thechefmelo.com/chat.php?token=".$access_token_seting . "&v=".$time;?>">
                                    <div class="icons_chats">
                                        <div class="area_icons_chats">
                                            <img src="img/chats.png" alt="">
                                            <h2><p><?php echo(isset($total_chat_unread) ? $total_chat_unread : '0');?></p></h2>
                                        </div>
                                        <div class="title_icons_chats">
                                            <p>chats</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="bar"></div>
                    <div class="area_grid_collectible">
                        <div class="area_grid_collectible_int">
                            <div class="area_texts_collectible">
                                <div class="title_collectible">
                                    <h2>My collectible delights</h2>
                                </div>
                                <div class="page_collectible">
                                    <select name="pages" id="pages" style="background-color: #FFF; border: none;" onchange="changePage()" onblur="changePage()">
                                        <?php if(isset($collections_list)):?>
                                            <?php foreach($collections_list as $data_collection):?>
                                                <div class="community">                                                                        
                                                    <img width="80px" height="60px" src="<?php echo(!empty($data_collection['collection_miniature']) ? $data_collection['collection_miniature'] : '');?>" alt="<?php echo(isset($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>">
                                                    <h2><?php echo(!empty($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?></h2>
                                                </div>
                                                <option value="<?php echo (!empty($data_collection['inventory_collection_hash']) ? $data_collection['inventory_collection_hash'] : '0'); ?>" <?php echo ((!empty($collection_hash) && $data_collection['inventory_collection_hash'] == $collection_hash) ? 'selected' : ''); ?>>Page <?php echo $x;?></option>
                                                <!-- START GET FIRST COLLECTION -->
                                                <?php if($x == "1"):?>
                                                    <?php $first_collection['first_image'] = $data_collection['collection_image'];?>
                                                    <?php $first_collection['first_name'] = $data_collection['collection_name'];?>
                                                <?php endif;?>
                                                <!-- END GET FIRST COLLECTION -->
                                                <!-- START GET SELECTED COLLECTION -->
                                                <?php if($data_collection['collection_hash'] == $collection_hash):?>
                                                    <?php $collection_selected['collection_image'] = $data_collection['collection_image'];?>
                                                    <?php $collection_selected['collection_name'] = $data_collection['collection_name'];?>
                                                <?php endif;?>
                                                <!-- END GET SELECTED COLLECTION -->                        
                                                <?php $x++;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <?php foreach ($result as $itemCollection):?>
                                <div class="grid_template_collectible" style="margin: 0 auto;">                                    
                                    <?php if(isset($itemCollection['collection_type']) && $itemCollection['collection_type'] == "3"):?>
                                        <!--//Item Single-->
                                        <?php echo(isset($itemCollection['collection_image']) ? "<img width='350px' height='350px' src=".$itemCollection['collection_image'].">" : '');?>
                                    <?php else:?>
                                        <!--//Item 2x2 ou 3x3 -->
                                        <?php if(isset($itemCollection['collection_type']) && $itemCollection['collection_type'] == "4"):?>
                                            <!--//Item 2x2 -->
                                            <?php 
                                                $lines = array(1, 2);
                                                $cols = array(1, 2);
                                                
                                                foreach ($lines as $line) {
                                                    foreach ($cols as $col) {
                                                        $found = false;
                                                        foreach ($itemCollection as $item) {
                                                            if ($item['collection_piece_line'] == $line && $item['collection_piece_col'] == $col) {
                                                                //echo "Achei imagem " . $line . ' ' .  $col; 
                                                                if(isset($item['collection_piece_image'])){
                                                                    $openImageBase64 = "";
                                                                    $myFile = $item['collection_piece_image'];
                                                                    $fh = fopen($myFile, 'r');
                                                                    $theData = fread($fh, filesize($myFile));
                                                                    fclose($fh);
                                                                    $openImageBase64 = $theData;
                                                                }
                                                                echo(isset($openImageBase64) ? "<img width='175px' height='175px' src=".$openImageBase64.">" : '');
                                                                $found = true;
                                                                break;
                                                            }
                                                        }
                                                        if (!$found) {
                                                            //echo "Imagem " .  $line . ' ' .  $col. " não encontrada";
                                                            echo "<img src='img/box_2.png' alt=''>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        <?php else:?>
                                            <!--//Item 3x3 -->
                                            <?php 
                                                $lines = array(1, 2, 3);
                                                $cols = array(1, 2, 3);
                                                
                                                foreach ($lines as $line) {
                                                    foreach ($cols as $col) {
                                                        $found = false;
                                                        foreach ($itemCollection as $item) {
                                                            if ($item['collection_piece_line'] == $line && $item['collection_piece_col'] == $col) {
                                                                //echo "Achei imagem " . $line . ' ' .  $col; 
                                                                if(isset($item['collection_piece_image'])){
                                                                    $openImageBase64 = "";
                                                                    $myFile = $item['collection_piece_image'];
                                                                    $fh = fopen($myFile, 'r');
                                                                    $theData = fread($fh, filesize($myFile));
                                                                    fclose($fh);
                                                                    $openImageBase64 = $theData;
                                                                }
                                                                echo(isset($openImageBase64) ? "<img width='116px' height='116px' src=".$openImageBase64.">" : '');
                                                                $found = true;
                                                                break;
                                                            }
                                                        }
                                                        if (!$found) {
                                                            //echo "Imagem " .  $line . ' ' .  $col. " não encontrada";
                                                            echo "<img src='img/box_2.png' alt=''>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        <?php endif;?>
                                    <?php endif;?>                                    
                                </div>
                            <?php endforeach;?>
                            <div class="collection_name">
                            <h2><?php echo(isset($itemCollection['collection_name']) ? $itemCollection['collection_name'] : '');?></h2>
                            </div>
                            <div class="area_dots">
                                <div class="dot active"></div>
                                <div class="dot"></div>
                                <div class="dot"></div>
                                <div class="dot"></div>
                            </div>
                        </div>
                    </div>
                    <div class="menu_footer">
                        <div class="menu_footer_int">
                            <div class="area_menu_footer">
                                <?php require_once("menu-footer.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="loader"></div>
    <script>
    function changePage(){
      const page = document.getElementById("pages").value;
      const link_page = "<?php echo "https://thechefmelo.com/my_profile.php?token=".$access_token_seting ."&v=".$time . "&collection_hash=";?>" + page;
      window.location = link_page;
    }
    </script>
</body>
</html>