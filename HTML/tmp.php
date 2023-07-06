<link rel="manifest" href="/manifest.json?<?php echo $time;?>">
<link rel="apple-touch-icon" href="/img/logo_small.png?<?php echo $time;?>">
<meta name="theme-color" content="#FFF">

<script type="text/javascript" language="javascript" src="/index.js?v=<?php echo $time;?>"></script>

<script type="module" src="https://cdn.jsdelivr.net/npm/@pwabuilder/pwainstall"></script>
    
<pwa-install id="installComponent"></pwa-install>
    <script async defer>
        const ref = document.getElementById("installComponent");
        ref.getInstalledStatus();
    </script>