<?php
session_start();

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="../frontend/public/allgemein.css">
    <link rel="stylesheet" type="text/css" href="../frontend/public/ansicht.css">
    <!-- Verknüpfen der CSS-Datei für den Dark-Mode -->
    <link rel="stylesheet" type="text/css" href="../src/darkmode.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <title>Start</title>
</head>
<body>

<header>
  <div class="logo">
    <img src="../frontend/public/Logo StudiWolke.png">
  </div>
</header>
<main>
<?php

$nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort=$_POST ["passwort"];


$statement = $pdo->prepare ('SELECT * FROM benutzer WHERE nutzername=:nutzername');
$statement->bindParam(':nutzername',$nutzername);

if ($statement->execute()) {
if ($row = $statement->fetch()){ 
    if (password_verify ($passwort, $row["passwort"]))
    {
        $_SESSION["benutzer_id"] = $row["benutzer_id"];
        header("Location: ../frontend/public/index.php");
    }
    else
    {
        echo "Passwort oder Nutzername falsch";
        echo "<p><a href= '../frontend/public/login.html'> Erneut versuchen</a></p>";
    }}
else
{
    echo "something went wrong";
}}
else {
    echo "Fehler";
}

?>
</main>
 <footer>
    <div class="footer_copyright"><br><br><br><br> &copy; 2023 StudiWolke GmbH & Co. KG</div>
</footer>

</body>
</html>

