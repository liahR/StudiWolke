<?php

// Die Session wird beendet

session_start();
session_destroy();
?>
<!doctype html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="../frontend/public/allgemein.css">
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>
<header>
        <div class="logo">
            <img src="../frontend/public/Logo StudiWolke.png"></a>
        </div>
 </header>

<!--Meldung zur Info über erfolgreiche Abmeldung.-->

Erfolgreich abgemeldet! Danke für deinen Besuch!

<p>
    <a href="../frontend/public/login.html">Willst du dich wieder anmelden? Hier gehts zum Login!</a>
</p>
<footer>
    <hr>
    <div class="logo">
			<a href="../frontend/public/index.php"><img src="../frontend/public/Logo StudiWolke.png"></a>
		</div>	
    <hr>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>