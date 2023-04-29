<?php

// Die Session wird beendet

session_start();
session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>
<header>
        <div class="logo">
            <img src="Logo StudiWolke.png"></a>
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
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
    <nav>
        <ul>
            <li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>
            <li><a href="../../backend/logout.php">LOGOUT</a></li>
    
        </ul>
    </nav>	
    <hr>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>