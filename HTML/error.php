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
//####################################
ini_set('max_execution_time', 0);

ini_set('output_buffering', 'off'); 

ini_set('zlib.output_compression', false);

ob_end_flush(); while (@ob_end_flush());        

ini_set('zlib.output_compression', false);

ini_set('implicit_flush', true);

ob_implicit_flush(true);
//####################################################

header("Access-Control-Allow-Origin: *");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");

header("Access-Control-Allow-Headers: *");

header('Cache-Control: no-cache');
//####################################
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Error</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <section id="load">
            <div class="logo">
                <h3><b>Error.</b></h3>
            </div>
            <?php 
                echo "<meta http-equiv='Refresh' content='3; URL= https://thechefmelo.com/'/>";
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