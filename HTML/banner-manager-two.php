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
//####################################
if(isset($_GET['token'])) {$access_token_seting = $_GET['token'];}
$access_token = base64_decode($access_token_seting);
$access_token = json_decode($access_token, true);
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
      $get_data_sql = "SELECT * FROM banner WHERE banner_id = '2' and banner_type = '1' LIMIT 0,1";
      $sSQL_Debug = base64_encode($get_data_sql);
      $data['controlOne'] = $sSQL_Debug;
      //###############
      if (!$banner = get_all($get_data_sql, $connection)) {
          echo "Error conected database -> banner 0";
          exit();
      }
      ////###############
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

    <link rel="stylesheet" href="css/home.css?<?php echo $time;?>" />
    <link rel="stylesheet" href="css/home2.css?<?php echo $time;?>" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&display=swap"
    />
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/banner.js?v=" + versionUpdate;  
            document.body.appendChild(script);
            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </head>
  <body onload="onLoad()" class="access">
    <div class="manage-banners-home-355x200">
      <div class="manage-banners">Manage banners</div>
      <div class="current">Current</div>      
      <button id="upload-button">
            <img class="advertising-icon" id="imageid" alt="banner-blank" src="https://thechefmelo.com/img/banner-big-blank.png" />
      </button>
      <form method="POST" class="form-group">
      <div class="new-upload">New upload</div>
      
      <div class="home-375x70">
        <select name="banners" id="banners" style="background-color: #FFF; border: none;" onchange="changePage()" onblur="changePage()">
          <option value="0">Home 375x70</option>
          <option value="1" selected>Home 375x200</option>
        </select>
      </div>
      <div class="redirect-to">Redirect to:</div>
      <?php if(isset($banner)):?>
        <?php echo(isset(array_values($banner)[3]) ? '<a href="'.array_values($banner)[3].'" target="_blank">' : '');?>
          <div class="linkexample"><?php echo(isset(array_values($banner)[3]) ? array_values($banner)[3] : '');?></div>
        <?php echo(isset(array_values($banner)[3]) ? '</a>' : '');?>
      <?php endif;?>
      <div class="manage-banners-home-355x200-item"></div>
      <img class="add-icon" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63b43712a1cfc4b0d1007838/2137d001-5b96-492d-8c37-d2fc8c9f574d_1672754970370629815?Expires=-62135596800&Signature=vUe5Cy4OjWNa09mC5rPAZ8mwzMxW2syfV~RUOoXO1uOtHwVYeIgUxjLNk3HYnvHRdH4PkaYVx4OgTLFO3RC1mjxxmpTOQ79lFgrk0a--pdyP07XZWFJcvAwsp4~co1YC7HD0XZk5JUGc1Ftwdl4kdDcCojDiuIzMzz8j1yZqBwDk8ZuROX0yVKvUa16wJUZyrzb5Nc45Oww1lq~7zIPKKju65D57spCnjrVzn2Oaj-jytHgRvdWh4UjJQZ-NTLOLHcZBC0mnGrrNsgpxG7emTG4Zqv5nbIFzxPdFkim-KHu4~oP9sZIWwZldibJtLR4Hd6jpX-WHT7PmuHPL1CnVGA__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="confirm-password">Confirm password*</div>
      <div class="enter-password">
        <input type="password" name="password" class="enter-password-child" placeholder="* * * * * * * *">
      </div>
      <div class="sign-in-cta">
        <div class="cta">
          <div class="cta1"></div>
          <button id="btn-save-changes" type="submit">
            <b class="save-changes" style="color:#FFF;">SAVE CHANGES</b>            
          </button>
          <div id="password-group" style="margin-top: 30px;"></div>
          <div id="img_new_banner-group" style="margin-top: 5px;"></div>
          <div id="session-group" style="margin-top: 5px;"></div>
          <div style="color:#C0694E;" class="help-block"></div>
        </div>
      </div>
      <?php if(isset($banner)):?>
          <?php echo(isset(array_values($banner)[3]) ? '<a href="'.array_values($banner)[3].'" target="_blank">' : '');?>
              <img class="video-icon" src="<?php echo(isset(array_values($banner)[4]) ? array_values($banner)[4] : 'https://thechefmelo.com/img/banner-big-blank.png');?>" alt="<?php echo(isset(array_values($banner)[1]) ? array_values($banner)[1] : '');?>" />
          <?php echo(isset(array_values($banner)[3]) ? '</a>' : '');?>
      <?php endif;?>
      <img
        class="manage-banners-home-355x200-inner"
        alt=""
        src="https://d1xzdqg8s8ggsr.cloudfront.net/63b439c1a1cfc4b0d1007866/cc6ff82d-2cdc-4abf-97a4-cc05a40e843b_1672755659391542909?Expires=-62135596800&Signature=ITtwfQL4~f~SGiEtwc--ZMSQd-5hT-nVbFll~iEkQchAOwuxCi4Pp1RC~EUWsZzm27BFjn~PP1tehjvIynh9JTff7oy20qcHdU~rjV~hsz893OooBHkc19B4uVDo2z3W7aLCqJihj71qShh-HFKd8e9Kp9Sw4gekuwYEo4WnTgDfKvYWnDwLh4hWWGt-0Prq-f3as0FVibqL8LFv7KkZIDRXgmu~~HXKRJHHjSBs-F98buHtqLM497Hl~gxnpP-YdEk6Lp92n-5tdLc4Q4sYPmPC8ZRcA~NBDwdSgpF27BPAmRoMt4Qcn4UYKHWjDD1PZBK8ZS23biOtnU8gStrcGw__&Key-Pair-Id=K1P54FZWCHCL6J"
      />
      <div class="admin-view">admin view</div>
      <div class="fixed-itens-bg-superior"></div>
      <div
      form id="search" class="search-bar">
        <div class="barra-de-pesquisa"></div>
        <input type="text" id="search-bar" class="search-bar" placeholder="Search">
        <a href="#"></a> 
    </div>
      <img class="icon-side-menu" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63b43712a1cfc4b0d1007838/408d575a-2dfa-4298-8e22-b49d2fe03518_1672754970370908213?Expires=-62135596800&Signature=Si8WIXFITkXrTihlfDSM7ZrAPGiawPn1LXePOoItmOR51cmK4oUq3b2GO9IZuaIWgmPQtric27AtH4AOCNgfsE7goPgn6G0D6ut24vAIx-Dg9CT1ateba5Nki8q8KVH3XcEstqFpcXq3o0zh3QMOcOkAsYOnCf6MW5P0oB5p4isS8wcUJjtr5W6unsIWELoEcPuDFL6TDjPgTyEd3EwDs-OK0PT1oLu6WkkWqTFc8Di0Bga~FFwYTZcy3TVmczzJXGnDTE53w2JqJpAAkAer2aAZWOkfVxz4suTOBDR18c8h8f1T8MCJiysrM3s4IR~X1ctiuVTmtRK5LT92oD46LA__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="menu-inferior"></div>
      
      <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="icon-home-in-parent">
        <img id="home" class="icon-home-in" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63a9e0e6504c63b433038bcd/9723cced-6a90-4d75-b08d-e375dd6e4bdc_1672077548803611796?Expires=-62135596800&Signature=DNWA9l7dKuCbjvBLf6K6tBRcVavC8nWK~kkt3HCIW-ZRXrXN1dBuf183cGndq7Q95VzJk1OOR8750TeHLltXvKaZyR2xQph5L50r5H3CGNF1XfsYJLNbNt7vStTMyqprTjzRHQ08oI~X1bpCwkm7xmA~3f6cjDuFTcS73a5-g6r-FlVw9Y2E-nqDutraY9gj16Rc3IIe8sqfWhh0Nh14DufyFyiouwXDy9aochaurbtvitnUFKTkQLkyzc9SedtpQtj0325LEUbxc~rmR59qXCRu7wx~B95qnsVr8DgXUTwsqdl-us8cfN0XZk3QXaF2FDrtLFYSMYjURzpmVbsFSg__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="home">Home</div>
      </div>
      </a>
      <a target="_self" href="<?php echo "https://thechefmelo.com/profile.php?token=".$access_token_seting . "&v=".$time;?>">
      <div class="profile">
        <img id="pvdu"
          class="icon-profile-out"
          alt=""
          src="https://d1xzdqg8s8ggsr.cloudfront.net/63acdbf633a79ad2d31d773c/0e0ca51d-a179-4a2f-ba86-503f47426234_1672272892567312107?Expires=-62135596800&Signature=JuDxncM-6G3uiJ-ayV82qCyEM2f3S3BscRdp7yKQdNAKtwWCRo91B4~vvUeEOtWfJ6o8NBfVUhvUZlXfYB3bdNn1yP0RF1jMP0jWo68D0hi9bHux1mtreLbXcRtNlp~SG-ncDK-cHh3eD-LZA03bYReztxfCmINAHSn9UTaEXSDKwrm~xNFCL1XSMmWi1DprbvSs5sYhE1fEWk68uo4Z5s7PLh4lab-twYLIkoaI8YaLbc2Jr5EJsCDlECMJwu5086lB3XB2E1QRdh-triryZqMqrS2-diJPku0L-PAnxoLND~HHkVmQhxQOYkkZ7GTlcbULKCeejmex3gtfPqGacg__&Key-Pair-Id=K1P54FZWCHCL6J"
        />
        <div class="home">Profile</div>
      </div>
      </a>
      <a target="_self" href="<?php echo "https://thechefmelo.com/comunnity.php?token=".$access_token_seting . "&v=".$time;?>">
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
        <img class="group-child" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63b43712a1cfc4b0d1007838/5f8f5495-67f8-4be8-9f00-11ca3024db64_1672754970371259227?Expires=-62135596800&Signature=AO5F79Iys7qmGg4E8erOKsgJpxJizQtXRHBso6eiL6p6vATXAUjOYjxTpsVcpzJx8Yv2Yn3Vv3oowW-loEQtVUmDDsUIVA7FwzXoKiJRcZ9QT9usuMghBlcIMvNuRhM8NtQ4RCGMNUb0OQRfmnAAuROi1UsI2bytkTZiVTwUXw6s57ZbKOxBn~PmfefyuMMDxsSzSR8GfYx9yMaKcDCzj1bruTtDLmw~8kAu-vjJM304emLPxHLpCQuo~OFnIOdZUZcJfc~ckuMEUR3AIyIn8M19NdBJU24r1s2U9kwqGlkyY37up8qOhCG2SF8IRcviC-eyS30UNmn5W69rYqeqSA__&Key-Pair-Id=K1P54FZWCHCL6J" />
        <div class="my-collectibles">My Collectibles</div>
      </div>
      <div class="redirect-to1">Redirect to:</div>
      <div class="rectangle-div">
        <input type="text" style="outline: none; padding-top: 0.8px; padding-left: 1px; border:none; width: 70%;" name="link_new_banner" id="manage-banners-community-375-inner" class="manage-banners-community-375-inner" placeholder="tap to insert link">
      </div>
    </div>
    <div class="wrapper" style="display:none;">
        <input id="fileupload" type="file" name="fileupload"/> 
        <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="session" value="<?php echo session_id();?>">
        <input type="hidden" id="img_new_banner" name="img_new_banner">
    </div>
    </form>
    <div id="loader"></div>
    <script>
    function changePage(){
      let page = document.getElementById("banners").value;
      if(page < 1){
        window.location = "<?php echo "https://thechefmelo.com/banner-manager.php?token=".$access_token_seting . "&v=".$time;?>";
      } else {
        window.location = "<?php echo "https://thechefmelo.com/banner-manager-two.php?token=".$access_token_seting . "&v=".$time;?>";
      }
    }
    </script>
  </body>
</html>
