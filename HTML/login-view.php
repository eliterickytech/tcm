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
    <meta name="description" content="The Chef Melo Patisserie Canada">
    <meta name="keywords" content="Chef Melo, Chef Melo Canada">
    <meta name="author" content="The Chef Melo">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FFF">
    <title>Login - The Chef Melo</title>
    <link rel="stylesheet" href="css/style.css?<?php echo $time;?>">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="msapplication-TileColor" content="#FF6E00">
    <meta name="apple-mobile-web-app-title" content="The Chef Melo">
    <link rel="icon" href="https://thechefmelo.com/img/icon-192x192.png?<?php echo $time;?>" type="image/png">

    <link rel="apple-touch-icon" href="https://thechefmelo.com/img/icon-400x400.png?<?php echo $time;?>">
    <meta name="msapplication-TileImage" content="https://thechefmelo.com/img/icon-400x400.png?<?php echo $time;?>">
    
    <link rel="stylesheet" type="text/css" href="https://thechefmelo.com/css/addtohomescreen.css?<?php echo $time;?>">    
    <script type="text/javascript" src="https://thechefmelo.com/js/addtohomescreen.js?<?php echo $time;?>"></script>
    <style>
        #addHome{
            display: none;
        }
    </style>

    <script>

        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/;samesite=Strict";
            document.getElementById('addHome').style.display = 'none';
            console.log('Fechar Modal SetCookie');
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function eraseCookie(name) {   
            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }


        var controlCookie = getCookie('DontViewBox');
        if(!controlCookie){
            console.log('Dont View Modal: ' + controlCookie);
            setTimeout(function(){ 
                $('#addHome').show();
            }, 1000);
        } else {
            console.log('getCookie '  + controlCookie);
        }
        

        if ('serviceWorker' in navigator) {
        navigator.serviceWorker
            .register('./js/sw.js')
            .then(serviceWorker => {
            console.log('Service Worker registered: ' + serviceWorker);
            })
            .catch(error => {
            console.log('Error registering the Service Worker: ' + error);
            });
        }
        addToHomescreen({
            autostart: true,
            detectHomescreen: true,
            displayPace: 0,     // tempo (em min.) para mensagem ser mostrada novamente, default 1440 = 1 vez por dia
            message: "Adicione este app à sua lista de aplicativos: Clique em %icon e depois <strong>Tela de Início</strong>",
            modal: true,
            lifespan: 0,        // tempo (em seg.) para fechar automaticamente. 0 desabilita o fechamento automatico
            onShow: function () {
                console.log( "showing" );
            },
            onInit: function () {
                console.log( "initializing" );
            },
            onAdd: function () {
                console.log( "adding" );
            },
            onInstall: function () {
                console.log( "Installing" );
            },
            onCancel: function () {
                console.log( "Cancelling" );
            },
            appID: "org.cubiq.addtohome.2931",
            customPrompt: {
                title: "custom message",
                src: "https://thechefmelo.com/img/icon-96x96.png",
                cancelMsg: "go away",
                installMsg: "do it"
            }
        });
    </script>
    <script>
        var ath = addToHomescreen( {
            autostart: true,
            lifespan: 0,
            debug: "iphone",
            logging: true,
            minSessions: 0,
            onShow: function () {
                console.log( "showing" );
            },
            onInit: function () {
                console.log( "initializing" );
            },
            onAdd: function () {
                console.log( "adding" );
            },
            onInstall: function () {
                console.log( "Installing" );
            },
            onCancel: function () {
                console.log( "Cancelling" );
            },
            customCriteria: true,
            displayPace: 0,
            message: "Adicione este app à sua lista de aplicativos: Clique em %icon e depois <strong>Tela de Início</strong>",
            modal: true,
            customPrompt: {
                title: "custom message",
                src: "https://thechefmelo.com/img/icon-96x96.png",
                cancelMsg: "go away",
                installMsg: "do it"
            }
        } );

        function clearToken() {

            ath.clearSession(); // reset the user session

        }

        
    </script>

    <script>        

        // Add manifest
        const manifestLink = document.createElement('link');
        manifestLink.href = 'manifest.json';
        manifestLink.rel = 'manifest';
        document.head.appendChild(manifestLink);

        // Add meta tag for theme
        const metaThemeColor = document.createElement('meta');
        metaThemeColor.name = 'theme-color';
        metaThemeColor.content = '#ffffff';
        document.head.appendChild(metaThemeColor);

        // Add meta tag for viewport
        const metaViewport = document.createElement('meta');
        metaViewport.name = 'viewport';
        metaViewport.content = 'width=device-width, initial-scale=1, shrink-to-fit=no';
        document.head.appendChild(metaViewport);

        
    </script>

    
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
                                <input type="text" id="email" name="email" placeholder="enter your e-mail address" autocomplete="off" onkeypress="validateLogin()" onblur="validateLogin()">
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
                                <p>Forgot your password? Tap <a id="forgot" target="_self" style="color:#C0694E;" href="#"><b>here.</b></a></p>
                            </div>
                            <input type="submit" name="submit" class="submit" value="SIGN IN">
                            <input type="hidden" id="session" name="session" value="<?php echo session_id();?>">
                            <div class="sign_up">
                                <p>New here? Tap to <a target="_self" href="https://thechefmelo.com/sign-up-user.php?<?php echo $time;?>"><b>sign up.</b></a></p>
                            </div>
                        </form>
                        <style>
                            #setup_button {
                                display: block;
                            }
                        </style>
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
        <div id="addHome" class="ath-container ath-android ath-android v ath-phone ath-icon" style="transition-property: transform, opacity; transition-duration: 1.2s; transition-timing-function: ease-out; transform: translate3d(0px, 0px, 0px); font-size: 15px;">
            <img class="ath-application-icon" src="https://thechefmelo.com/img/icon-96x96.png">
            <p>Adicione este app à sua lista de aplicativos: Clique em <span class="ath-action-icon">icon</span> e depois <strong>Tela de Início</strong></p>
            <div class="ath-buttons-container">
                <p class="ath-button-close"><button onclick="setCookie('DontViewBox','yes',365)"><b>Não mostrar novamente</b></button></p>
                <p class="ath-button-later"><button onclick="CloseModal()">Talvez mais tarde</button></p>
            </div>
        </div>
        <script>
            function CloseModal(){
                document.getElementById('addHome').style.display = 'none';
                console.log('Fechar Modal');
            }
        </script>
    </body>
</html>