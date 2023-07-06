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
    if(!$user_group == "1"){
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
        //exit('debug collections');
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
    <link rel="stylesheet" href="css/12.css?v=<?php echo $time;?>" />
    <link rel="stylesheet" href="css/12_b.css?v=<?php echo $time;?>" />
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
    <div class="permissions-1">
      <img class="logo-icon" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63adaa2b2434a4e554746687/b2c6d3b9-f4e3-43d2-9f38-08dcc3431953_1672367280526570597?Expires=-62135596800&Signature=I-3R2lXjr4CHoVX8aIdA4arC7sE8rL1KdqolbJ59G4GMMEogzQixbTWWCaYwN1-~RjC-DymIpg6DeT7lJ-9TzWvVnFqEGPWpv0TrK3Sj-RmAtnOHzDboDB1-EVd8pwCfZUaTjZVMk5PgRq8faLOsBtlJrWQzW0fzU-y1JaG6iZH5SpW~mkzwU~pXkoyM0GiUTzW~4UpZaRLsKfVrwUkzfHtFIjEM-cR2JlYLg-yxis1vaL3G5y9daB4PtfKpdRch~DD5sKnNOTnpDHfp6JUgy7a04nyqMSioKaCmpay~vtWLiunTH2nKBmz0UOyPIte3EwcfQehoEPQctd~EQaYepQ__&Key-Pair-Id=K1P54FZWCHCL6J" />
      <div class="add-a-new-admin">Add new user</div>
      <form action="#" method="POST">
        <button class="add-a-new-admin1" type="submit">Save</button>
        <div class="tap-the-delete-button-to-chang">
          Tap the delete button to change the app permissions or add a new admin
          and confirm your password to apply the changes.
        </div>
        <div class="confirm-your-password">Confirm your password*</div>
        
        <div class="enter-password">
          <div>
            <input type="password" class="enter-password-child" id="confirm-password" name="confirm-password" onkeypress="validateChangePassword()" placeholder="The same password you use to log in the app">
            <div id="confirm-password-group" class="area_form"></div>
            <span class="errorData" role="alert" id="confirm-passwordError" aria-hidden="true"></span>
          </div>
        </div>
        <div class="my-collectibles-parent">
          <div class="my-collectibles">My Collectibles</div>
          <img class="logo-icon1" alt="" src="https://d1xzdqg8s8ggsr.cloudfront.net/63adaa2b2434a4e554746687/deaeb9ff-5217-4ed2-abe8-8b625a28c77b_1672367280526745873?Expires=-62135596800&Signature=W7GCkGsVNmPZNwl~tckTc62Wr2poofHym8liZXAFATMbcXeyutQ0K~oEm3~zyWCL4moHrAfyQEO08qVHuejz-n8oI~82ZwyKEs-8GFrjJIbchgacaii6VHRFaRfnmcAt8~o5zG7OumtuFzvGdRSYxSI8luN8X3-8DbJcVVqY0zDzitngmz3kwGTMJ~c9Syq90anWPh-FYqVN6acTHt69MnzdNMBkaobyJGQDyT2NDfOu3Jls7LIPP0O~KRnFBd6vO0vamxRJK0GkWkS5eZ6FJwJfqPd-Bf1V1Sq~2aD~kZi7rIqwYSSH-aqoeu30X1xATSK9BFliEFm5tMgmeqwKCw__&Key-Pair-Id=K1P54FZWCHCL6J" />
        </div>
        <div class="permissions">Permissions</div>
        <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">
          <img class="close-icon" alt="close page" src="https://d1xzdqg8s8ggsr.cloudfront.net/63adaa2b2434a4e554746687/583c22c2-ea83-416f-9181-ed4cbc770b94_1672367280526936988?Expires=-62135596800&Signature=lm3MfQec~-lXqjSM-nuUufXR2xvtonJiSzLr9z8WGPTwCXL8xR~m8ae4FZRL4sA~NH-sLp9jtfpxgIwOo~p7yw0XesmxdtELUxMs1ncpo3hETcb9AgKeriPeCNdIUXEJ06bDsO74wau-GBtUVOD8CjlmwVY5TwV3G7G2d2-bAPIoC4Y2wnXmsEZsuEnupXbL5s0JTNP1uRkUM2CJrrh9qPItHs8WV2nKBxpxWRoBFgsVcaRCMhjfc2hO3Vz-CdhG6MzwCMMibns-06HStjs-uNTt0Ua6AYPGxPJFsrvKSM-qhFeWZlLSpdp-GdXV81pW86EOodSUWgws6gGsciGSBg__&Key-Pair-Id=K1P54FZWCHCL6J"/>
        </a>
        <a target="_self" href="<?php echo "https://thechefmelo.com/my.php?token=".$access_token_seting . "&v=".$time;?>">
          <img class="permissions-1-child" alt="return page" src="https://d1xzdqg8s8ggsr.cloudfront.net/63adaa2b2434a4e554746687/4e1fec21-2f08-48e5-ad88-ef16458c7754_1672367280527018387?Expires=-62135596800&Signature=SnQjWl5A~TtJnvwleERnORwAPjqR9Md10Z1teLy19ebS6xyXE89XJZumn~-wmizk0VnwSIYUyB23HkSxz3xtDvVyQHaQ4ef6wksijK~fglkfpuXaP~W3vWhEGclC~SVy8UJaAZsk8pBvk94EloKEIa8vH1uE3KrnzcQrCz~KSjxeBx1AFVnJF3wUbqHnN1bS3GFqc3iHG8V-oBe~xHvw~s8sOkejshw6Whge8vH8RPihOh390bqA-J6M2sE-zfl1gfW7kPT20nXoHs-8XNaMQ1lZFTgxD15I5KuYzNBac2Bypn2pSx8qrhCtVFpn1z3ss-56tOXNBDbMCLBxuh8trg__&Key-Pair-Id=K1P54FZWCHCL6J" />
        </a>
        <div class="permissions-1-item"></div>
        <div class="e-mail">E-mail</div>
        <div class="enter-username">
            <?php if(isset($data_user)):?>
                <?php foreach($data_user as $data_admin_user):?>
                  <input type="email" class="enter-password-child" name="user_email" id="user_email">
                  <input type="hidden" name="user_registry_key" id="user_registry_key" value="<?php echo(!empty($data_admin_user['user_registry_key']) ? $data_admin_user['user_registry_key'] : 'empty user registry key');?>">
                  <input type="hidden" name="user_id" id="user_id" value="<?php echo(!empty($data_admin_user['user_id']) ? $data_admin_user['user_id'] : 'empty user id');?>">
                  <input type="hidden" name="type" id="type" value="1">
                  <input type="hidden" name="user_group" id="user_group" value="1">
                  <input type="hidden" name="session" id="session" value="<?php echo session_id();?>">
                  <input type="hidden" name="token" value="<?php echo $access_token_seting;?>">
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="confirm-your-e-mail">Confirm your e-mail</div>
        <div class="enter-username1">
          <div id="password-group" class="area_form">
            <input type="password" class="enter-password-child" name="password" id="password" onkeypress="validateChangePassword()" placeholder="The same e-mail you use to log in the app">
            <span class="errorData" role="alert" id="passwordError" aria-hidden="true"></span>
          </div>
        </div>
      </form>
      <div class="admin-console">admin console</div>
    </div>
    <div id="loader"></div>
  </body>
</html>
