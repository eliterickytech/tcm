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
$data_admin_user = [];
$data_user = [];
$user_id = 0;
$user_registry_key = "";
$i = 0;
$get_newst_five_feed_my_frieds = "";
$total_collections = 0;
$total_conections = 0;
$total_chat_unread = 0;
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
//####################################
foreach ($access_token as $key => $value) {
    $data_token[$key] = $value;
}
////
if ($data_token['session'] == session_id()) {
    //####################################
    require_once("con_mysql.php");
    //####################################
    $user_id = $data_token['user_id'];
    $login_code = $data_token['login_code'];
    $user_email = $data_token['user_email'];
    $user_group = $data_token['user_group'];
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "0"){
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
    } else {
        ////###############
        $get_data_sql = "SELECT * FROM banner WHERE banner_id = '1' and banner_type = '0' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //###############
        if (!$banner = get_all($get_data_sql, $connection)) {
            echo "Error conected database -> banner 0";
            exit();
        }
        $get_data_sql = "SELECT * FROM banner WHERE banner_id = '2' and banner_type = '1' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlTwo'] = $sSQL_Debug;
        //###############
        if (!$bannerBig = get_all($get_data_sql, $connection)) {
            echo "Error conected database -> banner 0";
            exit();
        }
        ////###############
        $get_data_sql = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $data_user = get_all_data($get_data_sql, $connection);
        //print_r($data_user);
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1' ORDER BY collection_id DESC LIMIT 0,10";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlThree'] = $sSQL_Debug;
        //###############
        $collections_list = get_all_data($get_data_sql, $connection);
        //print_r($collections_list);
        //exit('debug collections');
        ////###############
        $get_newst_five_feed_my_frieds = "SELECT f.*, u.user_name FROM feeds f INNER JOIN users u ON f.feed_my_user_id = u.user_id INNER JOIN connections c ON c.connection_my_friend_id = u.user_id WHERE c.connection_invite = 1 and c.connection_my_user_id = '$user_id' ORDER BY f.feed_id DESC LIMIT 3";
        if(!$get_newst_five_feed_my_frieds = get_all_data($get_newst_five_feed_my_frieds, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          $result = array();
          foreach($get_newst_five_feed_my_frieds as $item) {
              $result[] = array(
                  'user_name' => $item['user_name'],
                  'feed_message' => $item['feed_message'],
                  'feed_date' => $item['feed_date'],
                  'feed_image' => $item['feed_image']
              );
          }
        }
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
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="css/07.css?v=<?php echo $time;?>" />
    <link rel="stylesheet" href="css/07_b.css?v=<?php echo $time;?>" />
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/user_admin.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap"/>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </head>
  <body onload="onLoad()" class="access">
    <div class="community-usurio-comum">
      <div class="community-usurio-comum-child"></div>
      <div class="community-usurio-comum-item"></div>
      <b class="chat-with-us">CHAT WITH US</b>
      <div class="collectible-delights-in-the-co">
        Collectible delights in the Community
      </div>
      <div class="friends-activity">Friend's activity</div>
      <div class="you-have-2-unread-chats">
        <span>You have </span><span class="span"><?php echo $total_chat_unread;?></span
        ><span> unread chats</span>
      </div>
      <div class="browse-by-sport" style="max-width: 425px; overflow-x: scroll; overflow-y: hidden; white-space: nowrap;">

        <?php if(isset($collections_list)):?>
            <?php foreach($collections_list as $data_collection):?>
                <?php $i++;?>                                                                        
                <img class="sport-<?php echo $i;?>-icon" src="<?php echo(!empty($data_collection['collection_miniature']) ? $data_collection['collection_miniature'] : '');?>" alt="<?php echo(isset($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?>">
                <!-- <h2 class="valentines"><?php echo(!empty($data_collection['collection_name']) ? $data_collection['collection_name'] : 'empty name');?></h2> -->
            <?php endforeach;?>
        <?php endif;?>

      </div>
      <?php foreach($result as $item):?>
        <div class="user-name1-just-shared-a-vanco">
          <span class="user-name1"><?php echo(isset($item['user_name']) ? $item['user_name'] : '');?></span><span class="just-shared-a"><?php echo(isset($item['feed_message']) ? $item['feed_message'] : '');?></span>
        </div>
      <div class="div"><?php echo(isset($item['eed_date']) ? $item['feed_date'] : '');?></div>
      <?php endforeach;?>
      <div class="a-strong-community-is-made-of">
        A strong community is made of sharing, love and good conversations!
      </div>
      <div class="advertising">
        <?php if(isset($banner)):?>
            <?php echo(isset(array_values($banner)[3]) ? '<a href="'.array_values($banner)[3].'" target="_blank">' : '');?>
                <img class="advertising-icon" width="375px" height="70px" src="<?php echo(isset(array_values($banner)[4]) ? array_values($banner)[4] : '');?>" alt="<?php echo(isset(array_values($banner)[1]) ? array_values($banner)[1] : '');?>">
            <?php echo(isset(array_values($banner)[3]) ? '</a>' : '');?>
        <?php endif;?>
      </div>
      <div class="fixed-itens-bg-superior"></div>
      <div
      form id="search" class="search-bar">
        <div class="barra-de-pesquisa"></div>
        <input type="text" id="search-bar" class="search-bar" placeholder="Search">
        <a href="#"></a>
      </form>
     </div>
      <img class="icon-side-menu" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63adaa2b2434a4e554746687/f8491da2-3b82-44fa-a12c-507e834c5db5_1672325708144518547?Expires=-62135596800&Signature=Gtn31AYH2D5zFfIIhObRPjBuVQsKP3E3g28JSXbKCi0GIMby6cgbggHGBk-UPdDcyTS6eLyOtBAD5LLLVXzCcpJEabt5UrZbDVYb3V4z16RlwrAiFTtlVw5BJjPjjDC4ukkSZwUZTltYbS7Tt1d9Ovpz2JDR8H0hA4~6s8BPgB93kr0A1WOP-glcKYz6nXY6xXwKTovEbc~Vz3NiwmYPLHWvXRpzBiTRJPTvTNXKnaK9GMZzLAjSKPPS2kbZr4spgLYXZc9wLJlWe0hfo-Y2xOpJJ0HkjffsKJo-mSQ0iy4Kutuq4ywgRd4ZB~UPStsKxexF53~D6mwhWDe4nv5s1g__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="menu-inferior"></div>
      <a target="_self" href="<?php echo "https://thechefmelo.com/home.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="icon-home-in-parent">
        <img id="home" class="icon-home-in" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e0e6504c63b433038bcd/9723cced-6a90-4d75-b08d-e375dd6e4bdc_1672077548803611796?Expires=-62135596800&Signature=DNWA9l7dKuCbjvBLf6K6tBRcVavC8nWK~kkt3HCIW-ZRXrXN1dBuf183cGndq7Q95VzJk1OOR8750TeHLltXvKaZyR2xQph5L50r5H3CGNF1XfsYJLNbNt7vStTMyqprTjzRHQ08oI~X1bpCwkm7xmA~3f6cjDuFTcS73a5-g6r-FlVw9Y2E-nqDutraY9gj16Rc3IIe8sqfWhh0Nh14DufyFyiouwXDy9aochaurbtvitnUFKTkQLkyzc9SedtpQtj0325LEUbxc~rmR59qXCRu7wx~B95qnsVr8DgXUTwsqdl-us8cfN0XZk3QXaF2FDrtLFYSMYjURzpmVbsFSg__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="home">Home</div>
      </div>
      </a>
      <a target="_self" href="<?php echo "https://thechefmelo.com/my_profile.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="profile">
        <img id="pvdu"
          class="icon-profile-out"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63acdbf633a79ad2d31d773c/0e0ca51d-a179-4a2f-ba86-503f47426234_1672272892567312107?Expires=-62135596800&Signature=JuDxncM-6G3uiJ-ayV82qCyEM2f3S3BscRdp7yKQdNAKtwWCRo91B4~vvUeEOtWfJ6o8NBfVUhvUZlXfYB3bdNn1yP0RF1jMP0jWo68D0hi9bHux1mtreLbXcRtNlp~SG-ncDK-cHh3eD-LZA03bYReztxfCmINAHSn9UTaEXSDKwrm~xNFCL1XSMmWi1DprbvSs5sYhE1fEWk68uo4Z5s7PLh4lab-twYLIkoaI8YaLbc2Jr5EJsCDlECMJwu5086lB3XB2E1QRdh-triryZqMqrS2-diJPku0L-PAnxoLND~HHkVmQhxQOYkkZ7GTlcbULKCeejmex3gtfPqGacg__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="home">Profile</div>
      </div>
      </a>
      <a target="_self" href="<?php echo "https://thechefmelo.com/my_comunnity.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="profile2">
        <img 
          class="icon-profile-out1"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63acdbf633a79ad2d31d773c/86df0be0-93da-4c1f-9eae-2c27710c41a6_1672272892567402628?Expires=-62135596800&Signature=d4iQI~mjC96~VPkMRpzF8aqdo6vMEn8OR2pRhAie9e~s1hXQo3ZcBlAFp4pWdMudxEcInqzXgeT8IH5vuCrkJ9g02XMOizv6jw~36Jk5ItcDaRz8E7Slet~JavcvBTYl6gva9EjLma4-dBVDH3q8aGfniBoWvmPV7Zc3~~XQCZYVQpZvXEJhyf5NCdTPy4NVi-YrLti7c~7Z5n4G3fjjwv-uQ6io-xf6ABu6ZPcQ~LhN9jNzx9Y~qvdfPjffT07znVL6O4PHkmwtG4dXGyApXauD2ijJCC35YDUc5b54JGsORGtHjk2DboYZNbDN7NEqEFZArVjPrKsJDOgiOX2c-A__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="community">Community</div>
      </div>
      </a>
      <div class="rectangle-parent">
        <img class="group-child" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63acdbf633a79ad2d31d773c/aa0b1283-db87-41b5-ad85-31f25e5b7ad2_1672272892567487401?Expires=-62135596800&Signature=piXKERRz1r0fcx1gPNL79Od2F1KO~BC~wMKkLVF0moadgDZYdCR9qv~PVcpGbxSz0Bvx7pzE4zeBYBS26E3LO2JAEuBOBSvD5WrrZiYrSRrzyl6We1RR4PtCFjJPPE4WaRnPXSnefFIi9wyEzHloWfwbNLfJLE1XHWso9KeJdlpGmZOgVTh-wy5cNCyR~o5s1KWZOV9B2XlCNa9eiMY6Q6tLeJdibEfNAyoSX9sfA8Xdirif40a0z2tKDFH8INuds0OkXSRBcTZb9ps34P5p-avkOKX5CDkiHhUYTvQejYgV8BiXmGmmdxFmH4WR-~WrmSWYN2Js2AC6RUh74IyqTA__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="my-collectibles">My Collectibles</div>
        <br>
      </div>
    </div>
  </body>
</html>
