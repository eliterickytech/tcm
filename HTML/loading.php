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
$stoken = "";
$page = "";
$access = false;
$redirect = "";

if(isset($_GET['token'])){
    $stoken = filter_var($_GET['token'], FILTER_SANITIZE_STRING);
}

if(isset($_GET['p'])){
    $page = filter_var($_GET['p'], FILTER_SANITIZE_STRING);
}

if (!empty($stoken) && !empty($page)) {
    $access = true;
    if($page == "login_validate"){
        $redirect = "login_validate.php?token=" . $stoken;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Loading</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <?php if($access):?>
            <section id="load">
                <div class="logo">
                    <img src="img/Logo.png" alt="Patisserie">
                </div>
                <?php 
                    if (!empty($redirect)) {
                        echo "<meta http-equiv='Refresh' content='2; URL= https://thechefmelo.com/".$redirect."'/>";
                    }
                ?>            
            </section>
        <?php else:?>
            <section id="load">
                <div class="logo">
                    <?php if(empty($stoken)):?>
                        <p><b>invalid token.</b></p>
                    <?php endif;?>
                    <?php if(empty($page)):?>
                        <p><b>invalid page.</b></p>
                    <?php endif;?>
                    <?php
                        echo "<meta http-equiv='Refresh' content='2; URL= https://thechefmelo.com/'/>";
                    ?>
                </div>
            </section>
        <?php endif;?>
        <footer id="load_footer">
            <div class="collectibles">
                <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                <h2>My Collectibles</h2>
            </div>
        </footer>
    </body>
</html>