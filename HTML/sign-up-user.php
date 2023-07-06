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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="/img/Logo.ico">
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">
    <script type="text/javascript" language="javascript">  
        function onLoad() {
            var versionUpdate = (new Date()).getTime();  
            var script = document.createElement("script");  
            script.type = "text/javascript";  
            script.src = "/js/sign-up.js?v=" + versionUpdate;  
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
                            <a target="_self" href="https://thechefmelo.com/">
                                <img width="100px" height="100px" src="img/Logo.png" alt="Patisserie">
                            </a>
                        </div>
                        <form method="POST">
                            <div id="email-group" class="area_form">
                                <label for="email" class="password">
                                    Email
                                </label>
                                <input type="text" id="email" name="email" placeholder="enter a valid e-mail" autocomplete="off" onkeypress="validateSignUp()">
                                <span class="errorData" role="alert" id="emailError" aria-hidden="true"></span>
                            </div>
                            <div id="username-group" class="area_form">
                                <label for="username" class="username">
                                    Username
                                </label>
                                <input type="text" id="username" name="username" placeholder="create a username" autocomplete="off" onkeypress="validateSignUp()">
                                <span class="errorData" role="alert" id="usernameError" aria-hidden="true"></span>
                            </div>
                            <div id="password-group" class="area_form">
                                <label for="password" class="password">
                                    Password
                                </label>
                                <input type="password" id="password" name="password" placeholder="create a 6 characters password" autocomplete="off" onkeypress="validateSignUp()">
                                <span class="errorData" role="alert" id="passwordError" aria-hidden="true"></span>
                            </div>
                            <div id="confirm-password-group" class="area_form">
                                <label for="confirm-password" class="password">
                                    Confirm password
                                </label>
                                <input type="password" id="confirm-password" name="confirm-password" placeholder="repeat your 6 characters password" autocomplete="off" onkeypress="validateSignUp()" onchange="validateSignUp()" onblur="validateSignUp()">
                                <span class="errorData" role="alert" id="confirm-passwordError" aria-hidden="true"></span>
                            </div>
                            <div id="mobile-group" class="area_form m">
                                <label for="Mobile" class="mobile">
                                    Mobile
                                </label>
                                <div class="area_select">
                                    
                                    <select id="countries" class="">
                                        <option value="ca">🇨🇦</option>image.png
                                        <option value="br">🇧🇷</option>
                                    </select>

                                    <input type="text" id="mobile" name="mobile" placeholder="enter your mobile number" autocomplete="off" onkeypress="validateSignUp()">
                                </div>
                                <span class="errorData" role="alert" id="mobileError" aria-hidden="true"></span>
                            </div>
                            <input type="submit" name="submit" class="submit" value="SIGN UP">
                            <input type="hidden" name="session" value="<?php echo session_id();?>">
                            <div class="sign_up">
                                <p>Already a member? Tap to <a target="_self" href="https://thechefmelo.com/"><b>sign in.</b></a></p>
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
    </body>
</html>