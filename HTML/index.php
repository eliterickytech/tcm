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
if(!isset($_GET['v'])){
    echo "<meta http-equiv='Refresh' content='0; URL= https://thechefmelo.com/index.php?".$time."'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="The Chef Melo Patisserie Canada">
    <meta name="keywords" content="Chef Melo, Chef Melo Canada">
    <meta name="author" content="The Chef Melo">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loading</title>
    <link rel="stylesheet" href="/css/style.css?<?php echo $time;?>">
</head>
    <body class="access">
        <section id="load">
            <div class="logo">
                <img src="img/Logo.png" alt="Patisserie">
            </div>
            <?php 
                echo "<meta http-equiv='Refresh' content='1; URL= https://thechefmelo.com/login-view.php?".$time."'/>";
            ?>            
        </section>
        <footer id="load_footer">
            <div class="collectibles">
                <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                <h2>My Collectibles</h2>
            </div>
        </footer>
    </body>
</html>
