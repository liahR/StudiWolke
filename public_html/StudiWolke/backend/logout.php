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

<!--Meldung zur Info über erfolgreiche Abmeldung.-->

Erfolgreich abgemeldet! Danke für deinen Besuch!

<p>
    <a href="login.html">Willst du dich wieder anmelden? Hier gehts zum Login!</a>
</p>

</body>
</html>