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
if(empty(session_id())){
    session_start();
}	
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
$time = "";
$time = base64_encode(date('His'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="The Chef Melo Patisserie Canada">
    <meta name="keywords" content="Chef Melo, Chef Melo Canada">
    <meta name="author" content="The Chef Melo">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FFF">
    <title>Login</title>
    
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">

    <script type="text/javascript" language="javascript">  
        
        function onLoad() {
            
            var versionUpdate = (new Date()).getTime();  
            
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/login.js?v=" + versionUpdate;  
            document.body.appendChild(script);

            var frm = document.createElement("script");  
            frm.type = "text/javascript";  
            frm.src = "/js/forms.js?v=" + versionUpdate;  
            document.body.appendChild(frm);
        }

    </script>


</head>
    <body onload="onLoad()" class="access">


        <section id="container_login">

            <div class="container_login">
                <div class="container_login_int">

                    <div class="area_login">

                        <div class="logo">
                            <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                        </div>


                        <form method="POST">

                            <div id="email-group" class="area_form">
                                <label for="name" class="username">
                                    Email
                                </label>
                                <input type="text" id="email" name="email" placeholder="enter your e-mail address" autocomplete="off" onkeypress="validateLogin()">
                                <span class="errorData" role="alert" id="emailError" aria-hidden="true"></span>
                            </div>
                          
                            <div id="password-group" class="area_form">
                                <label for="Password" class="password">
                                    Password
                                </label>
                                <input type="password" id="password" name="password" placeholder="enter your password" autocomplete="off" onkeypress="validateLogin()">
                                <span class="errorData" role="alert" id="passwordError" aria-hidden="true"></span>
                            </div>

                            <div class="info">
                                <p>Forgot your password? Tap <b>here.</b></p>
                            </div>

                            <div id="mobile-group" class="area_form m">
                                <label for="Mobile" class="mobile">
                                    Mobile
                                </label>

                                <div class="area_select">

                                        <!--<div class="select">
                                            <img src="img/Selection.png" alt="">
                                            <img src="img/flage_canada.png" alt="">
                                        </div>-->

                                        <select id="frm_brand" required style="width:100%;">		
                                            <option value="flage_canada" selected>Canada</option>
                                        </select>

                                      <input type="text" id="mobile" name="mobile" placeholder="enter your mobile number" autocomplete="off" onkeypress="validateLogin()">
                                      
                                </div>
                                <span class="errorData" role="alert" id="mobileError" aria-hidden="true"></span>
                                
                            </div>

                            <input type="submit" name="submit" class="submit" value="SIGN IN">
                            <input type="hidden" name="session" value="<?php echo session_id();?>">

                            <div class="sign_up">
                                <p>New here? Tap to <a target="_self" href="https://thechefmelo.com/sign-up-user.php?<?php echo $time;?>"><b>sign up.</b></a></p>
                            </div>

                        </form>


                    </div>

                </div>

            </div>


            <footer>
                <div class="collectibles">
                    <img width="20px" height="20px" src="img/logo_collectibles.png" alt="">
                    <h2>My Collectibles</h2>
                </div>
            </footer>

            <div id="loader"></div>

        </section>

    
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
        
        <script>
        
            function formatState (state) {
              if (!state.id) {
                return state.text;
              }
              var baseUrl = "img"; //Na pasta em questão adicione as imagens. Cada imagem deverá ter o nome igual ao value correspodente no option
              var $state = $(
                '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
              );
              return $state;
            };
        
            $("#frm_brand").select2({
                templateResult: formatState
            });
        
        </script>
        
        <style>
        .img-flag
        {
            width:25px
        }
        </style>
        
    </body>
</html>