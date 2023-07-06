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
$total_chat = 0;
$get_chat_unread = "";
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
        $get_chat_unread = "SELECT * FROM conversations LEFT JOIN users ON conversations.conversation_from = users.user_id WHERE conversation_sender = '$user_id' and conversation_read = '0' ORDER BY conversation.conversation_id";
        if(!$get_chat_unread = get_all_data($get_chat_unread, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          $chat_unread = array();
          foreach($get_chat_unread as $item) {
            $chat_unread[] = array(
                  'user_name' => $item['user_name'],
                  'conversation_date_time_from' => $item['conversation_date_time_from'],
                  'conversation_message' => $item['conversation_message']
              );
          }
        }
        $get_chat_read = "SELECT * FROM conversations LEFT JOIN users ON conversations.conversation_from = users.user_id WHERE conversation_sender = '$user_id' and conversation_read = '1' ORDER BY conversation.conversation_id";
        if(!$get_chat_read = get_all_data($get_chat_read, $connection)){
          //echo "Error get all parts the collection";
          //exit();
        } else {
          $chat_read = array();
          foreach($get_chat_read as $item) {
            $chat_read[] = array(
                  'user_name' => $item['user_name'],
                  'conversation_date_time_from' => $item['conversation_date_time_from'],
                  'conversation_message' => $item['conversation_message']
              );
          }
        }
        ////###############
        $total_chat = (int)get_total_rows("SELECT * FROM conversations WHERE conversation_read = '0' and conversation_sender = '$user_id' ", $connection);
        //#################
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
    <link rel="stylesheet" href="css/06.css?v=<?php echo $time;?>" />
    <link rel="stylesheet" href="css/06_b.css?v=<?php echo $time;?>" />
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
    <div class="chats-unread">
      <b class="chat-with-us">CHAT WITH US</b>
      <div id="chats" class="all-chats">All chats</div>
      <div class="unread">Unread</div>
      <div class="chats-unread-child"></div>
      <div class="chats-unread-item"></div>
      <div class="user-name1-parent">
        <div class="user-name1"><!--[@user_name]--></div>
        <div class="message-preview-324mpx-or-abo">
          <!--[@message]-->
        </div>
        <div class="div"><!--[@yyyy-mm-dd]--></div>
        <img class="group-child" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e1c4504c63b433038bdc/f0f75299-59d5-42d1-b468-fe7fc35a6910_1672077770921330772?Expires=-62135596800&Signature=CkaKt97Bj7awRhdo1mhWtL6rM7yImZSrvJMGY3ZToRpqk5iHAoN5elH5pPReYa--Br63l0jm1ZqB5d1~eVfocNze3ASHFIt23pfPUpjU1nkfo8uNXhTx-eK75MOEU8EaVLFWM7f3N5S8dUN7o-ptCAwvlpROxrMuf33uXCrlJT0Vgcd5xkonFTKc7Qx4SEuRMrueWBTpgWM0t5~0KRCgzeIKn7MWSntJtdDNvyuB2nf~Eql7PKSYn9QBeE9Wjo66M12y-pa24iJrzGFi-dRUvRemypXX9JKZNul9mXnlYYQ0qaheRmGHzUBoFqP~o0TG517C1vR3uc9rDfi8vymKIw__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="div1"><!--[@int]--></div>
      </div>
      <div class="fixed-itens-bg-superior"></div>
      <div
      form id="search" class="search-bar">
        <div class="barra-de-pesquisa"></div>
        <input type="text" id="search-bar" class="search-bar" placeholder="Search">
        <a href="#"></a>
      </form>
     </div>
      <img class="icon-side-menu" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e1c4504c63b433038bdc/6b359cc0-d860-4a72-82d2-d57277d938a6_1672077770921644599?Expires=-62135596800&Signature=EJoAwRXfCRrt9SeIZVNf06FAygvWMHPBYpuXRq1XbTyCYQi43igwAHfKbDbzegHgOSnZIdd-XpdtDPwLcBcqUQ7q~CeDhUKIlQcNQRCGMyspFDPz0rmUtG-AWTg3vixryUZh4Tq-FxQ14btqqNQWInz2wQYu6jubDxzODVG0uTNf8Qfs61NpLspfIW9lb5ypEY-EmEU-fT7-reae19eGY56KEArEgj-y7XgYCb4sJ5B3UaWU3ArgKfHFoA20BjbX5FGZvqnVsKOgItJ5~iFfPmmZ8VCAdCZVt9Gt91XN-DrfZFNUb9sqVx2Qyysc4198sriEERMOytdUMjo3Oy0rEQ__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="menu-inferior"></div>
      <a target="_self" style="text-decoration: none;" href="<?php echo "https://thechefmelo.com/home.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="icon-home-in-parent">
        <img id="home" class="icon-home-in" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e0e6504c63b433038bcd/9723cced-6a90-4d75-b08d-e375dd6e4bdc_1672077548803611796?Expires=-62135596800&Signature=DNWA9l7dKuCbjvBLf6K6tBRcVavC8nWK~kkt3HCIW-ZRXrXN1dBuf183cGndq7Q95VzJk1OOR8750TeHLltXvKaZyR2xQph5L50r5H3CGNF1XfsYJLNbNt7vStTMyqprTjzRHQ08oI~X1bpCwkm7xmA~3f6cjDuFTcS73a5-g6r-FlVw9Y2E-nqDutraY9gj16Rc3IIe8sqfWhh0Nh14DufyFyiouwXDy9aochaurbtvitnUFKTkQLkyzc9SedtpQtj0325LEUbxc~rmR59qXCRu7wx~B95qnsVr8DgXUTwsqdl-us8cfN0XZk3QXaF2FDrtLFYSMYjURzpmVbsFSg__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="home">Home</div>
      </div>
      </a>
      <a target="_self" style="text-decoration: none;" href="<?php echo "https://thechefmelo.com/my_profile.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="profile">
        <img id="pvdu"
          class="icon-profile-out"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63acdbf633a79ad2d31d773c/0e0ca51d-a179-4a2f-ba86-503f47426234_1672272892567312107?Expires=-62135596800&Signature=JuDxncM-6G3uiJ-ayV82qCyEM2f3S3BscRdp7yKQdNAKtwWCRo91B4~vvUeEOtWfJ6o8NBfVUhvUZlXfYB3bdNn1yP0RF1jMP0jWo68D0hi9bHux1mtreLbXcRtNlp~SG-ncDK-cHh3eD-LZA03bYReztxfCmINAHSn9UTaEXSDKwrm~xNFCL1XSMmWi1DprbvSs5sYhE1fEWk68uo4Z5s7PLh4lab-twYLIkoaI8YaLbc2Jr5EJsCDlECMJwu5086lB3XB2E1QRdh-triryZqMqrS2-diJPku0L-PAnxoLND~HHkVmQhxQOYkkZ7GTlcbULKCeejmex3gtfPqGacg__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="home">Profile</div>
      </div>
      </a>
      <a target="_self" style="text-decoration: none;" href="<?php echo "https://thechefmelo.com/my_comunnity.php?token=".$access_token_seting . "&v=".$time;?>">
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
        <img class="group-inner" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e1c4504c63b433038bdc/f848ecb8-1fa7-4239-afb5-98cd259486ae_1672077770922012524?Expires=-62135596800&Signature=f~91pSpUihdUZUXKcX6zGkMtXKbBZECAtjrcnKPKU~kFMomUeuU18Fu9TXvwiFmyAhcRQKKsnJDMZx~iJteZ~N-nE5kQ62qVYyNt1ZsLbM6E9AzE-Qm3WZO6Y-mgXwKkyXVT35q3PMarJDQeC7ftN-gg3LoQ6HwMbGwnPIUh8g6vZlXM1ZecG2QfWlkKww6Y9o0REYATlJ9iLXTiMMN230GxVZ2UQa26cGkSwipKpyKPrt9jpDMHpePKEeEigRd3YM9AS~eZpmrQgJJ5UnQaAL48mc1Bn9YxokfS5KqAwK9iFB646JZy1xwZEW4mKYI7G2VHLKxY~weupHHgGuqinw__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="my-collectibles">My Collectibles</div>
      </div>
    </div>
  </body>
</html>
