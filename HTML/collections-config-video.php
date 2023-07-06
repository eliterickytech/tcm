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
//####################################################
$errors = [];
$data = [];
$data_send = [];
$banner = [];
$singlePart = [];
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
$collection_hash = "";
$collection_date_available = "";
$collection_time_available = "";
$total_collections = 0;
$get_all_parts_collection = "";
$part_i = 1;
$data_file = "";
$myFile = "";
$fh = "";
//####################################
$time = base64_encode(date('His'));
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
if(isset($_GET['collection_hash'])) {$collection_hash = $_GET['collection_hash'];}
//####################################
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
    //#####################################
    //PÁGINA DE ACESSO EXCLUSIVO DO ADM
    //#####################################
    if(!$user_group == "1"){
        echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
    } else {
        ////###############
        $get_data_sql = "SELECT * FROM collections WHERE collection_active = '1'";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlOne'] = $sSQL_Debug;
        //############### get_total_rows($sSQL = NULL, $connection)
        if (!$total_collections = get_total_rows($get_data_sql, $connection)) {
          $total_collections = 0;
        }
        $get_data_sql = "SELECT * FROM collections WHERE collection_hash = '$collection_hash' LIMIT 0,1";
        $sSQL_Debug = base64_encode($get_data_sql);
        $data['controlTwo'] = $sSQL_Debug;
        //###############
        if (!$singlePart = get_by_data($get_data_sql, $connection, "collection_image")) {
            echo "Error conected database -> banner 0";
            exit();
        }
        //###############
    }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/loading.php'/>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="css/collection-config.css?<?php echo $time;?>" />
    <link rel="stylesheet" href="css/collection-config2.css?<?php echo $time;?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"/>
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/collection-control.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <style>
      .grid-container {
        max-width: 425px;
        margin: 0 auto;
        padding: 15px;
        overflow-x: auto;
      }
      .row {
        display: flex;
        flex-direction: row;
        align-items: center;
      }
      .labelImage {
        letter-spacing: 0.02em;
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 3px;
      }
      .column-1 {
        min-width:60px; 
        width: 20%;
        max-width: 24%;
        min-height:65px;
        margin-left: -5px;
      }
      .column-2 {
        width: 80%;
        max-width: 90%;
        margin: 10px;
        padding-top: 15px;
      }
      .row img {
        width: 100%;
      }
      .alignButton {
        text-align: right;
      }
      textarea {
        min-width:280px; 
        max-width:100%; 
        min-height:60px; 
        height:100%; 
        width:100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #b0b0b0;
        box-sizing: border-box;
        margin-left: 0px;
      }
      .desc_video {
        position: absolute;
        height: 7.10%;
        width: 75.73%;
        top: 43.54%;
        right: 3.73%;
        bottom: 52.91%;
        left: 20.53%;
        border-radius: var(--br-md);
        border: 1px solid var(--color-gray-100);
        box-sizing: border-box;
      }
    </style>
  </head>
  <body onload="onLoad()" class="access">
    <div class="add-collection-2-operador-">
      <div class="add-collection-2-operador-child"></div>
      <div class="add-collection-2-operador-item"></div>
      <div class="chef-melo">Chef_melo</div>
      <div class="collections-available"><?php echo(isset($total_collections) ? $total_collections : '0');?> collections available.</div>
      <div class="shortened-name-for-home-screen">
        Shortened name for home screen display
      </div>
      <img
        class="add-collection-2-operador-inner"
        alt=""
        src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/8bdab07a-6015-4e41-9020-ac01b19e27cf_1672073331193942040?Expires=-62135596800&Signature=WBBBntce6YHhsZdcHqzzIN-vjAusAxb6Et~-DJO0eAVRSjrXiBM6KUZIwu6h7tB-imwDzcoxzh4tL09U3KA66kOH4aBV6PW9LoHi7x1tTBn0GUT9SUpVVds~12ppJdQSz~pjRLeopu~N9mkiBHVlleNOcaACPehf0t1tt03JH6RXgLEnmdjW1GXSpyj~CPYNAFmqX4bCroYKd9nvz~QNhinoj-f0OPNwBaFBuyzI~9GKPTsssNZsnXXyB3aAx~8dPGEsE6U5~HuCI7uUrsy4RriwtaB74bJRpRQ7YZSGNIX5mXsrQQrurHkCnMUVgw6r5Lj~55m~H4BRh9thVNozzA__&Key-Pair-Id=K1P54FZWCHCL6J"
      />
      <div class="rectangle-div"></div>
      <a href="<?php echo "https://thechefmelo.com/collections-insert.php?token=".$access_token_seting . "&v=".$time;?>">
        <div class="add-collection-parent">
          <div class="add-collection">add collection</div>
          <div class="div">+</div>
          <img class="group-child" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/06a3a7f1-7e19-4a4a-9ca5-9532690cd20a_1672073331194136582?Expires=-62135596800&Signature=UmjNCHJ~D-wUC62Y52BU4SnZ3RcXE0UuNciPR26Bfwlqlha6rrdggsb5-daYwVbcYJt0yo4bty385Y0BXIhHNj~8MK3T4fMJTs~6wu6fU1u4A0dtcMBqFa2K1yvniVCyYlAZr6xWRbg0e2ht0xeZFSUajzqJiUb7AqheHRfDNe-lyXx-ZdYze80upJLeanJBn4Yg-b6LAbYe7IEDZZ4pVANLtw7Y76IGKSrZo6C5tWx3lmKOXQqQ20UKTvYzGLhAPH5oU13ExluFIIGp7ZNxASJpHOvhG6LIpQuRNqSdkOEgoIqx-fXU7vCVYbtEWzWr9nXLb~GDuzHVklnlm8QOEQ__&Key-Pair-Id=K1P54FZWCHCL6J" />
        </div>
      </a>
      <div class="delete-collection-parent">
        <div class="delete-collection">delete collection</div>
        <div class="div1">-</div>
        <img class="group-item" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/8d53b180-91b2-4807-8b3d-cbe071357d75_1672073331194236147?Expires=-62135596800&Signature=W9tkcKQH-N-QSzJFjgZ2E0Z2H~cGSHKDek8mpPHvRMwb3CcSZti26WsF~vF~YxJ1RCGg~HlVTZ5U2VJCAtIa-OHhQXUF4kgzO0xBtVSQd9cqT1VsihKeKIpUaQB5OtfGSRe8zYvEGGynLf3UyODJmX~QzEyI~Ph-yTKjkcWxdPcoxIOI5O2bNRxho5fp5CPr7X3BuX39aw~TkyAXuT2DCDwDinmKUAyVlN5LJmRtnj4m8LRpXk8oQNnr7BHHiVvhHkSk6g~EEpuShlNnGJMabciaS9QYeu0K~KKv~014KcG-eRmsTHvYw52Dh1eFhKC-QMIIF0iRIz7o2QArZYX4zg__&Key-Pair-Id=K1P54FZWCHCL6J" />
      </div>
      <div class="add-collection1">Add video collection</div>
      <section>
        <!-- START MINIATURE -->
          <button id="upload_miniature_button" style="border:none; background-color: #FFF;">
            <img style="display:block;" id="collection_miniature" name="collection_miniature" class="add-collection-2-operador-child2" src="./img/file-minier.png">
            <div style="display:none;" id="box" class="add-collection-2-operador-child2"></div>
            <img style="display:none;" id="poster" name="poster" class="add-collection-2-operador-child2" src="<?php echo(isset($singlePart) ? $singlePart : './img/file-minier.png');?>">
          </button>
        <form action="#" method="POST">
          <input class="desc_video" type="text" name="collection_video_description" id="collection_video_description" placeholder="Description video collection" autocomplete="off">
          <input type="hidden" id="type_minier" name="type_minier" value="3">
          <div id="collection_miniature-group" style="margin-top: 30px;"></div>
          <input id="fileupload_miniature" type="file" name="fileupload_miniature"/> 
          <input type="hidden" id="img_new_miniature" name="img_new_miniature">        
          <!-- FINAL MINIATURE -->      
      </section>
      <section style="margin-top: 380px; max-height: 300px; overflow-x: auto;">
        <div class="grid-container">                   
        <div class="row">
            <div class="alignButton">
              <input type="submit" name="save-collection" id="save-collection" class="btn-save" value="SAVE CONFIGURATIONS">
            </div>
          </div>
          <div class="row">
            <div class="alignButton">
              <div id="collection_name-group" style="margin-top: 30px;"></div>
              <div id="img_new_banner-group" style="margin-top: 5px;"></div>
              <div id="session-group" style="margin-top: 5px;"></div>
              <div style="color:#C0694E;" class="help-block"></div>
            </div>
          </div>
        </div>
      </section>
      <div class="add-collection-2-operador-child7"></div>
      <img class="add-icon3" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/19f179ce-3651-4487-b25f-2c760b2af736_1672073331194325653?Expires=-62135596800&Signature=B1vzWpsECpDOF4opqTxB0BucZDItSY8Vu3ElYB6oZ1yp8nVC5-qW0TOQ9cDGu8PkgtzPNYhI5V5GsCP5~dp-J-n8QIGiUQXW2ZLFvhwq1i3ozTYaBnjk9tqPjAivWXhEYThPthkfAjNce7-lXcWJQbWYMhsiQJwVeK3b3aYwhRW0n48yTQ2SsABHe-frzo-6w061FRwjQIak2kLKiyNo7-CbIefBN4e-~TwKL6R9~jeTMKp3bMAAvhawtyKpt~PXAt-5rFJcTIuOKy7i7t0G0XeMODmJm9jjsbfBqjGjbfhte-NNygxBxGaO1PxE47jaPyVJyukkBg76cnxJw0h2fw__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="add-collection-2-operador-child8"></div>
      <div class="miniature">Video:</div>
      <div class="send-delights-parent">
        <div class="delete-collection">send delights</div>
        <div class="div2">&gt;</div>
        <img class="group-inner" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/0f1a0110-b55d-44b7-ad4a-a1a23b02ac1d_1672073331194508691?Expires=-62135596800&Signature=d6Xzb6ZQCHHPldHwGFOh3fr4uS14LLJq5FCl1x78bbHGljQzA4WMNvUtxU7JhICHeWSegx3JNtEGnqw8WbfugrfQOYjS6y-dMXq0wxHdX0GHS7yjvDlP8ru8HyRx2qvPxV0RLq5SXMwEL7YOwNpONClHybBPPTnASgUMIoJt31wkoeOVjOYRnV231W6DVTJrPkb8kEm-4kvfuvf17iK5ORCwga8a656SKz~h4iZvqtHAmGVGOSil~WmCoZRZEONyAr089xVvbbPcbZQUpaXAnRSM9GpyWMxo~Hal96g73BpClLc4Too962iPGGjadC4uXK2yn-lh1ggWfutMeRHHBA__&Key-Pair-Id=K1P54FZWCHCL6J" />
      </div>
        
        <div class="wrapper" style="display:none;">
            <input id="fileupload" type="file" name="fileupload"/> 
            <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
            <input type="hidden" id="img_new_banner" name="img_new_banner">
            <input type="hidden" name="type" value="4">
            <input type="hidden" name="video" id="video" value="1">
            <input type="hidden" name="single" id="single" value="1">
            <input type="hidden" name="session" value="<?php echo session_id();?>">
            <input type="hidden" id="collection_hash" name="collection_hash" value="<?php echo $collection_hash;?>">
        </div>
      </form>
      <div class="fixed-itens-bg-superior"></div>
      <div form id="search" class="search-bar">
        <div class="barra-de-pesquisa"></div>
        <input type="text" id="search-bar" class="search-bar" placeholder="Search">
        <a href="#"></a>
    </div>
      <img class="icon-side-menu" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/b83a1878-9944-41a0-ab91-b1170cc22aa1_1672073331194690222?Expires=-62135596800&Signature=c3i7RaftglxAQqDBSWvelHjs~yis8uee~mDNz-6eXOmUrVXo8lldxvXu4DlZKF5G1NMm0KHQctIqZtv8yddzulduBPUFFFASj~cVROUpKstNNr9bqqZO3ug-~Ts39pJ~hMff8cI14EeT72-~4TDE7K8GbWWXi1~txvBmx~smzmwMRrdFJGQ~C28ylVGJhm5HvbuzAItAB84SvY-R3C97p9lAvljgHEN9x9kXzkMZsfbmNp829RXKTCyjFPHr2B~dWMqe3b4K7rbatMU-fvp64xbUZR7bReESMyidfABUC1BPMUFIt3gmgQYTUSGLCWfXptFA~V5ql7tZ7kGuw8dJ6A__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="menu-inferior"></div>
      <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">
        <div class="icon-home-in-parent">
            <img id="home" class="icon-home-in" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/191cabf8-a55b-42ec-9936-0e81b5369436_1672073331194772345?Expires=-62135596800&Signature=U7D~7bHU9ir3-aDVc39su~HVeFYCDygX2Li1rxFjJ28fQpD3C~vsMX87wpkheQlpa4T4gNzRbooA5tQcuFDjHhFoMBo~qnHr2Rc9f4pjxO-9GRg2wZuFPnwgK3~cnBHqkMI25UTyGmivWCupu3BElU5dbk12~1qjrVIschIKkXIvAwfdgAn7MLkg2~pLEEq4VKzI~SMuFtF~PKRbza4eYcLXVEAqE5NtzoP1VvFcMO-qZKrhNbSyQH1zs2UDb5yAPKsrHe7dKE~2KpuOIvYIWbGjsAUmYSXXQ4XGDTvxTxwvLjXzKiLItkuHE~VvnZaWHZl3md5wlJ9ATSiPOGW4sw__&Key-Pair-Id=K1P54FZWCHCL6J" />
            <div class="home">Home</div>
        </div>
      </a>
      <div class="rectangle-parent">
        <img class="rectangle-icon" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/b3d31109-d24e-41d2-9bfc-14a2fb6924af_1672073331194865334?Expires=-62135596800&Signature=TyW8340pDZ07IPq8-1AXfrthIybb6gc-yELYM7QBb2e6zYKB66vCzdG~nIhhWpzmMlxe76Byry1MlXrNP~~TmAgtmGdI9oLNC8piy8Wq2dhpCfM00-wMjVWMWF4jhcXX4MOsj-MF0iyyZxxxfhGC~ZL77CMbEtrMmqCGjCkGgPxTkntX2jHCJUBSi-05QlIUptLddYomXskSzNz2svzxnYqBDQao~eQcZppcCMhc1gxF8CdFHMxSm8wuOnZRd-NW3FoeQBFqtZ-~p14yyBom4y7FBlrdQVlbLUOAM8i3wnINguz1DhOyxsesj~ST0QOoI4LlbUI5~wu6QU250talOA__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="my-collectibles">My Collectibles</div>
      </div>
      <div class="profile">
        <img id="pvdu"
          class="icon-profile-out"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/acaa5f06-4295-4ef3-8f39-ecc3728e3c0f_1672073331194956573?Expires=-62135596800&Signature=hBeqYtAxEVg0I9fpLoAnST3Su3FQHThwqcTK-cNtR9cZav7bpjG~IripHZfefOtjQw7qdiwok0XHAfW0LpCfsWuW~mjYkOxryB2oBY44Flfykq3RS-IAL8PdbGtOdit2M1pa6hLzfarAUb-81CjLOIxThWinWEf4O~jKslZq-f1Ryx-Br6706GUymQirF6qWUclRMk60NUrg~a-HSUTVRYr76l~li84fCggpx9BrazxYmJthU8FFbp1KctQkYi43Gn0x-LOq7g86tZHf7B8Hlx9YKMzsFjhmD1GyiRxyry8c03A6H4zuSFiIEAZoVW7TfIrem1k9fqUoFOkQMfSxew__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="profile1">Profile</div>
      </div>
      <div class="profile2">
        <img id="usuarioc"
          class="icon-profile-out1"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9d063504c63b433038a16/d24574d0-727c-4be6-81b0-b8630c108eeb_1672073331195045854?Expires=-62135596800&Signature=wP9wiWikRAwf8M5mbjklLMkDnhFnjvK0nrQ3ACLqIAJLW5uM63WGPsRJhD1nQmD2Vu6G~uRpeU9w0rV4tW1lt7o7SOdmst7kunvVp3s5z-Zgtt~L3FAAwJGefJFk1yp1zf4bXFIMsvOrP1iGCeKzAMjio1uV3-R9jBYb16-FqVAs8CLuGhJN3-QuDSrZmPeVm9MDM8TzmZZipexnaLLf8Ouc6IehMFP7M-dFs0mcT0Al0c6NhUKqTKAFfyHN8keBNPqn6E0N-m3pkAYd4kRpGzcViJlL2cNaQHNfz7fHm-uiBWDtXDMmSLhfyvvtZyaQg2OH3fRMEDuhXZCb2WOv~w__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="home">Community</div>
      </div>
      <div class="admin-view">admin view</div>
    </div>
    <div id="loader"></div>
  </body>
  <script>
    $(document).ready(function() { 
      
      let interval = setInterval(
          function clear() {
            const file = document.getElementById("img_new_banner").value;
            if(file.length > 0){
              var spinner = $('#loader');
              spinner.show();
              document.getElementById("collection_miniature").style.display = "none";
              document.getElementById("box").style.display = "block";
              console.log("Video loaded!");
              spinner.hide();
              clearInterval(interval) 

              const video = document.createElement('video');
              video.src = document.getElementById("img_new_banner").value;

              video.controls = true;
              video.muted = false;
              video.height = 68;
              video.width = 65;
              video.poster = "<?php echo(isset($singlePart) ? $singlePart : './img/file-minier.png');?>";

              const box = document.getElementById('box');
              box.appendChild(video);

            } else {
              console.log('Check New Video');
            }    
            return clear;
          }()
      , 100);
    });
    
  </script>
</html>
<?php 
//document.getElementById('collection_miniature').style.display = none;
//document.getElementById('file_video').style.display = block;
?>